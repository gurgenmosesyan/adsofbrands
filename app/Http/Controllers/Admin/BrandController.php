<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Brand\Brand;
use App\Models\Brand\BrandManager;
use App\Models\Brand\BrandSearch;
use App\Http\Requests\Admin\BrandRequest;
use App\Core\Language\Language;
use App\Models\Category\Category;
use App\Models\Country\Country;

class BrandController extends BaseController
{
    protected $manager = null;

    public function __construct(BrandManager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.brand.index');
    }

    public function index(BrandSearch $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $brand = new Brand();
        $countries = Country::joinMl()->get();
        $categories = Category::joinMl()->get();
        $languages = Language::all();

        return view('admin.brand.edit')->with([
            'brand' => $brand,
            'countries' => $countries,
            'categories' => $categories,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(BrandRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $brand = Brand::where('id', $id)->firstOrFail();
        $countries = Country::joinMl()->get();
        $categories = Category::joinMl()->get();
        $languages = Language::all();

        return view('admin.brand.edit')->with([
            'brand' => $brand,
            'countries' => $countries,
            'categories' => $categories,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(BrandRequest $request, $id)
    {
        $this->manager->update($id, $request->all());
        return $this->api('OK');
    }

    public function delete($id)
    {
        $this->manager->delete($id);
        return $this->api('OK');
    }
}