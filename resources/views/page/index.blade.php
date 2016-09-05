<?php
$title = $page->title;

$fbSDK = true;
?>
@extends('layout')

@section('content')

<div class="page">

    <div id="main-inner">

        <div id="main-left" class="fl">

            <div class="html">
                <h1 class="tc">{{$page->title}}</h1>
                {!!$page->text!!}
            </div>

        </div>
        <div id="main-right" class="fr">
            @include('blocks.main_right')
        </div>
        <div class="cb"></div>

    </div>

</div>

@stop