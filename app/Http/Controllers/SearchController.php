<?php

namespace App\Http\Controllers;

use App\Models\Agency\Agency;
use App\Models\Brand\Brand;
use App\Models\Commercial\Commercial;
use App\Models\Creative\Creative;
use App\Models\News\News;
use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        if (!is_string($q)) {
            $q = '';
        }

        $ads = collect();
        $brands = collect();
        $agencies = collect();
        $creatives = collect();
        $news = collect();

        if (!empty($q)) {
            if (mb_strlen($q) > 1) {
                $query = Commercial::joinMl()->where('ml.title', 'LIKE', '%'.$q.'%')->orWhere('ml.description', 'LIKE', '%'.$q.'%');
                $adIds = DB::table('commercial_tags')->where('tag', $q)->lists('commercial_id');
                if (!empty($adIds)) {
                    $query->orWhereIn('commercials.id', $adIds);
                }
                $ads = $query->latest()->get();

                $brands = Brand::joinMl()->where('ml.title', 'LIKE', '%'.$q.'%')->orWhere('ml.sub_title', 'LIKE', '%'.$q.'%')->latest()->get();

                $agencies = Agency::joinMl()->where('ml.title', 'LIKE', '%'.$q.'%')->orWhere('ml.sub_title', 'LIKE', '%'.$q.'%')->latest()->get();

                $creatives = Creative::joinMl()->where('ml.title', 'LIKE', '%'.$q.'%')->latest()->get();

                $query = News::joinMl()->where('ml.title', 'LIKE', '%'.$q.'%')->orWhere('ml.description', 'LIKE', '%'.$q.'%');
                $newsIds = DB::table('news_tags')->where('tag', $q)->lists('news_id');
                if (!empty($newsIds)) {
                    $query->orWhereIn('news.id', $newsIds);
                }
                $news = $query->latest()->get();
            }
        }

        return view('search.index')->with([
            'ads' => $ads,
            'brands' => $brands,
            'agencies' => $agencies,
            'creatives' => $creatives,
            'news' => $news,
            'q' => $q
        ]);
    }
}