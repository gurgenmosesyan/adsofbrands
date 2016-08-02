<?php

namespace App\Http\Requests\Core;

use App\Http\Requests\Request;
use Route;

class AdminRequest extends Request
{
    public function rules()
    {
        $params = Route::getCurrentRoute()->parameters();
        $adminId = '';
        $passRequired = $rePassRequired = 'required';
        if (isset($params['id'])) {
            $adminId = ','.$params['id'];
            $passRequired = 'required_with:re_password';
            $rePassRequired = 'required_with:password';
        }

        return [
            'email' => 'required|email|unique:adm_users,email'.$adminId,
            'password' => $passRequired.'|min:6|max:255|regex:/[a-z]{1,}[0-9]{1,}/i',
            're_password' => $rePassRequired.'|same:password',
            'lng_id' => 'required|integer|exists:languages,id'
        ];
    }
}
