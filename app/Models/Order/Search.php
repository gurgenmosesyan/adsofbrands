<?php

namespace App\Models\Order;

use App\Core\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Order::count();
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
        $cLngId = cLng('id');
        $cLngCode = cLng('code');
        $data = $query->get();
        foreach ($data as $value) {
            $value->date_from = date('d.m.Y', strtotime($value->date_from));
            $value->date_to = date('d.m.Y', strtotime($value->date_to));
            $accommodations = json_decode($value->accommodations, true);
            $count = count($accommodations);
            $value->accommodations = '';
            $i = 1;
            foreach ($accommodations as $acc) {
                $value->accommodations .= $acc['ml'][$cLngId].' - '.$acc['quantity'].'<br />';
                if (isset($acc['details'])) {
                    foreach ($acc['details'] as $detail) {
                        $value->accommodations .= '('.$detail[$cLngId].')<br />';
                    }
                }
                if ($i != $count) {
                    $value->accommodations .= '<hr />';
                }
                $i++;
            }

            $guests = json_decode($value->info, true);
            $guestsCount = count($guests);
            $value->info = '';
            $i = 1;
            foreach ($guests as $guest) {
                $value->info .= $guest['first_name'].' '.$guest['last_name'].' ('.$guest['citizenship'][$cLngCode].')<br />';
                if ($i != $guestsCount) {
                    $value->info .= '<hr />';
                }
                $i++;
            }
        }
        return $data;
    }

    protected function constructQuery()
    {
        $query = Order::getProcessor();

        if (!empty($this->searchData['accommodation_id'])) {
            $query->join('order_accommodations as acc', function($query) {
                $query->on('acc.order_id', '=', 'orders.id')->where('acc.accommodation_id', '=', $this->searchData['accommodation_id']);
            });
        }
        if (!empty($this->searchData['type'])) {
            $query->where('orders.type', $this->searchData['type']);
        }
        if (!empty($this->searchData['from_date_from'])) {
            $query->where('orders.date_from', '>=', $this->searchData['from_date_from']);
        }
        if (!empty($this->searchData['to_date_from'])) {
            $query->where('orders.date_from', '<=', $this->searchData['to_date_from']);
        }
        if (!empty($this->searchData['from_date_to'])) {
            $query->where('orders.date_to', '>=', $this->searchData['from_date_to']);
        }
        if (!empty($this->searchData['to_date_to'])) {
            $query->where('orders.date_to', '<=', $this->searchData['to_date_to']);
        }

        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'price':
                $orderCol = 'orders.price';
                break;
            case 'date_from':
                $orderCol = 'orders.date_from';
                break;
            case 'date_to':
                $orderCol = 'orders.date_to';
                break;
            case 'phone':
                $orderCol = 'orders.phone';
                break;
            case 'email':
                $orderCol = 'orders.email';
                break;
            case 'type':
                $orderCol = 'orders.type';
                break;
            default:
                $orderCol = 'orders.id';
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