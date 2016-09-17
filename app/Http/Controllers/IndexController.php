<?php

namespace App\Http\Controllers;

use App\Models\Commercial\Commercial;
use App\Models\Agency\Agency;
use App\Models\Brand\Brand;
use App\Models\News\News;
use App\Models\Banner\BannerManager;

class IndexController extends Controller
{
    public function index()
    {
        $featuresAds = Commercial::joinMl()->where('featured', Commercial::FEATURED)->latest()->take(15)->get();
        $topAds = Commercial::joinMl()->where('top', Commercial::TOP)->latest()->take(15)->get();
        $topAgencies = Agency::joinMl()->where('top', Agency::TOP)->latest()->take(15)->get();
        $topBrands = Brand::joinMl()->where('top', Brand::TOP)->latest()->take(15)->get();
        $latestNews = News::joinMl()->latest()->take(3)->get();
        $banners = BannerManager::getBanners();

        return view('index.index')->with([
            'featuresAds' => $featuresAds,
            'topAds' => $topAds,
            'topAgencies' => $topAgencies,
            'topBrands' => $topBrands,
            'latestNews' => $latestNews,
            'banners' => $banners
        ]);
    }
}