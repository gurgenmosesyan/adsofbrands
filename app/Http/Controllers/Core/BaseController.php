<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use stdClass;

class BaseController extends Controller
{
    public function processDataTable($search)
    {
        $data = Input::get();
        $search->setData($data);
        $result = new stdClass();
        $result->draw = $search->draw;
        $result->recordsTotal = $search->totalCount();
        $result->recordsFiltered = $search->filteredCount();
        $result->data = $search->search();
        return $result;
    }

    public function toDataTable($result)
    {
        return Response::json($result);
    }

    public function api($status, $data = null, $errors = null)
    {
        return Response::json(['status' => $status, 'data' => $data, 'errors' => $errors]);
    }
}