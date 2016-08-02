<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Accommodation\Accommodation;
use App\Models\Accommodation\Manager;
use App\Models\Accommodation\Search;
use App\Http\Requests\Admin\AccommodationRequest;
use App\Core\Language\Language;

class AccommodationController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.accommodation.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $accommodation = new Accommodation();
        $languages = Language::all();
        return view('admin.accommodation.edit')->with([
            'accommodation' => $accommodation,
            'languages' => $languages,
            'facilities' => [],
            'details' => [],
            'images' => [],
            'saveMode' => 'add'
        ]);
    }

    public function store(AccommodationRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $accommodation = Accommodation::findOrFail($id);
        $languages = Language::all();
        $facilities = [];
        foreach ($accommodation->facilities as $value) {
            $facilities[$value->index][$value->lng_id] = $value;
        }
        $details = [];
        foreach ($accommodation->details as $value) {
            $details[$value->index][$value->lng_id] = $value->toArray();
        }

        return view('admin.accommodation.edit')->with([
            'accommodation' => $accommodation,
            'languages' => $languages,
            'facilities' => $facilities,
            'details' => $details,
            'images' => $accommodation->images,
            'saveMode' => 'edit'
        ]);
    }

    public function update(AccommodationRequest $request, $id)
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