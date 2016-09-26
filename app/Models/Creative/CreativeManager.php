<?php

namespace App\Models\Creative;

use App\Models\Account\AccountManager;
use App\Core\Image\SaveImage;
use Auth;
use DB;

class CreativeManager
{
    public function store($data)
    {
        $data = $this->processSave($data);
        $creative = new Creative($data);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $creative->type = Creative::TYPE_BRAND;
            $creative->type_id = $brand->id;
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $creative->type = Creative::TYPE_AGENCY;
            $creative->type_id = $agency->id;
        }
        $accountManager = new AccountManager();
        $creative->hash = $accountManager->generateRandomUniqueHash();
        $creative->status = '';
        $creative->active = Creative::ACTIVE;
        SaveImage::save($data['image'], $creative);
        SaveImage::save($data['cover'], $creative, 'cover');

        DB::transaction(function() use($data, $creative) {
            $creative->save();
            $this->storeMl($data['ml'], $creative);
        });
    }

    public function update($id, $data)
    {
        $query = Creative::where('id', $id);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->where('type', Creative::TYPE_BRAND)->where('type_id', $brand->id);
            $data['type'] = Creative::TYPE_BRAND;
            $data['type_id'] = $brand->id;
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $query->where('type', Creative::TYPE_AGENCY)->where('type_id', $agency->id);
            $data['type'] = Creative::TYPE_AGENCY;
            $data['type_id'] = $agency->id;
        }
        $creative = $query->firstOrFail();
        $data = $this->processSave($data);
        if (!empty($data['password'])) {
            $creative->password = bcrypt($data['password']);
        }
        if (Auth::guard('creative')->check()) {
            $data['blocked'] = $creative->blocked;
        }
        $data['active'] = Creative::ACTIVE;
        SaveImage::save($data['image'], $creative);
        SaveImage::save($data['cover'], $creative, 'cover');

        DB::transaction(function() use($data, $creative) {
            $creative->update($data);
            $this->updateMl($data['ml'], $creative);
        });
    }

    protected function processSave($data)
    {
        if (!isset($data['blocked'])) {
            $data['blocked'] = Creative::NOT_BLOCKED;
        }
        return $data;
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
        $query = Creative::where('id', $id);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->where('type', Creative::TYPE_BRAND)->where('type_id', $brand->id);
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $query->where('type', Creative::TYPE_AGENCY)->where('type_id', $agency->id);
        }
        $creative = $query->firstOrFail();

        DB::transaction(function() use($creative) {
            $creative->delete();
            CreativeMl::where('id', $creative->id)->delete();
        });
    }
}