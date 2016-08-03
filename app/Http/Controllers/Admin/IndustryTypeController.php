<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\IndustryType\IndustryType;
use App\Models\IndustryType\IndustryTypeManager;
use App\Models\IndustryType\IndustryTypeSearch;
use App\Http\Requests\Admin\IndustryTypeRequest;
use App\Core\Language\Language;

class IndustryTypeController extends BaseController
{
    protected $manager = null;

    public function __construct(IndustryTypeManager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.industry_type.index');
    }

    public function index(IndustryTypeSearch $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $industryType = new IndustryType();
        $languages = Language::all();

        return view('admin.industry_type.edit')->with([
            'industryType' => $industryType,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(IndustryTypeRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $industryType = IndustryType::where('id', $id)->firstOrFail();
        $languages = Language::all();

        return view('admin.industry_type.edit')->with([
            'industryType' => $industryType,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(IndustryTypeRequest $request, $id)
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