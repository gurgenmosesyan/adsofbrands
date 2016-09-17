<?php

namespace App\Models\Banner;

use App\Core\Image\SaveImage;
use Cache;
use DB;

class BannerManager
{
    public static function getBanners($key = null)
    {
        $cacheKey = 'banners';
        $banners = Cache::get($cacheKey);
        if ($banners == null) {
            $banners = Banner::all()->keyBy('key');
            Cache::forever($cacheKey, $banners);
        }
        return $key == null ? $banners : $banners[$key];
    }

    public function update($id, $data)
    {
        $banner = Banner::where('id', $id)->firstOrFail();
        SaveImage::save($data['image'], $banner);

        DB::transaction(function() use($banner, $data) {

            $banner->update($data);

            Cache::forget('banners');
        });
    }
}