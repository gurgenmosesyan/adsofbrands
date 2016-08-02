<?php

namespace App\Models\Homepage;

use App\Core\Image\SaveImage;
use DB;

class Manager
{
    public function update($data)
    {
        $homepage = Homepage::first();
        DB::transaction(function() use($data, $homepage) {

            if ($homepage == null) {
                $homepage = new Homepage();
                SaveImage::save($data['about_image'], $homepage, 'about_image');
                SaveImage::save($data['offers_image'], $homepage, 'offers_image');
                $homepage->save();
            } else {
                $aboutImage = SaveImage::save($data['about_image'], $homepage, 'about_image');
                $offersImage = SaveImage::save($data['offers_image'], $homepage, 'offers_image');
                Homepage::getProcessor()->delete();
                $homepage = new Homepage();
                $homepage->about_image = $aboutImage;
                $homepage->offers_image = $offersImage;
                $homepage->save();
            }

            $this->updateMl($data['ml']);
        });
    }

    protected function updateMl($data)
    {
        HomepageMl::getProcessor()->delete();
        $ml = [];
        foreach ($data as $lngId => $value) {
            $value['lng_id'] = $lngId;
            $ml[] = $value;
        }
        HomepageMl::insert($ml);
    }
}