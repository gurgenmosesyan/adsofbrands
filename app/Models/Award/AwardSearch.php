<?php

namespace App\Models\Award;

use App\Core\DataTable;
use Auth;

class AwardSearch extends DataTable
{
    public function totalCount()
    {
        if (Auth::guard('admin')->check()) {
            return Award::count();
        } else if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            return Award::where('type', Award::TYPE_BRAND)->where('type_id', $brand->id)->count();
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            return Award::where('type', Award::TYPE_AGENCY)->where('type_id', $agency->id)->count();
        } else {
            $creative = Auth::guard('creative')->user();
            return Award::where('type', Award::TYPE_CREATIVE)->where('type_id', $creative->id)->count();
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
            if ($value->isBrand()) {
                $value->brand_agency_creative =  $value->brand_title;
            } else if ($value->isAgency()) {
                $value->brand_agency_creative =  $value->agency_title;
            } else {
                $value->brand_agency_creative =  $value->creative_title;
            }
            $value->type = trans('admin.base.label.'.$value->type);
        }
        return $data;
    }

    protected function constructQuery()
    {
        $cLngId = cLng('id');

        $query = Award::joinMl();
        if (Auth::guard('admin')->check()) {
            $query->select('awards.id', 'awards.type', 'awards.year', 'ml.title', 'brand.title as brand_title', 'agency.title as agency_title', 'creative.title as creative_title', 'admin1.email as created_by', 'admin2.email as updated_by');
            $query->leftJoin('brands_ml as brand', function($query) use($cLngId) {
                $query->on('brand.id', '=', 'awards.type_id')->where('brand.lng_id', '=', $cLngId);
            })
            ->leftJoin('agencies_ml as agency', function($query) use($cLngId) {
                $query->on('agency.id', '=', 'awards.type_id')->where('agency.lng_id', '=', $cLngId);
            })
            ->leftJoin('creatives_ml as creative', function($query) use($cLngId) {
                $query->on('creative.id', '=', 'awards.type_id')->where('creative.lng_id', '=', $cLngId);
            })
            ->leftJoin('adm_users as admin1', function($query) {
                $query->on('admin1.id', '=', 'awards.add_admin_id');
            })
            ->leftJoin('adm_users as admin2', function($query) {
                $query->on('admin2.id', '=', 'awards.update_admin_id');
            });
        } else if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->select('awards.id', 'awards.year', 'ml.title')->where('type', Award::TYPE_BRAND)->where('type_id', $brand->id);
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $query->select('awards.id', 'awards.year', 'ml.title')->where('type', Award::TYPE_AGENCY)->where('type_id', $agency->id);
        } else {
            $creative = Auth::guard('creative')->user();
            $query->select('awards.id', 'awards.year', 'ml.title')->where('type', Award::TYPE_CREATIVE)->where('type_id', $creative->id);
        }

        if ($this->search != null) {
            $query->where(function($query) {
                $query->where('ml.title', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('ml.category', 'LIKE', '%'.$this->search.'%');
            });
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