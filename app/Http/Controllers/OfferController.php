<?php

namespace App\Http\Controllers;

use App\Models\Facility\FacilityMl;
use App\Models\Offer\Offer;
use App\Models\Offer\OfferText;
use App\Models\Slider\Slider;
use App\Models\Background\Background;

class OfferController extends Controller
{
    public function all()
    {
        $background = Background::first();
        if (empty($background->offer)) {
            $background = $background->getImage('homepage');
        } else {
            $background = $background->getImage('offer');
        }
        $offerText = OfferText::current()->first();
        $offers = Offer::joinMl()->ordered()->get();

        $slider = FacilityMl::select('facilities_ml.id','facilities_ml.title')
            ->join('slider', function($query) {
                $query->on('slider.facility_id', '=', 'facilities_ml.id')->where('slider.key', '=', Slider::KEY_OFFERS);
            })->where('facilities_ml.lng_id', cLng('id'))->with('first_image')->orderBy('slider.sort_order', 'asc')->get();

        return view('offer.all')->with([
            'background' => $background,
            'offerText' => $offerText,
            'offers' => $offers,
            'slider' => $slider
        ]);
    }
}