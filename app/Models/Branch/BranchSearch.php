<?php

namespace App\Models\Branch;

use App\Core\DataTable;
use Auth;

class BranchSearch extends DataTable
{
    public function totalCount()
    {
        if (Auth::guard('admin')->check()) {
            return Branch::count();
        } else if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            return Branch::where('type', Branch::TYPE_BRAND)->where('type_id', $brand->id)->count();
        } else {
            $agency = Auth::guard('agency')->user();
            return Branch::where('type', Branch::TYPE_AGENCY)->where('type_id', $agency->id)->count();
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
        $query = Branch::joinMl();
        if (Auth::guard('admin')->check()) {
            $query->select('branches.id', 'branches.type', 'ml.title', 'ml.address', 'brand.title as brand_title', 'agency.title as agency_title');
            $query->leftJoin('brands_ml as brand', function($query) use($cLngId) {
                $query->on('brand.id', '=', 'branches.type_id')->where('brand.lng_id', '=', $cLngId);
            })
            ->leftJoin('agencies_ml as agency', function($query) use($cLngId) {
                $query->on('agency.id', '=', 'branches.type_id')->where('agency.lng_id', '=', $cLngId);
            });
        } else if(Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->select('branches.id', 'ml.title', 'ml.address')->where('type', Branch::TYPE_BRAND)->where('type_id', $brand->id);
        } else {
            $agency = Auth::guard('agency')->user();
            $query->select('branches.id', 'ml.title', 'ml.address')->where('type', Branch::TYPE_AGENCY)->where('type_id', $agency->id);
        }

        if ($this->search != null) {
            $query->where(function($query) {
                $query->where('ml.title', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('ml.address', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('branches.phone', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('branches.email', 'LIKE', '%'.$this->search.'%');
            });
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'type':
                $orderCol = 'branches.type';
                break;
            case 'title':
                $orderCol = 'ml.title';
                break;
            case 'address':
                $orderCol = 'ml.address';
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