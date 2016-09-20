<?php

namespace App\Models\Brand;

use App\Models\Account\AccountManager;
use App\Core\Image\SaveImage;
use Auth;
use DB;

class BrandManager
{
    public function store($data)
    {
        $data = $this->processSave($data);
        $brand = new Brand($data);
        if (Auth::guard('admin')->guest()) {
            $brand->top = Brand::NOT_TOP;
            $brand->blocked = Brand::NOT_BLOCKED;
        }
        $accountManager = new AccountManager();
        $brand->hash = $accountManager->generateRandomUniqueHash();
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
        $data = $this->processSave($data);
        if (!empty($data['password'])) {
            $brand->password = bcrypt($data['password']);
        }
        if (Auth::guard('admin')->guest()) {
            $data['top'] = $brand->top;
            $data['blocked'] = $brand->blocked;
        }
        SaveImage::save($data['image'], $brand);
        SaveImage::save($data['cover'], $brand, 'cover');

        DB::transaction(function() use($data, $brand) {
            $brand->update($data);
            $this->updateMl($data['ml'], $brand);
        });
    }

    protected function processSave($data)
    {
        if (!isset($data['top'])) {
            $data['top'] = Brand::NOT_TOP;
        }
        if (!isset($data['blocked'])) {
            $data['blocked'] = Brand::NOT_BLOCKED;
        }
        $data['active'] = Brand::ACTIVE;
        return $data;
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