<?php

namespace App\Http\Controllers;

use App\Models\Facility\Facility;
use App\Models\Facility\FacilityMl;
use App\Models\Slider\Slider;
use App\Models\Background\Background;

class FacilityController extends Controller
{
    protected $background = null;

    public function __construct()
    {
        $background = Background::first();
        if (empty($background->offer)) {
            $this->background = $background->getImage('homepage');
        } else {
            $this->background = $background->getImage('facility');
        }
    }

    public function all()
    {
        $facilities = Facility::joinMl()->ordered()->get();

        $slider = FacilityMl::select('facilities_ml.id','facilities_ml.title')
            ->join('slider', function($query) {
                $query->on('slider.facility_id', '=', 'facilities_ml.id')->where('slider.key', '=', Slider::KEY_OFFERS);
            })->where('facilities_ml.lng_id', cLng('id'))->with('first_image')->orderBy('slider.sort_order', 'asc')->get();

        return view('facility.all')->with([
            'background' => $this->background,
            'facilities' => $facilities,
            'slider' => $slider
        ]);
    }

    public function index($lngCode, $id)
    {
        $facility = Facility::joinMl()->where('facilities.id', $id)->with('images')->firstOrFail();

        return view('facility.index')->with([
            'background' => $this->background,
            'facility' => $facility
        ]);
    }
}