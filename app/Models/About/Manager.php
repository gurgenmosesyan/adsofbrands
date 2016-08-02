<?php

namespace App\Models\About;

use DB;

class Manager
{
    public function update($data)
    {
        DB::transaction(function() use($data) {

            About::getProcessor()->delete();
            $ml = [];
            foreach ($data['ml'] as $lngId => $value) {
                $value['lng_id'] = $lngId;
                $ml[] = $value;
            }
            About::insert($ml);
        });
    }
}