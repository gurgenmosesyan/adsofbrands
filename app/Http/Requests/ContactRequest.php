<?php

namespace App\Http\Requests;

class ContactRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'max:255',
            'subject' => 'required|max:255',
            'message' => 'required|max:10000'
        ];
    }
}