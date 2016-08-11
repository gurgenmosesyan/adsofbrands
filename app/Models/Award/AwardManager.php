<?php

namespace App\Models\Award;

use DB;

class AwardManager
{
    public function store($data)
    {
        $award = new Award($data);

        DB::transaction(function() use($data, $award) {
            $award->save();
            $this->storeMl($data['ml'], $award);
        });
    }

    public function update($id, $data)
    {
        $award = Award::where('id', $id)->firstOrFail();

        DB::transaction(function() use($data, $award) {
            $award->update($data);
            $this->updateMl($data['ml'], $award);
        });
    }

    protected function storeMl($data, Award $award)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new AwardMl($mlData);
        }
        $award->ml()->saveMany($ml);
    }

    protected function updateMl($data, Award $award)
    {
        AwardMl::where('id', $award->id)->delete();
        $this->storeMl($data, $award);
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Award::where('id', $id)->delete();
            AwardMl::where('id', $id)->delete();
        });
    }
}