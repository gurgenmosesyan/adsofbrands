<?php
use App\Models\Account\Account;

$head->appendScript('/js/account.js');

$title = trans('www.reset_password.title');
?>
@extends('layout')

@section('content')

<div id="account">
    <div class="page">
        <h1 class="tc fsb fs36">{{$title}}</h1>
        @if($data['wrong_hash'])
            <p class="fs18 tc">{{$data['message']}}</p>
        @else
            <form id="reset-form" action="{{url_with_lng('/api/reset')}}" method="post">
                <div class="form-box">
                    <input type="password" name="password" class="fs18" placeholder="{{trans('www.base.label.password')}}" />
                    <div id="form-error-password" class="form-error"></div>
                </div>
                <div class="form-box">
                    <input type="password" name="re_password" class="fs18" placeholder="{{trans('www.base.label.retype_password')}}" />
                    <div id="form-error-re_password" class="form-error"></div>
                </div>
                <div class="form-box account-buttons">
                    <input type="hidden" name="hash" value="{{$data['hash']}}" />
                    {{csrf_field()}}
                    <div class="fl">
                        <input type="submit" class="fb fs22" value="{{trans('www.base.label.reset')}}" />
                    </div>
                    <div class="cb"></div>
                </div>
            </form>
        @endif
    </div>
</div>

@stop