<?php

namespace App\Models\Category;

use App\Core\DataTable;

class CategorySearch extends DataTable
{
    public function totalCount()
    {
        return Category::count();
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
        $query = Category::select('categories.id', 'ml.title', 'admin1.email as created_by', 'admin2.email as updated_by')
            ->joinMl()
            ->leftJoin('adm_users as admin1', function($query) {
                $query->on('admin1.id', '=', 'categories.add_admin_id');
            })
            ->leftJoin('adm_users as admin2', function($query) {
                $query->on('admin2.id', '=', 'categories.update_admin_id');
            });

        if ($this->search != null) {
            $query->where('ml.title', 'LIKE', '%'.$this->search.'%');
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
                $orderCol = 'categories.id';
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