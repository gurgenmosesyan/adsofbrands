<?php

namespace App\Models\MediaType;

use App\Core\Image\SaveImage;
use DB;

class MediaTypeManager
{
    public function store($data)
    {
        $mediaType = new MediaType();
        SaveImage::save($data['icon'], $mediaType, 'icon');

        DB::transaction(function() use($data, $mediaType) {
            $mediaType->save();
            $this->storeMl($data['ml'], $mediaType);
        });
    }

    public function update($id, $data)
    {
        $mediaType = MediaType::where('id', $id)->firstOrFail();
        SaveImage::save($data['icon'], $mediaType, 'icon');

        DB::transaction(function() use($data, $mediaType) {
            $mediaType->save();
            $this->updateMl($data['ml'], $mediaType);
        });
    }

    protected function storeMl($data, MediaType $mediaType)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new MediaTypeMl($mlData);
        }
        $mediaType->ml()->saveMany($ml);
    }

    protected function updateMl($data, MediaType $mediaType)
    {
        MediaTypeMl::where('id', $mediaType->id)->delete();
        $this->storeMl($data, $mediaType);
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            MediaType::where('id', $id)->delete();
            MediaTypeMl::where('id', $id)->delete();
        });
    }
}