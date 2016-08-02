<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ReservedRequest extends Request
{
    public function rules()
    {
        return [
            'accommodation_id' => 'required|integer|exists:accommodations,id',
            'room_quantity' => 'required|integer',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after:date_from'
        ];
    }
}