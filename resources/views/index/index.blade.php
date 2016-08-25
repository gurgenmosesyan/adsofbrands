<?php
use App\Image\Image;

$head->appendStyle('/css/owl.carousel.css');
$head->appendScript('/js/owl.carousel.min.js');

$title = trans('www.homepage.title');
?>
@extends('layout')

@section('content')

<div id="home-top" class="tc">
    <div class="overlay">
        <h1 class="fb">{!!trans('www.home.top.title')!!}</h1>
    </div>
</div>

<div id="home-main"></div>

@stop