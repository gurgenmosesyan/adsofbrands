<?php

namespace App\Http\Controllers;

use App\Models\Agency\Agency;
use App\Models\Brand\Brand;
use DB;

class BrandController extends Controller
{
    public function index($lngCode, $alias, $id)
    {
        $brand = Brand::joinMl()->where('brands.id', $id)->firstOrFail();
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brand/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'ads';
        $items = $brand->commercials()->select('commercials.id','commercials.alias','commercials.image','commercials.rating','commercials.comments_count','commercials.views_count','ml.title')->joinMl()->get();
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'items' => $items
        ]);
    }

    public function creatives($lngCode, $alias, $id)
    {
        $brand = Brand::joinMl()->where('brands.id', $id)->firstOrFail();
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brand/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'creatives';
        $items = $brand->creatives()->joinMl()->get();
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'items' => $items
        ]);
    }

    public function awards($lngCode, $alias, $id)
    {
        $brand = Brand::joinMl()->where('brands.id', $id)->firstOrFail();
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brand/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'awards';
        $awards = $brand->awards()->joinMl()->orderBy('awards.year', 'desc')->get();
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'awards' => $awards
        ]);
    }

    public function vacancies($lngCode, $alias, $id)
    {
        $brand = Brand::joinMl()->where('brands.id', $id)->firstOrFail();
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brand/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'vacancies';
        $vacancies = $brand->vacancies()->joinMl()->latest()->get();
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'vacancies' => $vacancies
        ]);
    }

    public function news($lngCode, $alias, $id)
    {
        $brand = Brand::joinMl()->where('brands.id', $id)->firstOrFail();
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brand/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'news';
        $news = $brand->news()->select('news.id','news.alias','news.image','ml.title','ml.description')->joinMl()->get();
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'news' => $news
        ]);
    }

    public function agencies($lngCode, $alias, $id)
    {
        $brand = Brand::joinMl()->where('brands.id', $id)->firstOrFail();
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brand/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'agencies';
        $commercialIds = DB::table('commercial_brands')->where('brand_id', $brand->id)->lists('commercial_id');
        $items = Agency::joinMl()->join('commercial_agencies as c_agency', function($query) {
            $query->on('c_agency.agency_id', '=', 'agencies.id');
        })->whereIn('c_agency.commercial_id', $commercialIds)->get();
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'items' => $items
        ]);
    }

    public function about($lngCode, $alias, $id)
    {
        $brand = Brand::joinMl()->where('brands.id', $id)->firstOrFail();
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brand/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'about';
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias
        ]);
    }

    public function branches($lngCode, $alias, $id)
    {
        $brand = Brand::joinMl()->where('brands.id', $id)->firstOrFail();
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brand/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'contacts';
        $branches = $brand->branches()->joinMl()->latest()->get();
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'branches' => $branches
        ]);
    }
}