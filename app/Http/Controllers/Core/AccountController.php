<?php

namespace App\Http\Controllers\Core;

use App\Http\Requests\Core\LoginRequest;
use App\Models\Brand\Brand;
use App\Models\Agency\Agency;
use App\Models\Creative\Creative;
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

        $auth = auth()->guard('brand');
        $result = $auth->attempt(['email' => $data['email'], 'password' => $data['password'], 'reg_type' => Brand::REG_TYPE_REGISTERED], false, false);
        if ($result) {
            $brand = Brand::where('email', $data['email'])->first();
            if ($brand->status == Brand::STATUS_PENDING) {
                return $this->api('INVALID_DATA', null, ['email' => [trans('admin.login.not_confirmed')]]);
            }
            $auth->login($brand);
            return $this->api('OK', ['path' => route('admin_brand_edit', $brand->id)]);
        }

        $auth = auth()->guard('agency');
        $result = $auth->attempt(['email' => $data['email'], 'password' => $data['password'], 'reg_type' => Agency::REG_TYPE_REGISTERED], false, false);
        if ($result) {
            $agency = Agency::where('email', $data['email'])->first();
            if ($agency->status == Brand::STATUS_PENDING) {
                return $this->api('INVALID_DATA', null, ['email' => [trans('admin.login.not_confirmed')]]);
            }
            $auth->login($agency);
            return $this->api('OK', ['path' => route('admin_agency_edit', $agency->id)]);
        }

        $auth = auth()->guard('creative');
        $result = $auth->attempt(['email' => $data['email'], 'password' => $data['password'], 'reg_type' => Creative::REG_TYPE_REGISTERED], false, false);
        if ($result) {
            $creative = Creative::where('email', $data['email'])->first();
            if ($creative->status == Brand::STATUS_PENDING) {
                return $this->api('INVALID_DATA', null, ['email' => [trans('admin.login.not_confirmed')]]);
            }
            $auth->login($creative);
            return $this->api('OK', ['path' => route('admin_creative_edit', $creative->id)]);
        }

        return $this->api('INVALID_DATA', null, ['email' => [trans('admin.login.invalid_credentials')]]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        Auth::guard('brand')->logout();
        Auth::guard('agency')->logout();
        Auth::guard('creative')->logout();
        return redirect()->route('core_admin_login');
    }
}