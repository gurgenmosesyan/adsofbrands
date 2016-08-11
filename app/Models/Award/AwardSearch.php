<?php

namespace App\Models\Award;

use App\Core\DataTable;

class AwardSearch extends DataTable
{
    public function totalCount()
    {
        return Award::count();
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
            if ($value->isBrand()) {
                $value->brand_agency_creative =  $value->brand_title;
            } else if ($value->isAgency()) {
                $value->brand_agency_creative =  $value->agency_title;
            } else {
                $value->brand_agency_creative =  $value->creative_name;
            }
            $value->type = trans('admin.base.label.'.$value->type);
        }
        return $data;
    }

    protected function constructQuery()
    {
        $cLngId = cLng('id');
        $query = Award::select('awards.id', 'awards.type', 'awards.year', 'ml.title', 'brand.title as brand_title', 'agency.title as agency_title', 'creative.name as creative_name')
            ->joinMl()
            ->leftJoin('brands_ml as brand', function($query) use($cLngId) {
                $query->on('brand.id', '=', 'awards.type_id')->where('brand.lng_id', '=', $cLngId);
            })
            ->leftJoin('agencies_ml as agency', function($query) use($cLngId) {
                $query->on('agency.id', '=', 'awards.type_id')->where('agency.lng_id', '=', $cLngId);
            })
            ->leftJoin('creatives_ml as creative', function($query) use($cLngId) {
                $query->on('creative.id', '=', 'awards.type_id')->where('creative.lng_id', '=', $cLngId);
            });

        if ($this->search != null) {
            $query->where('ml.title', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.category', 'LIKE', '%'.$this->search.'%');
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'type':
                $orderCol = 'awards.type';
                break;
            case 'year':
                $orderCol = 'awards.year';
                break;
            case 'title':
                $orderCol = 'ml.title';
                break;
            default:
                $orderCol = 'awards.id';
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