<?php

namespace App\Models\Agency;

use App\Core\Image\SaveImage;
use DB;

class AgencyManager
{
    public function store($data)
    {
        $data = $this->processSave($data);
        $agency = new Agency($data);
        $agency->reg_type = Agency::REG_TYPE_ADMIN;
        $agency->status = '';
        SaveImage::save($data['image'], $agency);
        SaveImage::save($data['cover'], $agency, 'cover');

        DB::transaction(function() use($data, $agency) {
            $agency->save();
            $this->storeMl($data['ml'], $agency);
        });
    }

    public function update($id, $data)
    {
        $agency = Agency::where('id', $id)->firstOrFail();
        $data = $this->processSave($data);
        if (!empty($data['password'])) {
            $agency->password = bcrypt($data['password']);
        }
        SaveImage::save($data['image'], $agency);
        SaveImage::save($data['cover'], $agency, 'cover');

        DB::transaction(function() use($data, $agency) {
            $agency->update($data);
            $this->updateMl($data['ml'], $agency);
        });
    }

    protected function processSave($data)
    {
        if (!isset($data['top'])) {
            $data['top'] = Agency::NOT_TOP;
        }
        $data['active'] = Agency::ACTIVE;
        return $data;
    }

    protected function storeMl($data, Agency $agency)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new AgencyMl($mlData);
        }
        $agency->ml()->saveMany($ml);
    }

    protected function updateMl($data, Agency $agency)
    {
        AgencyMl::where('id', $agency->id)->delete();
        $this->storeMl($data, $agency);
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Agency::where('id', $id)->delete();
            AgencyMl::where('id', $id)->delete();
        });
    }
}