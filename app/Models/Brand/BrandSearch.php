<?php

namespace App\Models\Brand;

use App\Core\DataTable;

class BrandSearch extends DataTable
{
    public function totalCount()
    {
        return Brand::count();
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
        $query = Brand::select('brands.id', 'ml.title', 'admin1.email as created_by', 'admin2.email as updated_by')
            ->leftJoinMl()
            ->leftJoin('adm_users as admin1', function($query) {
                $query->on('admin1.id', '=', 'brands.add_admin_id');
            })
            ->leftJoin('adm_users as admin2', function($query) {
                $query->on('admin2.id', '=', 'brands.update_admin_id');
            });

        if ($this->search != null) {
            $query->where('ml.title', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.about', 'LIKE', '%'.$this->search.'%');
        }
        if (isset($this->searchData['title'])) {
            $query->where('ml.title', 'LIKE', '%'.$this->searchData['title'].'%');
        }
        if (isset($this->searchData['skip_ids'])) {
            $query->whereNotIn('brands.id', $this->searchData['skip_ids']);
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
                $orderCol = 'brands.id';
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