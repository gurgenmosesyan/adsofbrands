<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Reserved\Reserved;
use App\Models\Reserved\Manager;
use App\Models\Reserved\Search;
use App\Http\Requests\Admin\ReservedRequest;
use App\Models\Accommodation\AccommodationMl;

class ReservedController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        $accommodations = AccommodationMl::where('lng_id', cLng('id'))->get();
        return view('admin.reserved.index')->with([
            'accommodations' => $accommodations
        ]);
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $reserved = new Reserved();
        $accommodations = AccommodationMl::where('lng_id', cLng('id'))->get();
        return view('admin.reserved.edit')->with([
            'reserved' => $reserved,
            'accommodations' => $accommodations,
            'saveMode' => 'add'
        ]);
    }

    public function store(ReservedRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $reserved = Reserved::findOrFail($id);
        $accommodations = AccommodationMl::where('lng_id', cLng('id'))->get();
        return view('admin.reserved.edit')->with([
            'reserved' => $reserved,
            'accommodations' => $accommodations,
            'saveMode' => 'edit'
        ]);
    }

    public function update(ReservedRequest $request, $id)
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