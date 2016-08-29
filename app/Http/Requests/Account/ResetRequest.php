<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\Request;

class ResetRequest extends Request
{
    public function rules()
    {
        return [
            'password' => 'required|min:6|max:255|regex:/[a-z]{1,}[0-9]{1,}/i',
            're_password' => 'required|same:password',
            'hash' => 'required'
        ];
    }
}