<?php

namespace App\Http\Controllers;

use App\Models\Agency\Agency;
use App\Models\Brand\Brand;
use App\Models\Category\CategoryMl;
use App\Models\Country\CountryMl;
use Illuminate\Http\Request;
use DB;

class BrandController extends Controller
{
    public function all(Request $request)
    {
        $countries = CountryMl::current()->get();
        $categories = CategoryMl::current()->get();

        $countryId = $request->input('country');
        $categoryId = $request->input('category');

        $query = Brand::joinMl();
        if (!empty($countryId)) {
            $query->where('brands.country_id', $countryId);
        }
        if (!empty($categoryId)) {
            $query->where('brands.category_id', $categoryId);
        }
        $brands = $query->latest()->paginate(42);

        return view('brand.all')->with([
            'countries' => $countries,
            'categories' => $categories,
            'countryId' => $countryId,
            'categoryId' => $categoryId,
            'brands' => $brands
        ]);
    }

    public function index($lngCode, $alias, $id, Request $request)
    {
        $brand = Brand::joinMl()->where('brands.id', $id)->firstOrFail();
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brands/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'ads';
        $scroll = $request->input('ads');
        $items = $brand->commercials()->select('commercials.id','commercials.alias','commercials.image','commercials.rating','commercials.comments_count','commercials.views_count','ml.title')->joinMl()->latest()->paginate(42);
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'items' => $items,
            'scroll' => $scroll
        ]);
    }

    public function creatives($lngCode, $alias, $id)
    {
        $brand = Brand::joinMl()->where('brands.id', $id)->firstOrFail();
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brands/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'creatives';
        $items = $brand->creatives()->joinMl()->latest()->paginate(42);
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'items' => $items,
            'scroll' => true
        ]);
    }

    public function awards($lngCode, $alias, $id)
    {
        $brand = Brand::joinMl()->where('brands.id', $id)->firstOrFail();
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brands/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'awards';
        $awards = $brand->awards()->joinMl()->orderBy('awards.year', 'desc')->get();
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'awards' => $awards,
            'scroll' => true
        ]);
    }

    public function vacancies($lngCode, $alias, $id)
    {
        $brand = Brand::joinMl()->where('brands.id', $id)->firstOrFail();
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brands/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'vacancies';
        $vacancies = $brand->vacancies()->joinMl()->latest()->get();
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'vacancies' => $vacancies,
            'scroll' => true
        ]);
    }

    public function news($lngCode, $alias, $id)
    {
        $brand = Brand::joinMl()->where('brands.id', $id)->firstOrFail();
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brands/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'news';
        $news = $brand->news()->select('news.id','news.alias','news.image','ml.title','ml.description')->joinMl()->latest()->paginate(12);
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'news' => $news,
            'scroll' => true
        ]);
    }

    public function agencies($lngCode, $alias, $id)
    {
        $brand = Brand::joinMl()->where('brands.id', $id)->firstOrFail();
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brands/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'agencies';
        $agencyIds = DB::table('commercial_brands')->join('commercial_agencies', function($query) {
            $query->on('commercial_agencies.commercial_id', '=', 'commercial_brands.commercial_id');
        })->where('commercial_brands.brand_id', $brand->id)->lists('commercial_agencies.agency_id');
        $items = Agency::joinMl()->whereIn('agencies.id', $agencyIds)->latest()->paginate(42);
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'items' => $items,
            'scroll' => true
        ]);
    }

    public function about($lngCode, $alias, $id)
    {
        $brand = Brand::joinMl()->where('brands.id', $id)->firstOrFail();
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brands/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'about';
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'scroll' => true
        ]);
    }

    public function branches($lngCode, $alias, $id)
    {
        $brand = Brand::joinMl()->where('brands.id', $id)->firstOrFail();
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brands/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'contacts';
        $branches = $brand->branches()->joinMl()->latest()->get();
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'branches' => $branches,
            'scroll' => true
        ]);
    }
}