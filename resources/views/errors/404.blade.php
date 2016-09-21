<?php

$title = trans('www.404.title');

$meta->title($title);

$page = null;

?>
@extends('layout')

@section('content')

<div class="page">
    <div id="error" class="tc">
        <h1 class="fs40 fb">{{$title}}</h1>
        <p class="fs24">{{trans('www.404.text')}}</p>
    </div>
</div>

@stop