<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Agency\AgencyMl;
use App\Models\Vacancy\Vacancy;
use App\Models\Vacancy\VacancyManager;
use App\Models\Vacancy\VacancySearch;
use App\Http\Requests\Admin\VacancyRequest;
use App\Core\Language\Language;
use App\Models\Brand\BrandMl;
use Auth;

class VacancyController extends BaseController
{
    protected $manager = null;

    public function __construct(VacancyManager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.vacancy.index');
    }

    public function index(VacancySearch $search)
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
            'typeName' => '',
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
        $query = Vacancy::where('id', $id);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->where('type', Vacancy::TYPE_BRAND)->where('type_id', $brand->id);
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $query->where('type', Vacancy::TYPE_AGENCY)->where('type_id', $agency->id);
        }
        $vacancy = $query->firstOrFail();
        $languages = Language::all();

        $typeName = '';
        if (Auth::guard('admin')->check()) {
            if ($vacancy->isBrand()) {
                $type = BrandMl::current()->where('id', $vacancy->type_id)->first();
            } else {
                $type = AgencyMl::current()->where('id', $vacancy->type_id)->first();
            }
            $typeName = $type == null ? '' : $type->title;
        }

        return view('admin.vacancy.edit')->with([
            'vacancy' => $vacancy,
            'languages' => $languages,
            'typeName' => $typeName,
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