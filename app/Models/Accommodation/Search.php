<?php

namespace App\Models\Accommodation;

use App\Core\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Accommodation::count();
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
        $query = Accommodation::joinMl();
        if ($this->search != null) {
            $query->where('ml.title', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.text', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.bed_type', 'LIKE', '%'.$this->search.'%')
                ->orWhere('accommodations.price', 'LIKE', '%'.$this->search.'%')
                ->orWhere('accommodations.room_size', 'LIKE', '%'.$this->search.'%');
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'title':
                $orderCol = 'ml.title';
                break;
            case 'price':
                $orderCol = 'accommodations.price';
                break;
            case 'sort_order':
                $orderCol = 'accommodations.sort_order';
                break;
            default:
                $orderCol = 'accommodations.id';
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