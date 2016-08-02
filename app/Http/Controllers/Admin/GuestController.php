<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Guest\Guest;
use App\Models\Guest\Manager;
use App\Models\Guest\Search;
use App\Http\Requests\Admin\GuestRequest;
use App\Core\Language\Language;

class GuestController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.guest.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $guest = new Guest();
        $languages = Language::all();
        return view('admin.guest.edit')->with([
            'guest' => $guest,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(GuestRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $guest = Guest::findOrFail($id);
        $languages = Language::all();
        return view('admin.guest.edit')->with([
            'guest' => $guest,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(GuestRequest $request, $id)
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