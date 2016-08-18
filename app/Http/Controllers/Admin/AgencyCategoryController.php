<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\AgencyCategory\Category;
use App\Models\AgencyCategory\CategoryManager;
use App\Models\AgencyCategory\CategorySearch;
use App\Http\Requests\Admin\CategoryRequest;
use App\Core\Language\Language;

class AgencyCategoryController extends BaseController
{
    protected $manager = null;

    public function __construct(CategoryManager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.agency_category.index');
    }

    public function index(CategorySearch $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $category = new Category();
        $languages = Language::all();

        return view('admin.agency_category.edit')->with([
            'category' => $category,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(CategoryRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $category = Category::where('id', $id)->firstOrFail();
        $languages = Language::all();

        return view('admin.agency_category.edit')->with([
            'category' => $category,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(CategoryRequest $request, $id)
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