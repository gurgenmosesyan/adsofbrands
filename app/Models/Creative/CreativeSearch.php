<?php

namespace App\Models\Creative;

use App\Core\DataTable;

class CreativeSearch extends DataTable
{
    public function totalCount()
    {
        return Creative::count();
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
            if ($value->type == Creative::TYPE_BRAND) {
                $value->brand_agency = $value->brand_title;
            } else if ($value->isAgency()) {
                $value->brand_agency = $value->agency_title;
            } else {
                $value->brand_agency = '';
            }
            $value->type = trans('admin.base.label.'.$value->type);
        }
        return $data;
    }

    protected function constructQuery()
    {
        $cLngId = cLng('id');
        $query = Creative::select('creatives.id', 'creatives.type', 'ml.name', 'brand.title as brand_title', 'agency.title as agency_title')
            ->joinMl()
            ->leftJoin('brands_ml as brand', function($query) use($cLngId) {
                $query->on('brand.id', '=', 'creatives.type_id')->where('brand.lng_id', '=', $cLngId);
            })
            ->leftJoin('agencies_ml as agency', function($query) use($cLngId) {
                $query->on('agency.id', '=', 'creatives.type_id')->where('agency.lng_id', '=', $cLngId);
            });

        if ($this->search != null) {
            $query->where('ml.name', 'LIKE', '%'.$this->search.'%');
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'type':
                $orderCol = 'creatives.type';
                break;
            case 'name':
                $orderCol = 'ml.name';
                break;
            default:
                $orderCol = 'creatives.id';
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