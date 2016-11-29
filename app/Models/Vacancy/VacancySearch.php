<?php

namespace App\Models\Vacancy;

use App\Core\DataTable;
use Auth;

class VacancySearch extends DataTable
{
    public function totalCount()
    {
        if (Auth::guard('admin')->check()) {
            return Vacancy::count();
        } else if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            return Vacancy::where('type', Vacancy::TYPE_BRAND)->where('type_id', $brand->id)->count();
        } else {
            $agency = Auth::guard('agency')->user();
            return Vacancy::where('type', Vacancy::TYPE_AGENCY)->where('type_id', $agency->id)->count();
        }
    }

    public function filteredCount()
    {
        $query = $this->constructQuery();
        return $query->count();
    }

    public function search()
    {
        $query = $this->constructQuery();
        $this->constructOrder($query);
        $this->constructLimit($query);
        $data = $query->get();
        foreach ($data as $value) {
            $value->brand_agency = $value->isBrand() ? $value->brand_title : $value->agency_title;
            $value->type = trans('admin.base.label.'.$value->type);
        }
        return $data;
    }

    protected function constructQuery()
    {
        $cLngId = cLng('id');
        $query = Vacancy::joinMl();
        if (Auth::guard('admin')->check()) {
            $query->select('vacancies.id', 'vacancies.type', 'ml.title', 'brand.title as brand_title', 'agency.title as agency_title', 'admin1.email as created_by', 'admin2.email as updated_by');
            $query->leftJoin('brands_ml as brand', function($query) use($cLngId) {
                $query->on('brand.id', '=', 'vacancies.type_id')->where('brand.lng_id', '=', $cLngId);
            })
            ->leftJoin('agencies_ml as agency', function($query) use($cLngId) {
                $query->on('agency.id', '=', 'vacancies.type_id')->where('agency.lng_id', '=', $cLngId);
            })
            ->leftJoin('adm_users as admin1', function($query) {
                $query->on('admin1.id', '=', 'vacancies.add_admin_id');
            })
            ->leftJoin('adm_users as admin2', function($query) {
                $query->on('admin2.id', '=', 'vacancies.update_admin_id');
            });
        } else if(Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->select('vacancies.id', 'ml.title')->where('type', Vacancy::TYPE_BRAND)->where('type_id', $brand->id);
        } else {
            $agency = Auth::guard('agency')->user();
            $query->select('vacancies.id', 'ml.title')->where('type', Vacancy::TYPE_AGENCY)->where('type_id', $agency->id);
        }

        if ($this->search != null) {
            $query->where(function($query) {
                $query->where('ml.title', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('ml.description', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('ml.text', 'LIKE', '%'.$this->search.'%');
            });
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'type':
                $orderCol = 'vacancies.type';
                break;
            case 'title':
                $orderCol = 'ml.title';
                break;
            default:
                $orderCol = 'vacancies.id';
        }
        $orderType = 'desc';
        if ($this->orderType == 'asc') {
            $orderType = 'asc';
        }
        $query->orderBy($orderCol, $orderType);
    }

    protected function constructLimit($query)
    {
        $query->skip($this->start)->take($this->length);
    }
}