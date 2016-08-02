<?php

namespace App\Models\Guest;

use App\Core\Image\SaveImage;
use DB;

class Manager
{
    public function store($data)
    {
        $guest = new Guest();
        SaveImage::save($data['image'], $guest);
        DB::transaction(function() use($data, $guest) {
            $guest->save();
            $this->storeMl($data['ml'], $guest);
        });
    }

    public function update($id, $data)
    {
        $guest = Guest::findOrFail($id);
        SaveImage::save($data['image'], $guest);
        DB::transaction(function() use($data, $guest) {
            $guest->update();
            $this->updateMl($data['ml'], $guest);
        });
    }

    protected function storeMl($data, Guest $guest)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $mlData['image'] = $guest->image;
            $ml[] = new GuestMl($mlData);
        }
        $guest->ml()->saveMany($ml);
    }

    protected function updateMl($data, Guest $guest)
    {
        GuestMl::where('id', $guest->id)->delete();
        $this->storeMl($data, $guest);
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Guest::where('id', $id)->delete();
            GuestMl::where('id', $id)->delete();
        });
    }
}