<?php

namespace App\Http\Requests\Booking;

use App\Http\Requests\Request;

class InfoRequest extends Request
{
    public function rules()
    {
        return [
            'info' => 'required|array',
            'info.*.first_name' => 'required|max:255',
            'info.*.last_name' => 'required|max:255',
            'info.*.citizenship' => 'required|integer|exists:countries,id',
            'phone' => 'required|max:255',
            'email' => 'required|email|max:255',
            'text' => 'max:65000'
        ];
    }
}