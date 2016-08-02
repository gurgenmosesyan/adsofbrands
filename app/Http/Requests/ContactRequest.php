<?php

namespace App\Http\Requests;

class ContactRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|max:10000'
        ];
    }
}