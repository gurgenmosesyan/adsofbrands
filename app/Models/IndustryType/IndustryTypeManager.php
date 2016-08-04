<?php

namespace App\Models\IndustryType;

use DB;

class IndustryTypeManager
{
    public function store($data)
    {
        $industryType = new IndustryType();

        DB::transaction(function() use($data, $industryType) {
            $industryType->save();
            $this->storeMl($data['ml'], $industryType);
        });
    }

    public function update($id, $data)
    {
        $industryType = IndustryType::where('id', $id)->firstOrFail();

        DB::transaction(function() use($data, $industryType) {
            $industryType->save();
            $this->updateMl($data['ml'], $industryType);
        });
    }

    protected function storeMl($data, IndustryType $industryType)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new IndustryTypeMl($mlData);
        }
        $industryType->ml()->saveMany($ml);
    }

    protected function updateMl($data, IndustryType $industryType)
    {
        IndustryTypeMl::where('id', $industryType->id)->delete();
        $this->storeMl($data, $industryType);
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            IndustryType::where('id', $id)->delete();
            IndustryTypeMl::where('id', $id)->delete();
        });
    }
}