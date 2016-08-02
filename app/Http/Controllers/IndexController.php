<?php

namespace App\Http\Controllers;

use App\Models\Homepage\Homepage;
use App\Models\Homepage\HomepageMl;
use App\Models\Accommodation\Accommodation;
use App\Models\Background\Background;

class IndexController extends Controller
{
    public function index()
    {
        $background = Background::first();
        $homepage = Homepage::first();
        $homepageMl = HomepageMl::where('lng_id', cLng('id'))->first();
        $accommodations = Accommodation::joinMl()->ordered()->with('images')->get();

        return view('index.index')->with([
            'background' => $background->getImage('homepage'),
            'homepage' => $homepage,
            'homepageMl' => $homepageMl,
            'accommodations' => $accommodations
        ]);
    }
}