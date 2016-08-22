<?php

namespace App\Models\Brand;

use App\Core\Image\SaveImage;
use DB;

class BrandManager
{
    public function store($data)
    {
        $brand = new Brand($data);
        $brand->reg_type = Brand::REG_TYPE_ADMIN;
        $brand->status = '';
        SaveImage::save($data['image'], $brand);
        SaveImage::save($data['cover'], $brand, 'cover');

        DB::transaction(function() use($data, $brand) {
            $brand->save();
            $this->storeMl($data['ml'], $brand);
        });
    }

    public function update($id, $data)
    {
        $brand = Brand::where('id', $id)->firstOrFail();
        SaveImage::save($data['image'], $brand);
        SaveImage::save($data['cover'], $brand, 'cover');

        DB::transaction(function() use($data, $brand) {
            $brand->update($data);
            $this->updateMl($data['ml'], $brand);
        });
    }

    protected function storeMl($data, Brand $brand)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new BrandMl($mlData);
        }
        $brand->ml()->saveMany($ml);
    }

    protected function updateMl($data, Brand $brand)
    {
        BrandMl::where('id', $brand->id)->delete();
        $this->storeMl($data, $brand);
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Brand::where('id', $id)->delete();
            BrandMl::where('id', $id)->delete();
        });
    }
}