<?php

namespace App\Models\Commercial;

use App\Core\Image\SaveImage;
use DB;

class CommercialManager
{
    public function store($data)
    {
        $data = $this->processSave($data);
        $commercial = new Commercial($data);
        SaveImage::save($data['image'], $commercial);
        SaveImage::save($data['image_print'], $commercial, 'image_print');

        DB::transaction(function() use($data, $commercial) {
            $commercial->save();
            $this->storeMl($data['ml'], $commercial);
            $this->updateTags($data['tags'], $commercial);
        });
    }

    public function update($id, $data)
    {
        $commercial = Commercial::where('id', $id)->firstOrFail();
        $data = $this->processSave($data);
        SaveImage::save($data['image'], $commercial);
        SaveImage::save($data['image_print'], $commercial, 'image_print');

        DB::transaction(function() use($data, $commercial) {
            $commercial->update($data);
            $this->updateMl($data['ml'], $commercial);
            $this->updateTags($data['tags'], $commercial, true);
        });
    }

    protected function processSave($data)
    {
        if (!isset($data['featured'])) {
            $data['featured'] = Commercial::NOT_FEATURED;
        }
        if (!isset($data['top'])) {
            $data['top'] = Commercial::NOT_TOP;
        }
        if (!isset($data['tags'])) {
            $data['tags'] = [];
        }
        return $data;
    }

    protected function storeMl($data, Commercial $commercial)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new CommercialMl($mlData);
        }
        $commercial->ml()->saveMany($ml);
    }

    protected function updateMl($data, Commercial $commercial)
    {
        CommercialMl::where('id', $commercial->id)->delete();
        $this->storeMl($data, $commercial);
    }

    protected function updateTags($data, Commercial $commercial, $editMode = false)
    {
        if ($editMode) {
            CommercialTag::where('commercial_id', $commercial->id)->delete();
        }
        $tags = [];
        foreach ($data as $value) {
            $tags[] = new CommercialTag($value);
        }
        if (!empty($tags)) {
            $commercial->tags()->saveMany($tags);
        }
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Commercial::where('id', $id)->delete();
            CommercialMl::where('id', $id)->delete();
        });
    }
}