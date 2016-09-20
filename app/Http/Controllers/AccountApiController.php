<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\RegRequest;
use App\Http\Requests\Account\LoginRequest;
use App\Http\Requests\Account\ForgotRequest;
use App\Http\Requests\Account\ResetRequest;
use App\Models\Account\AccountManager;
use App\Models\Agency\Agency;
use App\Models\Brand\Brand;
use App\Models\Creative\Creative;

class AccountApiController extends Controller
{
    protected $manager = null;

    public function __construct(AccountManager $manager)
    {
        $this->manager = $manager;
    }

    public function login(LoginRequest $request)
    {
        $data = $request->all();
        //$rememberMe = isset($data['remember_me']) && $data['remember_me'] == Account::REMEMBER_ME ? true : false;
        $rememberMe = false;

        $auth = auth()->guard('brand');
        $result = $auth->attempt(['email' => $data['email'], 'password' => $data['password']], false, false);
        if ($result) {
            $brand = Brand::where('email', $data['email'])->first();
            if ($brand->blocked == Brand::BLOCKED) {
                return $this->api('INVALID_DATA', null, ['email' => [trans('www.login.blocked')]]);
            }
            if ($brand->status == Brand::STATUS_PENDING) {
                return $this->api('INVALID_DATA', null, ['email' => [trans('www.login.not_confirmed')]]);
            }
            $auth->login($brand, $rememberMe);
            return $this->api('OK', ['link' => route('admin_brand_edit', $brand->id)]);
        }

        $auth = auth()->guard('agency');
        $result = $auth->attempt(['email' => $data['email'], 'password' => $data['password']], false, false);
        if ($result) {
            $agency = Agency::where('email', $data['email'])->first();
            if ($agency->blocked == Agency::BLOCKED) {
                return $this->api('INVALID_DATA', null, ['email' => [trans('www.login.blocked')]]);
            }
            if ($agency->status == Agency::STATUS_PENDING) {
                return $this->api('INVALID_DATA', null, ['email' => [trans('www.login.not_confirmed')]]);
            }
            $auth->login($agency, $rememberMe);
            return $this->api('OK', ['link' => route('admin_agency_edit', $agency->id)]);
        }

        $auth = auth()->guard('creative');
        $result = $auth->attempt(['email' => $data['email'], 'password' => $data['password']], false, false);
        if ($result) {
            $creative = Creative::where('email', $data['email'])->first();
            if ($creative->blocked == Creative::BLOCKED) {
                return $this->api('INVALID_DATA', null, ['email' => [trans('www.login.blocked')]]);
            }
            if ($creative->status == Creative::STATUS_PENDING) {
                return $this->api('INVALID_DATA', null, ['email' => [trans('www.login.not_confirmed')]]);
            }
            $auth->login($creative, $rememberMe);
            return $this->api('OK', ['link' => route('admin_creative_edit', $creative->id)]);
        }

        return $this->api('INVALID_DATA', null, ['email' => [trans('www.login.invalid_credentials')]]);
    }

    public function register(RegRequest $request)
    {
        $this->manager->register($request->all());
        return $this->api('OK', ['text' => trans('www.register.success.text')]);
    }

    public function forgot(ForgotRequest $request)
    {
        $data = $request->all();
        $brand = $agency = $creative = false;
        $user = Brand::where('email', $data['email'])->first();
        if ($user == null) {
            $user = Agency::where('email', $data['email'])->first();
            if ($user == null) {
                $user = Creative::where('email', $data['email'])->first();
                if ($user == null) {
                    return $this->api('INVALID_DATA', null, ['email' => [trans('www.email_not_exist')]]);
                } else {
                    $creative = true;
                }
            } else {
                $agency = true;
            }
        } else {
            $brand = true;
        }
        $this->manager->forgot($data, $brand, $agency, $creative);
        return $this->api('OK', ['text' => trans('www.forgot.success.text')]);
    }

    public function reset(ResetRequest $request)
    {
        $this->manager->reset($request->all());
        return $this->api('OK', ['text' => trans('www.reset.success.text'), 'link' => url_with_lng('/sign-in')]);
    }
}
