<?php

namespace App\Models\ShortLink;

use Cache;
use DB;

class ShortLinkManager
{
    public static function all()
    {
        $cacheKey = 'short_links';
        $data = Cache::get($cacheKey);
        if ($data === null) {
            $data = ShortLink::all()->keyBy('short_link');
            Cache::forever($cacheKey, $data);
        }
        return $data;
    }

    public function store($data)
    {
        $shortLink = new ShortLink($data);

        DB::transaction(function() use($data, $shortLink) {
            $shortLink->save();
            $this->removeCache();
        });
    }

    public function update($id, $data)
    {
        $shortLink = ShortLink::where('id', $id)->firstOrFail();

        DB::transaction(function() use($data, $shortLink) {
            $shortLink->update($data);
            $this->removeCache();
        });
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            ShortLink::where('id', $id)->delete();
            $this->removeCache();
        });
    }

    protected function removeCache()
    {
        Cache::forget('short_links');
    }
}