<?php

namespace App\Http\Controllers;

use App\Models\Commercial\Commercial;
use App\Models\Agency\Agency;
use App\Models\Brand\Brand;
use App\Models\News\News;

class IndexController extends Controller
{
    public function index()
    {
        $featuresAds = Commercial::joinMl()->where('featured', Commercial::FEATURED)->latest()->get();
        $topAds = Commercial::joinMl()->where('top', Commercial::TOP)->latest()->get();
        $topAgencies = Agency::joinMl()->where('top', Agency::TOP)->latest()->get();
        $topBrands = Brand::joinMl()->where('top', Brand::TOP)->latest()->get();
        $latestNews = News::joinMl()->latest()->take(3)->get();

        return view('index.index')->with([
            'featuresAds' => $featuresAds,
            'topAds' => $topAds,
            'topAgencies' => $topAgencies,
            'topBrands' => $topBrands,
            'latestNews' => $latestNews
        ]);
    }
}