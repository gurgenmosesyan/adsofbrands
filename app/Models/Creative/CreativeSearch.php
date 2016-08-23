<?php

namespace App\Models\Creative;

use App\Core\DataTable;
use Auth;

class CreativeSearch extends DataTable
{
    public function totalCount()
    {
        if (Auth::guard('admin')->check()) {
            return Creative::count();
        } else if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            return Creative::where('type', Creative::TYPE_BRAND)->where('type_id', $brand->id)->count();
        } else {
            $agency = Auth::guard('agency')->user();
            return Creative::where('type', Creative::TYPE_AGENCY)->where('type_id', $agency->id)->count();
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
        $query = Creative::joinMl();
        if (Auth::guard('admin')->check()) {
            $query->select('creatives.id', 'creatives.type', 'ml.title', 'brand.title as brand_title', 'agency.title as agency_title')
                ->leftJoin('brands_ml as brand', function($query) use($cLngId) {
                    $query->on('brand.id', '=', 'creatives.type_id')->where('brand.lng_id', '=', $cLngId);
                })
                ->leftJoin('agencies_ml as agency', function($query) use($cLngId) {
                    $query->on('agency.id', '=', 'creatives.type_id')->where('agency.lng_id', '=', $cLngId);
                });
        } else if(Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->select('creatives.id', 'ml.title')->where('type', Creative::TYPE_BRAND)->where('type_id', $brand->id);
        } else {
            $agency = Auth::guard('agency')->user();
            $query->select('creatives.id', 'ml.title')->where('type', Creative::TYPE_AGENCY)->where('type_id', $agency->id);
        }

        if ($this->search != null) {
            $query->where('ml.title', 'LIKE', '%'.$this->search.'%');
        }
        if (isset($this->searchData['title'])) {
            $query->where('ml.title', 'LIKE', '%'.$this->searchData['title'].'%');
        }
        if (isset($this->searchData['skip_ids'])) {
            $query->whereNotIn('creatives.id', $this->searchData['skip_ids']);
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'type':
                $orderCol = 'creatives.type';
                break;
            case 'title':
                $orderCol = 'ml.title';
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