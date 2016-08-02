<?php

namespace App\Core\Language;

use App\Core\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Language::count();
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
        $query = Language::getProcessor();
        if ($this->search != null) {
            $query->where('code', 'LIKE', '%'.$this->search.'%')
                ->orWhere('name', 'LIKE', '%'.$this->search.'%');
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'id':
                $orderCol = 'id';
                break;
            case 'name':
                $orderCol = 'name';
                break;
            case 'code':
                $orderCol = 'code';
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