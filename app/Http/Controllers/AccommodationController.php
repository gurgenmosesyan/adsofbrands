<?php

namespace App\Http\Controllers;

use App\Models\Accommodation\Accommodation;
use App\Models\Background\Background;

class AccommodationController extends Controller
{
    public function index($lngCode, $id)
    {
        $background = Background::first();
        if (empty($background->accommodation)) {
            $background = $background->getImage('homepage');
        } else {
            $background = $background->getImage('accommodation');
        }
        $accommodation = Accommodation::joinMl()->where('accommodations.id', $id)->firstOrFail();
        $facilities = $accommodation->facilities()->current()->get();
        $accommodations = Accommodation::joinMl()->where('accommodations.id', '!=', $id)->ordered()->with('images')->get();

        return view('accommodation.index', [
            'background' => $background,
            'accommodation' => $accommodation,
            'facilities' => $facilities,
            'accommodations' => $accommodations
        ]);
    }
}