<?php

$meta->title(trans('www.news.list.title'));
$meta->description(trans('www.news.list.description'));
$meta->keywords(trans('www.homepage.keywords'));
$meta->ogTitle(trans('www.news.list.title'));
$meta->ogDescription(trans('www.news.list.description'));
$meta->ogImage(url('/imgs/og-logo.jpg'));
$meta->ogUrl(url_with_lng('/news'));

$fbSDK = true;
$pageMenu = 'news';
?>
@extends('layout')

@section('content')

    <div class="page">

        <div id="main-inner">

            <div id="main-left" class="fl">

                @include('blocks.news', ['news' => $news])

            </div>
            <div id="main-right" class="fr">
                @include('blocks.main_right')
            </div>
            <div class="cb"></div>

        </div>

    </div>

@stop