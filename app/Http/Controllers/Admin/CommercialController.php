<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Commercial\Commercial;
use App\Models\Commercial\CommercialManager;
use App\Models\Commercial\CommercialSearch;
use App\Http\Requests\Admin\CommercialRequest;
use App\Core\Language\Language;
use App\Models\Category\Category;
use App\Models\Country\Country;
use App\Models\IndustryType\IndustryType;
use App\Models\MediaType\MediaType;

class CommercialController extends BaseController
{
    protected $manager = null;

    public function __construct(CommercialManager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.commercial.index');
    }

    public function index(CommercialSearch $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $commercial = new Commercial();
        $mediaTypes = MediaType::joinMl()->get();
        $industryTypes = IndustryType::joinMl()->get();
        $countries = Country::joinMl()->get();
        $categories = Category::joinMl()->get();
        $languages = Language::all();

        return view('admin.commercial.edit')->with([
            'commercial' => $commercial,
            'mediaTypes' => $mediaTypes,
            'industryTypes' => $industryTypes,
            'countries' => $countries,
            'categories' => $categories,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(CommercialRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $commercial = Commercial::where('id', $id)->firstOrFail();
        $mediaTypes = MediaType::joinMl()->get();
        $industryTypes = IndustryType::joinMl()->get();
        $countries = Country::joinMl()->get();
        $categories = Category::joinMl()->get();
        $languages = Language::all();

        return view('admin.commercial.edit')->with([
            'commercial' => $commercial,
            'mediaTypes' => $mediaTypes,
            'industryTypes' => $industryTypes,
            'countries' => $countries,
            'categories' => $categories,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(CommercialRequest $request, $id)
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