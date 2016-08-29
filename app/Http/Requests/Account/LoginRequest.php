<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\Request;
//use App\Models\Account\Account;

class LoginRequest extends Request
{
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
            //'remember_me' => 'in:'.Account::REMEMBER_ME
        ];
    }
}