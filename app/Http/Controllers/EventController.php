<?php

namespace App\Http\Controllers;

use App\Models\Facility\FacilityMl;
use App\Models\Event\Event;
use App\Models\Event\EventText;
use App\Models\Slider\Slider;
use App\Models\Background\Background;

class EventController extends Controller
{
    public function all()
    {
        $background = Background::first();
        if (empty($background->offer)) {
            $background = $background->getImage('homepage');
        } else {
            $background = $background->getImage('event');
        }

        $eventText = EventText::current()->first();
        $events = Event::joinMl()->ordered()->get();

        $slider = FacilityMl::select('facilities_ml.id','facilities_ml.title')
            ->join('slider', function($query) {
                $query->on('slider.facility_id', '=', 'facilities_ml.id')->where('slider.key', '=', Slider::KEY_EVENTS);
            })->where('facilities_ml.lng_id', cLng('id'))->with('first_image')->orderBy('slider.sort_order', 'asc')->get();

        return view('event.all')->with([
            'background' => $background,
            'eventText' => $eventText,
            'events' => $events,
            'slider' => $slider
        ]);
    }
}