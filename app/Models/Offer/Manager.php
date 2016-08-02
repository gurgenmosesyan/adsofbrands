<?php

namespace App\Models\Offer;

use DB;

class Manager
{
    public function store($data)
    {
        $offer = new Offer($data);
        DB::transaction(function() use($data, $offer) {
            $offer->save();
            $this->storeMl($data['ml'], $offer);
        });
    }

    public function update($id, $data)
    {
        $offer = Offer::findOrFail($id);
        DB::transaction(function() use($data, $offer) {
            $offer->update($data);
            $this->updateMl($data['ml'], $offer);
        });
    }

    protected function storeMl($data, Offer $offer)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new OfferMl($mlData);
        }
        $offer->ml()->saveMany($ml);
    }

    protected function updateMl($data, Offer $offer)
    {
        OfferMl::where('id', $offer->id)->delete();
        $this->storeMl($data, $offer);
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Offer::where('id', $id)->delete();
            OfferMl::where('id', $id)->delete();
        });
    }

    public function updateText($data)
    {
        DB::transaction(function() use($data) {
            OfferText::getProcessor()->delete();
            $ml = [];
            foreach ($data['ml'] as $lngId => $value) {
                $value['lng_id'] = $lngId;
                $ml[] = $value;
            }
            OfferText::insert($ml);
        });
    }
}