<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Order\Order;
use App\Models\Order\Search;
use App\Models\Accommodation\AccommodationMl;

class OrderController extends BaseController
{
    public function table()
    {
        $accommodations = AccommodationMl::where('lng_id', cLng('id'))->get();
        return view('admin.order.index')->with([
            'accommodations' => $accommodations
        ]);
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    /*public function view($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.order.edit')->with([
            'order' => $order
        ]);
    }*/
}