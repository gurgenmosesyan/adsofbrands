<?php

namespace App\Models\FooterMenu;

use App\Core\Language\Language;
use Cache;
use DB;

class FooterMenuManager
{
    public function store($data)
    {
        $data = $this->processSave($data);
        $menu = new FooterMenu($data);

        DB::transaction(function() use($data, $menu) {
            $menu->save();
            $this->storeMl($data['ml'], $menu);
            $this->removeCache();
        });
    }

    public function update($id, $data)
    {
        $menu = FooterMenu::where('id', $id)->firstOrFail();
        $data = $this->processSave($data);

        DB::transaction(function() use($data, $menu) {
            $menu->update($data);
            $this->updateMl($data['ml'], $menu);
            $this->removeCache();
        });
    }

    protected function processSave($data)
    {
        if (!isset($data['static'])) {
            $data['static'] = FooterMenu::IS_NOT_STATIC;
        }
        if (!isset($data['hidden'])) {
            $data['hidden'] = FooterMenu::NOT_HIDDEN;
        }
        return $data;
    }

    protected function storeMl($data, FooterMenu $menu)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new FooterMenuMl($mlData);
        }
        $menu->ml()->saveMany($ml);
    }

    protected function updateMl($data, FooterMenu $menu)
    {
        FooterMenuMl::where('id', $menu->id)->delete();
        $this->storeMl($data, $menu);
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            FooterMenu::where('id', $id)->delete();
            FooterMenuMl::where('id', $id)->delete();
            $this->removeCache();
        });
    }

    protected function removeCache()
    {
        $languages = Language::all();
        foreach ($languages as $lng) {
            Cache::forget('footer_menu_'.$lng->id);
        }
    }

    /****************************************************************/

    public static function get()
    {
        $cacheKey = 'footer_menu_'.cLng('id');
        $menu = Cache::get($cacheKey);
        if ($menu == null) {
            $menu = FooterMenu::joinMl()->visible()->ordered()->get();
            Cache::forever($cacheKey, $menu);
        }
        return $menu;
    }
}