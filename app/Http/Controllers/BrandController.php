<?php

namespace App\Http\Controllers;

use App\Models\Brand\Brand;

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
}