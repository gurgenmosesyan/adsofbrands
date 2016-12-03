<?php
use App\Models\Account\Account;

$title = trans('www.register.title');

$meta->title($title);
$meta->ogTitle($title);
$meta->ogImage(url('/imgs/og-logo.jpg'));

?>
@extends('layout')

@section('content')

<div id="account">
    <div class="page">
        <h1 class="tc fsb fs36">{{$title}}</h1>
        <form id="register-form" action="{{url_with_lng('/api/register')}}" method="post">
            <div class="form-box">
                <div class="select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title fs18"></div>
                    <select name="type">
                        <option value="{{Account::TYPE_CREATIVE}}">{{trans('www.base.label.creative')}}</option>
                        <option value="{{Account::TYPE_BRAND}}">{{trans('www.base.label.brand')}}</option>
                        <option value="{{Account::TYPE_AGENCY}}">{{trans('www.base.label.agency')}}</option>
                    </select>
                </div>
                <div id="form-error-type" class="form-error"></div>
            </div>
            <div class="form-box">
                <input type="text" name="email" class="fs18" placeholder="{{trans('www.base.label.email')}}" />
                <div id="form-error-email" class="form-error"></div>
            </div>
            <div class="form-box">
                <input type="password" name="password" class="fs18" placeholder="{{trans('www.base.label.password')}}" />
                <div id="form-error-password" class="form-error"></div>
            </div>
            <div class="form-box">
                <input type="password" name="re_password" class="fs18" placeholder="{{trans('www.base.label.retype_password')}}" />
                <div id="form-error-re_password" class="form-error"></div>
            </div>
            <div class="form-box agree-terms">
                <input type="checkbox" name="terms" class="fs18" value="{{Account::TERMS}}" />
                {!! trans('www.base.label.agree_terms', ['url' => url_with_lng('/page/terms-of-use')]) !!}
                <div id="form-error-terms" class="form-error"></div>
            </div>
            <div class="form-box account-buttons">
                {{csrf_field()}}
                <div class="fl">
                    <input type="submit" class="fb fs22" value="{{trans('www.register.title')}}" />
                </div>
                <div class="fr fs18 sign-in-link">
                    {{trans('www.account.already_member')}}
                    <a href="{{url_with_lng('/sign-in')}}" class="underline">{{trans('www.base.label.sign_in')}}</a>
                </div>
                <div class="cb"></div>
            </div>
        </form>
    </div>
</div>

@stop