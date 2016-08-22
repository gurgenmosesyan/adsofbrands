<?php

namespace App\Models\Creative;

use App\Core\Image\SaveImage;
use DB;

class CreativeManager
{
    public function store($data)
    {
        $creative = new Creative($data);
        $creative->reg_type = Creative::REG_TYPE_ADMIN;
        $creative->status = '';
        SaveImage::save($data['image'], $creative);
        SaveImage::save($data['cover'], $creative, 'cover');

        DB::transaction(function() use($data, $creative) {
            $creative->save();
            $this->storeMl($data['ml'], $creative);
        });
    }

    public function update($id, $data)
    {
        $creative = Creative::where('id', $id)->firstOrFail();
        SaveImage::save($data['image'], $creative);
        SaveImage::save($data['cover'], $creative, 'cover');

        DB::transaction(function() use($data, $creative) {
            $creative->update($data);
            $this->updateMl($data['ml'], $creative);
        });
    }

    protected function storeMl($data, Creative $creative)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new CreativeMl($mlData);
        }
        $creative->ml()->saveMany($ml);
    }

    protected function updateMl($data, Creative $creative)
    {
        CreativeMl::where('id', $creative->id)->delete();
        $this->storeMl($data, $creative);
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Creative::where('id', $id)->delete();
            CreativeMl::where('id', $id)->delete();
        });
    }
}