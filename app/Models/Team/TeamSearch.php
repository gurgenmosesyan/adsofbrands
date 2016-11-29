<?php

namespace App\Models\Team;

use App\Core\DataTable;

class TeamSearch extends DataTable
{
    public function totalCount()
    {
        return Team::count();
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
        $query = Team::select('team.id', 'ml.first_name', 'ml.last_name', 'ml.position', 'admin1.email as created_by', 'admin2.email as updated_by')
            ->joinMl()
            ->leftJoin('adm_users as admin1', function($query) {
                $query->on('admin1.id', '=', 'team.add_admin_id');
            })
            ->leftJoin('adm_users as admin2', function($query) {
                $query->on('admin2.id', '=', 'team.update_admin_id');
            });

        if ($this->search != null) {
            $query->where('ml.first_name', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.last_name', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.position', 'LIKE', '%'.$this->search.'%');
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'first_name':
                $orderCol = 'ml.first_name';
                break;
            case 'last_name':
                $orderCol = 'ml.last_name';
                break;
            case 'position':
                $orderCol = 'ml.position';
                break;
            default:
                $orderCol = 'team.id';
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