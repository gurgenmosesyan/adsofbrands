<?php

namespace App\Models\Commercial;

use App\Core\DataTable;
use Auth;

class CommercialSearch extends DataTable
{
    public function totalCount()
    {
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            return Commercial::join('commercial_brands as brands', function($query) use($brand) {
                $query->on('brands.commercial_id', '=', 'commercials.id')->where('brands.brand_id', '=', $brand->id);
            })->count();
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            return Commercial::join('commercial_agencies as agencies', function($query) use($agency) {
                $query->on('agencies.commercial_id', '=', 'commercials.id')->where('agencies.agency_id', '=', $agency->id);
            })->count();
        } else {
            return Commercial::count();
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
        return $query->get();
    }

    protected function constructQuery()
    {
        $query = Commercial::joinMl();

        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->join('commercial_brands as brands', function($query) use($brand) {
                $query->on('brands.commercial_id', '=', 'commercials.id')->where('brands.brand_id', '=', $brand->id);
            });
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $query->join('commercial_agencies as agencies', function($query) use($agency) {
                $query->on('agencies.commercial_id', '=', 'commercials.id')->where('agencies.agency_id', '=', $agency->id);
            });
        }

        if ($this->search != null) {
            $query->where(function($query) {
                $query->where('ml.title', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('ml.description', 'LIKE', '%'.$this->search.'%');;
            });
        }
        if (isset($this->searchData['title'])) {
            $query->where('ml.title', 'LIKE', '%'.$this->searchData['title'].'%');
        }
        if (isset($this->searchData['skip_ids'])) {
            $query->whereNotIn('commercials.id', $this->searchData['skip_ids']);
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'title':
                $orderCol = 'ml.title';
                break;
            default:
                $orderCol = 'commercials.id';
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