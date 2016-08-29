<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\Request;
use App\Models\Account\Account;
//use App\Models\Account\AccountManager;

class RegRequest extends Request
{
    public function rules()
    {
        //$accountManager = new AccountManager();
        //$accountManager->resetAfterDay();

        return [
            'type' => 'required|in:'.Account::TYPE_CREATIVE.','.Account::TYPE_BRAND.','.Account::TYPE_AGENCY,
            'email' => 'required|email|max:255|unique:adm_users,email|unique:brands,email|unique:agencies,email|unique:creatives,email',
            'password' => 'required|min:6|max:255|regex:/[a-z]{1,}[0-9]{1,}/i',
            're_password' => 'required|same:password'
        ];
    }
}