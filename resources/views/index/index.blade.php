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
        <div class="titles">
            <h1 class="fb fs34">{!!trans('www.home.top.title')!!}</h1>
            <p class="light fs20">{{trans('www.home.top.sub_title')}}</p>
        </div>
    </div>
</div>

<div id="home-main">
    <div class="bg-right"></div>
    <div class="dot-bg">
        <div class="page">
            <div class="fl bg-ads"></div>
            <div class="fl info-box">
                <h2 class="fb fs40">{{trans('www.home.main.title')}}</h2>
                <p class="sub-title fs20">{{trans('www.home.main.sub_title')}}</p>
                <h3 class="fb fs22">{{trans('www.home.main.title2')}}</h3>
                <p class="fb info fs20">{{trans('www.home.main.text1')}}</p>
                <p class="fb info fs20">{{trans('www.home.main.text2')}}</p>
                <p class="fb info fs20">{{trans('www.home.main.text3')}}</p>
                <div class="btn-box">
                    <a href="" class="btn-black">{{trans('www.btn.see_all_ads')}}</a>
                </div>
                <div class="social-box">
                    <div class="fl social-title fs20">{{trans('www.home.main.social.title')}}</div>
                    <a href="{{trans('www.social.link.fb')}}" class="facebook social db fl" target="_blank"></a>
                    <a href="{{trans('www.social.link.twitter')}}" class="twitter social db fl" target="_blank"></a>
                    <a href="{{trans('www.social.link.google')}}" class="google social db fl" target="_blank"></a>
                    <a href="{{trans('www.social.link.youtube')}}" class="youtube social db fl" target="_blank"></a>
                </div>
            </div>
            <div class="cb"></div>
        </div>
    </div>
</div>

@stop