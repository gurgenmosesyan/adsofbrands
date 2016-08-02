<?php

namespace App\Http\Controllers\Core;

use App\Http\Requests\Core\LoginRequest;
use Auth;

class AccountController extends BaseController
{
    public function login()
    {
        return view('core.login');
    }

    public function loginApi(LoginRequest $request)
    {
        $data = $request->all();
        $auth = auth()->guard('admin');
        if ($auth->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return $this->api('OK', ['path' => route('admin_homepage')]);
        }
        return $this->api('INVALID_DATA', null, ['email' => [trans('admin.login.invalid_credentials')]]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('core_admin_login');
    }
}