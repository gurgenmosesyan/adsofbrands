<?php

namespace App\Core\Dictionary;

use App\Core\DataTable;
use Illuminate\Http\Request;

class Search extends DataTable
{
    protected $data = [];

    public function __construct(Request $request, Manager $manager)
    {
        $appId = $request->input('app');
        $this->data = $manager->dictionaryData($appId);
    }

    public function totalCount()
    {
        return count($this->data);
    }

    public function filteredCount()
    {
        return count($this->constructData());
    }

    public function search()
    {
        return $this->constructData();
    }

    protected function constructData()
    {
        if ($this->search == null) {
            return $this->data;
        } else {
            $data = [];
            foreach ($this->data as $key => $messages) {
                foreach ($messages as $message) {
                    if (stripos($message, $this->search) !== false) {
                        $data[$key] = $messages;
                    }
                }
            }
            return array_values($data);
        }
    }
}