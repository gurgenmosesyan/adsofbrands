<?php

namespace App\Models\Vacancy;

use App\Core\DataTable;

class VacancySearch extends DataTable
{
    public function totalCount()
    {
        return Vacancy::count();
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
        $query = Vacancy::select('vacancies.id', 'vacancies.type', 'ml.title', 'brand.title as brand_title', 'agency.title as agency_title')
            ->joinMl()
            ->leftJoin('brands_ml as brand', function($query) use($cLngId) {
                $query->on('brand.id', '=', 'vacancies.type_id')->where('brand.lng_id', '=', $cLngId);
            })
            ->leftJoin('agencies_ml as agency', function($query) use($cLngId) {
                $query->on('agency.id', '=', 'vacancies.type_id')->where('agency.lng_id', '=', $cLngId);
            });

        if ($this->search != null) {
            $query->where('ml.title', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.description', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.text', 'LIKE', '%'.$this->search.'%');
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