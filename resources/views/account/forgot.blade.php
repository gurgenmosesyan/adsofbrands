<?php
use App\Models\Account\Account;

$title = trans('www.reset_password.title');

$meta->title($title);
$meta->ogTitle($title);
$meta->ogImage(url('/imgs/og-logo.jpg'));

?>
@extends('layout')

@section('content')

<div id="account">
    <div class="page">
        <h1 class="tc fsb fs36">{{$title}}</h1>
        <form id="forgot-form" action="{{url_with_lng('/api/forgot')}}" method="post">
            <div class="form-box">
                <input type="text" name="email" class="fs18" placeholder="{{trans('www.base.label.email')}}" />
                <div id="form-error-email" class="form-error"></div>
            </div>
            <div class="form-box account-buttons">
                {{csrf_field()}}
                <div>
                    <input type="submit" class="fb fs22" value="{{trans('www.base.label.reset')}}" />
                </div>
            </div>
        </form>
    </div>
</div>

@stop