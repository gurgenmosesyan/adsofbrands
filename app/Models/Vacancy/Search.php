<?php

namespace App\Models\Vacancy;

use App\Core\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Vacancy::count();
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
        $query = Vacancy::select('vacancies.id', 'ml.title', 'ml.function', 'vacancies.published_at')
            ->join('vacancies_ml as ml', function($query) {
                $query->on('ml.id', '=', 'vacancies.id')->where('ml.lng_id', '=', cLng('id'));
            });
        if ($this->search != null) {
            $query->where('ml.title', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.function', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.location', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.description', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.responsibilities', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.qualifications', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.procedures', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.about', 'LIKE', '%'.$this->search.'%');
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'ml.title':
                $orderCol = 'ml.title';
                break;
            case 'ml.function':
                $orderCol = 'ml.function';
                break;
            default:
                $orderCol = 'vacancies.id';
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