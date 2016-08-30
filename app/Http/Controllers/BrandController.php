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

        return view('brand.index')->with([
            'brand' => $brand
        ]);
    }
}