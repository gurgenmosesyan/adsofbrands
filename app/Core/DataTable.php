<?php

namespace App\Core;

class DataTable
{
    public $draw;
    protected $start;
    protected $length;
    protected $search;
    protected $searchData;
    protected $orderCol;
    protected $orderType;
    protected $columns;

    public function setData($data)
    {
        $this->draw = isset($data['draw']) ? intval($data['draw']) : 0;
        $this->start = isset($data['start']) ? intval($data['start']) : 0;
        $this->length = isset($data['length']) ? intval($data['length']) : 25;
        $this->searchData = !empty($data['search']) ? $data['search'] : null;
        $this->search = !empty($data['search']['value']) ? $data['search']['value'] : null;
        $orderCol = isset($data['order'][0]['column']) ? intval($data['order'][0]['column']) : 0;
        $this->orderCol = isset($data['columns'][$orderCol]['data']) ? $data['columns'][$orderCol]['data'] : null;
        $this->orderType = isset($data['order'][0]['dir']) ? $data['order'][0]['dir'] : null;
        $this->columns = isset($data['columns']) ? $data['columns'] : null;
    }
}