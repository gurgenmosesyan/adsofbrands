<?php

namespace App\Models\Reserved;

use App\Core\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Reserved::count();
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
        $query = Reserved::select('reserved.id', 'reserved.room_quantity', 'reserved.date_from', 'reserved.date_to', 'reserved.type', 'acc.title as acc_title')
            ->join('accommodations_ml as acc', function($query) {
                $query->on('acc.id', '=', 'reserved.accommodation_id')->where('acc.lng_id', '=', cLng('id'));
            });

        if (!empty($this->searchData['accommodation_id'])) {
            $query->where('reserved.accommodation_id', $this->searchData['accommodation_id']);
        }
        if (!empty($this->searchData['type'])) {
            $query->where('reserved.type', $this->searchData['type']);
        }
        if (!empty($this->searchData['from_date_from'])) {
            $query->where('reserved.date_from', '>=', $this->searchData['from_date_from']);
        }
        if (!empty($this->searchData['to_date_from'])) {
            $query->where('reserved.date_from', '<=', $this->searchData['to_date_from']);
        }
        if (!empty($this->searchData['from_date_to'])) {
            $query->where('reserved.date_to', '>=', $this->searchData['from_date_to']);
        }
        if (!empty($this->searchData['to_date_to'])) {
            $query->where('reserved.date_to', '<=', $this->searchData['to_date_to']);
        }

        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'acc_title':
                $orderCol = 'acc.title';
                break;
            case 'room_quantity':
                $orderCol = 'reserved.room_quantity';
                break;
            case 'date_from':
                $orderCol = 'reserved.date_from';
                break;
            case 'date_to':
                $orderCol = 'reserved.date_to';
                break;
            default:
                $orderCol = 'reserved.id';
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