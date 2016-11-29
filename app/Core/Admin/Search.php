<?php

namespace App\Core\Admin;

use App\Core\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Admin::count();
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
            $value->super_admin = $value->isSuperAdmin() ? trans('admin.base.label.yes') : '';
        }
        return $data;
    }

    protected function constructQuery()
    {
        $query = Admin::getProcessor();
        if ($this->search != null) {
            $query->where('email', 'LIKE', '%'.$this->search.'%');
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'id':
                $orderCol = 'id';
                break;
            case 'email':
                $orderCol = 'email';
                break;
            case 'role':
                $orderCol = 'role';
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