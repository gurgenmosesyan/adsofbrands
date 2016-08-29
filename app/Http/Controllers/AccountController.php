<?php

namespace App\Http\Controllers;

use App\Models\Account\Account;
use App\Models\Account\AccountManager;
use App\Models\Agency\Agency;
use App\Models\Brand\Brand;
use App\Models\Creative\Creative;

class AccountController extends Controller
{
    public function login()
    {
        return view('account.login');
    }

    public function register()
    {
        return view('account.register');
    }

    public function forgot()
    {
        return view('account.forgot');
    }

    public function activation($lngCode, $hash)
    {
        $user = Creative::where('hash', $hash)->where('reg_type', Account::REG_TYPE_REGISTERED)->where('status', Account::STATUS_PENDING)->first();
        if ($user == null) {
            $user = Brand::where('hash', $hash)->where('reg_type', Account::REG_TYPE_REGISTERED)->where('status', Account::STATUS_PENDING)->first();
        }
        if ($user == null) {
            $user = Agency::where('hash', $hash)->where('reg_type', Account::REG_TYPE_REGISTERED)->where('status', Account::STATUS_PENDING)->first();
        }
        $wrong = false;
        if ($user == null) {
            $wrong = true;
        } else {
            $user->status = Account::STATUS_CONFIRMED;
            $manager = new AccountManager();
            $user->hash = $manager->generateRandomUniqueHash();
            $user->save();
        }
        return view('account.activation')->with([
            'wrong' => $wrong
        ]);
    }

    public function reset($lngCode, $hash)
    {
        $user = Brand::where('hash', $hash)->first();
        if ($user == null) {
            $user = Agency::where('hash', $hash)->first();
        }
        if ($user == null) {
            $user = Creative::where('hash', $hash)->first();
        }
        if ($user == null) {
            $data = [
                'wrong_hash' => true,
                'message' => trans('www.password_reset.wrong_hash')
            ];
        } else {
            $data = [
                'wrong_hash' => false,
                'hash' => $hash
            ];
        }
        return view('account.reset')->with(['data' => $data]);
    }
}