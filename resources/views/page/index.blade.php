<?php

$description = mb_substr(trim(strip_tags($page->text)), 0, 250);

$meta->title($page->title);
$meta->description($description);
$meta->keywords(trans('www.homepage.keywords'));
$meta->ogTitle($page->title);
$meta->ogDescription($description);
$meta->ogImage(url('/imgs/og-logo.jpg'));
$meta->ogUrl(url_with_lng('/page/'.$page->alias));

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