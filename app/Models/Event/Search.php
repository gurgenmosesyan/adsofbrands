<?php

namespace App\Models\Event;

use App\Core\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Event::count();
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
        $query = Event::joinMl();
        if ($this->search != null) {
            $query->where('ml.title', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.text', 'LIKE', '%'.$this->search.'%');
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'title':
                $orderCol = 'ml.title';
                break;
            case 'sort_order':
                $orderCol = 'events.sort_order';
                break;
            default:
                $orderCol = 'events.id';
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