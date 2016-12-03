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
        $featuresAds = Commercial::joinMl()->where('featured', Commercial::FEATURED)->active()->latest()->take(15)->get();
        $topAds = Commercial::joinMl()->where('top', Commercial::TOP)->active()->latest()->take(15)->get();
        $topAgencies = Agency::joinMl()->where('top', Agency::TOP)->active()->latest()->take(15)->get();
        $topBrands = Brand::joinMl()->where('top', Brand::TOP)->active()->latest()->take(15)->get();
        $latestNews = News::joinMl()->active()->latest()->take(3)->get();
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