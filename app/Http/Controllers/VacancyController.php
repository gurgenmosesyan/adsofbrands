<?php

namespace App\Http\Controllers;

use App\Models\Vacancy\Vacancy;
use App\Models\Background\Background;

class VacancyController extends Controller
{
    public function all()
    {
        $background = Background::first();
        $vacancies = Vacancy::select('vacancies.id','vacancies.published_at','ml.title','ml.function')->joinMl()->latest()->get();

        return view('vacancy.all')->with([
            'background' => $background->getImage('homepage'),
            'vacancies' => $vacancies
        ]);
    }

    public function index($lngCode, $id)
    {
        $background = Background::first();
        $vacancy = Vacancy::select('ml.*','vacancies.asap','vacancies.published_at','vacancies.start_date','vacancies.open_date','vacancies.deadline')
            ->joinMl()->where('vacancies.id', $id)->firstOrFail();

        return view('vacancy.index')->with([
            'background' => $background->getImage('homepage'),
            'vacancy' => $vacancy
        ]);
    }
}