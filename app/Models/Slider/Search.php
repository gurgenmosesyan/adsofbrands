<?php

namespace App\Models\Slider;

use App\Core\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Slider::where('key', $this->key)->count();
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
            $value->key = trans('admin.slider.key.'.$value->key);
        }
        return $data;
    }

    protected function constructQuery()
    {
        $query = Slider::select('slider.id', 'slider.key', 'slider.sort_order', 'facility.title as facility_title')
            ->join('facilities_ml as facility', function($query) {
                $query->on('facility.id', '=', 'slider.facility_id')->where('facility.lng_id', '=', cLng('id'));
            })
            ->where('key', $this->key);
        if ($this->search != null) {
            $query->where('facility.title', 'LIKE', '%'.$this->search.'%');
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'facility_title':
                $orderCol = 'facility.title';
                break;
            case 'sort_order':
                $orderCol = 'slider.sort_order';
                break;
            default:
                $orderCol = 'id';
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