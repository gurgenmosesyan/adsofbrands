<?php

namespace App\Http\Controllers;

use App\Models\Background\Background;
use App\Models\About\About;
use App\Models\Guest\GuestMl;
use App\Models\Partner\Partner;
use App\Models\Vacancy\Vacancy;

class AboutController extends Controller
{
    public function index()
    {
        $background = Background::first();
        if (empty($background->about)) {
            $background = $background->getImage('homepage');
        } else {
            $background = $background->getImage('about');
        }
        $about = About::current()->first();
        $guests = GuestMl::current()->orderBy('id', 'desc')->get();
        $partners = Partner::orderBy('id', 'desc')->get();
        $vacancies = Vacancy::select('vacancies.id','vacancies.published_at','ml.title','ml.function')->joinMl()->latest()->take(3)->get();

        return view('about.index')->with([
            'background' => $background,
            'about' => $about,
            'guests' => $guests,
            'partners' => $partners,
            'vacancies' => $vacancies
        ]);
    }
}