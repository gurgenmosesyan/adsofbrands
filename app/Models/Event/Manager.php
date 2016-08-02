<?php

namespace App\Models\Event;

use DB;

class Manager
{
    public function store($data)
    {
        $event = new Event($data);
        DB::transaction(function() use($data, $event) {
            $event->save();
            $this->storeMl($data['ml'], $event);
        });
    }

    public function update($id, $data)
    {
        $event = Event::findOrFail($id);
        DB::transaction(function() use($data, $event) {
            $event->update($data);
            $this->updateMl($data['ml'], $event);
        });
    }

    protected function storeMl($data, Event $event)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new EventMl($mlData);
        }
        $event->ml()->saveMany($ml);
    }

    protected function updateMl($data, Event $event)
    {
        EventMl::where('id', $event->id)->delete();
        $this->storeMl($data, $event);
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Event::where('id', $id)->delete();
            EventMl::where('id', $id)->delete();
        });
    }

    public function updateText($data)
    {
        DB::transaction(function() use($data) {
            EventText::getProcessor()->delete();
            $ml = [];
            foreach ($data['ml'] as $lngId => $value) {
                $value['lng_id'] = $lngId;
                $ml[] = $value;
            }
            EventText::insert($ml);
        });
    }
}