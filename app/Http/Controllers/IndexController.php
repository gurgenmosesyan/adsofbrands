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
        $featuresAds = Commercial::joinMl()->where('featured', Commercial::FEATURED)->get();
        $topAds = Commercial::joinMl()->where('top', Commercial::TOP)->get();
        $topRatedAgencies = Agency::joinMl()->orderBy('rating', 'desc')->take(25)->get();
        $topBrands = Brand::joinMl()->where('top', Brand::TOP)->get();
        $latestNews = News::joinMl()->latest()->take(3)->get();

        return view('index.index')->with([
            'featuresAds' => $featuresAds,
            'topAds' => $topAds,
            'topRatedAgencies' => $topRatedAgencies,
            'topBrands' => $topBrands,
            'latestNews' => $latestNews
        ]);
    }
}