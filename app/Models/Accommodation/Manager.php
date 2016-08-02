<?php

namespace App\Models\Accommodation;

use App\Core\Image\SaveImage;
use DB;

class Manager
{
    public function store($data)
    {
        $data = $this->processSave($data);
        $accommodation = new Accommodation($data);
        DB::transaction(function() use($data, $accommodation) {
            $accommodation->save();
            $this->storeMl($data['ml'], $accommodation);
            $this->updateDetails($data['details'], $accommodation);
            $this->storeImages($data['images'], $accommodation);
        });
    }

    public function update($id, $data)
    {
        $accommodation = Accommodation::findOrFail($id);
        $data = $this->processSave($data);
        DB::transaction(function() use($data, $accommodation) {
            $accommodation->update($data);
            $this->updateMl($data['ml'], $accommodation);
            $this->updateDetails($data['details'], $accommodation, true);
            $this->updateImages($data['images'], $accommodation);
        });
    }

    protected function storeMl($data, Accommodation $accommodation)
    {
        $ml = $facilities = [];
        foreach ($data as $lngId => $mlData) {
            $ml[] = [
                'id' => $accommodation->id,
                'lng_id' => $lngId,
                'title' => $mlData['title'],
                'text' => $mlData['text'],
                'bed_type' => $mlData['bed_type'],
            ];
            if (isset($mlData['facilities'])) {
                $index = 0;
                foreach ($mlData['facilities'] as $facility) {
                    $facilities[] = [
                        'accommodation_id' => $accommodation->id,
                        'lng_id' => $lngId,
                        'title' => $facility['title'],
                        'index' => $index,
                    ];
                    $index++;
                }
            }
        }
        if (!empty($ml)) {
            AccommodationMl::insert($ml);
        }
        if (!empty($facilities)) {
            AccommodationFacility::insert($facilities);
        }
    }

    protected function updateMl($data, Accommodation $accommodation)
    {
        AccommodationMl::where('id', $accommodation->id)->delete();
        AccommodationFacility::where('accommodation_id', $accommodation->id)->delete();
        $this->storeMl($data, $accommodation);
    }

    protected function processSave($data)
    {
        if (!isset($data['images'])) {
            $data['images'] = [];
        }
        if (!isset($data['details'])) {
            $data['details'] = [];
        }
        return $data;
    }

    protected function updateDetails($data, Accommodation $accommodation, $editMode = false)
    {
        if ($editMode) {
            AccommodationDetail::where('accommodation_id', $accommodation->id)->delete();
        }
        $details = [];
        $index = 0;
        foreach ($data as $key => $value) {
            foreach ($value['ml'] as $lngId => $ml) {
                $details[] = [
                    'accommodation_id' => $accommodation->id,
                    'lng_id' => $lngId,
                    'title' => $ml['title'],
                    'price' => $value['price'],
                    'index' => $index
                ];
            }
            $index++;
        }
        if (!empty($details)) {
            AccommodationDetail::insert($details);
        }
    }

    protected function storeImages($data, Accommodation $accommodation)
    {
        $images = [];
        $i = 0;
        foreach ($data as $value) {
            $images[$i] = new AccommodationImage(['show_status' => Accommodation::STATUS_ACTIVE]);
            SaveImage::save($value['image'], $images[$i]);
            $i++;
        }
        if (!empty($images)) {
            $accommodation->images()->saveMany($images);
        }
    }

    protected function updateImages($data, Accommodation $accommodation)
    {
        AccommodationImage::where('accommodation_id', $accommodation->id)->update(['show_status' => Accommodation::STATUS_DELETED]);
        $newImages = [];
        foreach ($data as $value) {
            if (empty($value['id'])) {
                $newImages[] = $value;
            } else {
                $accommodationImage = AccommodationImage::findOrFail($value['id']);
                $accommodationImage->show_status = Accommodation::STATUS_ACTIVE;
                $accommodationImage->save();
            }
        }
        if (!empty($newImages)) {
            $this->storeImages($newImages, $accommodation);
        }
        $deletedImages = AccommodationImage::where('accommodation_id', $accommodation->id)->where('show_status', Accommodation::STATUS_DELETED)->get();
        foreach ($deletedImages as $deletedImage) {
            $imgPath = public_path($deletedImage->getStorePath().'/'.$deletedImage->image);
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
        }
        AccommodationImage::where('accommodation_id', $accommodation->id)->where('show_status', Accommodation::STATUS_DELETED)->delete();
    }

    public function delete($id)
    {
        Accommodation::where('id', $id)->delete();
        AccommodationMl::where('id', $id)->delete();
        AccommodationImage::where('accommodation_id', $id)->delete();
        AccommodationFacility::where('accommodation_id', $id)->delete();
        AccommodationDetail::where('accommodation_id', $id)->delete();
    }
}