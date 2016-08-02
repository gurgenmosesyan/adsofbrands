<?php

namespace App\Models\Partner;

use App\Core\Image\SaveImage;
use DB;

class Manager
{
    public function store($data)
    {
        $partner = new Partner($data);
        SaveImage::save($data['image'], $partner);
        $partner->save();
    }

    public function update($id, $data)
    {
        $partner = Partner::findOrFail($id);
        SaveImage::save($data['image'], $partner);
        $partner->update($data);
    }

    public function delete($id)
    {
        Partner::where('id', $id)->delete();
    }
}