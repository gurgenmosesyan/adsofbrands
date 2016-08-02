<?php

namespace App\Http\Requests\Core;

use App\Http\Requests\Request;

class LoginRequest extends Request
{
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }
}
