<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\Request;

class ForgotRequest extends Request
{
    public function rules()
    {
        return [
            'email' => 'required|email'
        ];
    }
}