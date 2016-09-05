<?php
$title = trans('www.news.list.title');

$fbSDK = true;
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