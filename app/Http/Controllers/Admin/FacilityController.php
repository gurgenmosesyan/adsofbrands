<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Facility\Facility;
use App\Models\Facility\Manager;
use App\Models\Facility\Search;
use App\Http\Requests\Admin\FacilityRequest;
use App\Core\Language\Language;

class FacilityController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.facility.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $facility = new Facility();
        $languages = Language::all();
        return view('admin.facility.edit')->with([
            'facility' => $facility,
            'languages' => $languages,
            'images' => [],
            'saveMode' => 'add'
        ]);
    }

    public function store(FacilityRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $facility = Facility::findOrFail($id);
        $languages = Language::all();
        return view('admin.facility.edit')->with([
            'facility' => $facility,
            'languages' => $languages,
            'images' => $facility->images,
            'saveMode' => 'edit'
        ]);
    }

    public function update(FacilityRequest $request, $id)
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