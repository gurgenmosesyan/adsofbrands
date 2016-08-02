<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Vacancy\Vacancy;
use App\Models\Vacancy\Manager;
use App\Models\Vacancy\Search;
use App\Http\Requests\Admin\VacancyRequest;
use App\Core\Language\Language;

class VacancyController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.vacancy.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $vacancy = new Vacancy();
        $languages = Language::all();
        return view('admin.vacancy.edit')->with([
            'vacancy' => $vacancy,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(VacancyRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $vacancy = Vacancy::findOrFail($id);
        $languages = Language::all();
        return view('admin.vacancy.edit')->with([
            'vacancy' => $vacancy,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(VacancyRequest $request, $id)
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