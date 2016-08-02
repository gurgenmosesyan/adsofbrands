<?php

namespace App\Models\Text;

use DB;

class Manager
{
    public function update($id, $data)
    {
        $text = Text::findOrFail($id);
        DB::transaction(function() use($data, $text) {
            $text->update($data);
            $this->updateMl($data['ml'], $text);
        });
    }

    protected function storeMl($data, Text $text)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $mlData['key'] = $text->key;
            $ml[] = new TextMl($mlData);
        }
        $text->ml()->saveMany($ml);
    }

    protected function updateMl($data, Text $text)
    {
        TextMl::where('id', $text->id)->delete();
        $this->storeMl($data, $text);
    }
}