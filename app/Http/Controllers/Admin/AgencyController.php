<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Agency\Agency;
use App\Models\Agency\AgencyManager;
use App\Models\Agency\AgencySearch;
use App\Http\Requests\Admin\AgencyRequest;
use App\Core\Language\Language;

class AgencyController extends BaseController
{
    protected $manager = null;

    public function __construct(AgencyManager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.agency.index');
    }

    public function index(AgencySearch $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $agency = new Agency();
        $languages = Language::all();

        return view('admin.agency.edit')->with([
            'agency' => $agency,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(AgencyRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $agency = Agency::where('id', $id)->firstOrFail();
        $languages = Language::all();

        return view('admin.agency.edit')->with([
            'agency' => $agency,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(AgencyRequest $request, $id)
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