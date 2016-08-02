<?php

namespace App\Models\Facility;

use App\Core\Image\SaveImage;
use DB;

class Manager
{
    public function store($data)
    {
        $data = $this->processSave($data);
        $facility = new Facility($data);
        DB::transaction(function() use($data, $facility) {
            $facility->save();
            $this->storeMl($data['ml'], $facility);
            $this->storeImages($data['images'], $facility);
        });
    }

    public function update($id, $data)
    {
        $facility = Facility::findOrFail($id);
        $data = $this->processSave($data);
        DB::transaction(function() use($data, $facility) {
            $facility->update($data);
            $this->updateMl($data['ml'], $facility);
            $this->updateImages($data['images'], $facility);
        });
    }

    protected function storeMl($data, Facility $facility)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new FacilityMl($mlData);
        }
        $facility->ml()->saveMany($ml);
    }

    protected function updateMl($data, Facility $facility)
    {
        FacilityMl::where('id', $facility->id)->delete();
        $this->storeMl($data, $facility);
    }

    protected function processSave($data)
    {
        if (!isset($data['images'])) {
            $data['images'] = [];
        }
        return $data;
    }

    protected function storeImages($data, Facility $facility)
    {
        $images = [];
        $i = 0;
        foreach ($data as $value) {
            $images[$i] = new FacilityImage(['show_status' => Facility::STATUS_ACTIVE]);
            SaveImage::save($value['image'], $images[$i]);
            $i++;
        }
        if (!empty($images)) {
            $facility->images()->saveMany($images);
        }
    }

    protected function updateImages($data, Facility $facility)
    {
        FacilityImage::where('facility_id', $facility->id)->update(['show_status' => Facility::STATUS_DELETED]);
        $newImages = [];
        foreach ($data as $value) {
            if (empty($value['id'])) {
                $newImages[] = $value;
            } else {
                $facilityImage = FacilityImage::findOrFail($value['id']);
                $facilityImage->show_status = Facility::STATUS_ACTIVE;
                $facilityImage->save();
            }
        }
        if (!empty($newImages)) {
            $this->storeImages($newImages, $facility);
        }
        $deletedImages = FacilityImage::where('facility_id', $facility->id)->where('show_status', Facility::STATUS_DELETED)->get();
        foreach ($deletedImages as $deletedImage) {
            $imgPath = public_path($deletedImage->getStorePath().'/'.$deletedImage->image);
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
        }
        FacilityImage::where('facility_id', $facility->id)->where('show_status', Facility::STATUS_DELETED)->delete();
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Facility::where('id', $id)->delete();
            FacilityMl::where('id', $id)->delete();
            FacilityImage::where('facility_id', $id)->delete();
        });
    }
}