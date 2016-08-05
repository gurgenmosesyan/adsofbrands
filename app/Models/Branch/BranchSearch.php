<?php

namespace App\Models\Branch;

use App\Core\DataTable;

class BranchSearch extends DataTable
{
    public function totalCount()
    {
        return Branch::count();
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
            $value->type = trans('admin.base.label.'.$value->type);
            $value->brand_agency = $value->isBrand() ? $value->brand_title : $value->agency_title;
        }
        return $data;
    }

    protected function constructQuery()
    {
        $cLngId = cLng('id');
        $query = Branch::select('branches.id', 'branches.type', 'ml.title', 'ml.address', 'brand.title as brand_title', 'agency.title as agency_title')
            ->joinMl()
            ->leftJoin('brands_ml as brand', function($query) use($cLngId) {
                $query->on('brand.id', '=', 'branches.type_id')->where('brand.lng_id', '=', $cLngId);
            })
            ->leftJoin('agencies_ml as agency', function($query) use($cLngId) {
                $query->on('agency.id', '=', 'branches.type_id')->where('agency.lng_id', '=', $cLngId);
            });

        if ($this->search != null) {
            $query->where('ml.title', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.address', 'LIKE', '%'.$this->search.'%')
                ->orWhere('branches.phone', 'LIKE', '%'.$this->search.'%')
                ->orWhere('branches.email', 'LIKE', '%'.$this->search.'%');
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'title':
                $orderCol = 'ml.title';
                break;
            case 'phone':
                $orderCol = 'branches.phone';
                break;
            case 'address':
                $orderCol = 'ml.address';
                break;
            case 'email':
                $orderCol = 'branches.email';
                break;
            default:
                $orderCol = 'branches.id';
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