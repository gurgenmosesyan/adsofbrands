<?php
use App\Models\Account\Account;

$head->appendScript('/js/account.js');

$title = trans('www.sign_in.title');

$meta->title($title);
$meta->ogTitle($title);
$meta->ogImage(url('/imgs/og-logo.jpg'));

?>
@extends('layout')

@section('content')

<div id="account">
    <div class="page">
        <h1 class="tc fsb fs36">{{$title}}</h1>
        <form id="login-form" action="{{url_with_lng('/api/login')}}" method="post">
            <div class="form-box">
                <input type="text" name="email" class="fs18" placeholder="{{trans('www.base.label.email')}}" />
                <div id="form-error-email" class="form-error"></div>
            </div>
            <div class="form-box">
                <input type="password" name="password" class="fs18" placeholder="{{trans('www.base.label.password')}}" />
                <div id="form-error-password" class="form-error"></div>
            </div>
            <div class="form-box account-buttons">
                {{csrf_field()}}
                <div class="fl">
                    <input type="submit" class="fb fs22" value="{{trans('www.sign_in.title')}}" />
                </div>
                <div class="fr fs18 sign-in-link">
                    {{trans('www.account.forgot_password')}}
                    <a href="{{url_with_lng('/reset')}}" class="underline">{{trans('www.base.label.reset')}}</a>
                </div>
                <div class="cb"></div>
            </div>
        </form>
    </div>
</div>

@stop