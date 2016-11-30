<?php

namespace App\Models\ShortLink;

use App\Core\DataTable;

class ShortLinkSearch extends DataTable
{
    public function totalCount()
    {
        return ShortLink::count();
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
        $query = ShortLink::select('short_links.*', 'admin1.email as created_by', 'admin2.email as updated_by')
            ->leftJoin('adm_users as admin1', function($query) {
                $query->on('admin1.id', '=', 'short_links.add_admin_id');
            })
            ->leftJoin('adm_users as admin2', function($query) {
                $query->on('admin2.id', '=', 'short_links.update_admin_id');
            });

        if ($this->search != null) {
            $query->where('short_links.short_link', 'LIKE', '%'.$this->search.'%')
                ->orWhere('short_links.link', 'LIKE', '%'.$this->search.'%');
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'short_link':
                $orderCol = 'short_links.short_link';
                break;
            case 'link':
                $orderCol = 'short_links.link';
                break;
            default:
                $orderCol = 'short_links.id';
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