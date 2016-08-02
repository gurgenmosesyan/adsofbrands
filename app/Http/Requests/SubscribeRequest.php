<?php

namespace App\Http\Requests;

class SubscribeRequest extends Request
{
    public function rules()
    {
        return [
            'email' => 'required|email|max:255'
        ];
    }
}