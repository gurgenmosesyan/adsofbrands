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
            return $this->api('OK', ['path' => route('admin_brand_table')]);
        }

        return $this->api('INVALID_DATA', null, ['email' => [trans('admin.login.invalid_credentials')]]);
    }

    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            $redirect = route('core_admin_login');
        } else {
            $redirect = url_with_lng('/sign-in');
        }
        Auth::guard('admin')->logout();
        Auth::guard('brand')->logout();
        Auth::guard('agency')->logout();
        Auth::guard('creative')->logout();
        return redirect($redirect);
    }
}