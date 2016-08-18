<?php

namespace App\Models\FooterMenu;

use DB;

class FooterMenuManager
{
    public function store($data)
    {
        $menu = new FooterMenu();

        DB::transaction(function() use($data, $menu) {
            $menu->save();
            $this->storeMl($data['ml'], $menu);
        });
    }

    public function update($id, $data)
    {
        $menu = FooterMenu::where('id', $id)->firstOrFail();

        DB::transaction(function() use($data, $menu) {
            $menu->save();
            $this->updateMl($data['ml'], $menu);
        });
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
        });
    }
}