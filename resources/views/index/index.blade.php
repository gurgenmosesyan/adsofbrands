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
                    <div class="cb"></div>
                </div>
            </div>
            <div class="cb"></div>
        </div>
    </div>
</div>

<div id="features-ads">
    @include('blocks.carousel', ['items' => $featuresAds, 'title' => trans('www.base.label.features'), 'text' => trans('www.base.label.features.text')])
</div>
<div id="top-ads">
    @include('blocks.carousel', ['items' => $topAds, 'title' => trans('www.base.label.top_ads'), 'text' => trans('www.base.label.top_ads.text')])
</div>
<div id="home-ad1" class="tc">
    <a href="#"><img src="{{url('/imgs/temp/ad1.jpg')}}" /></a>
</div>
<div id="top-rated-agencies">
    @include('blocks.carousel', ['items' => $topRatedAgencies, 'title' => trans('www.base.label.top_rated_agencies'), 'text' => trans('www.base.label.top_rated_agencies.text')])
</div>
<div id="top-brands">
    @include('blocks.carousel', ['items' => $topBrands, 'title' => trans('www.base.label.top_brands'), 'text' => trans('www.base.label.top_brands.text')])
</div>
<div id="home-ad2" class="tc">
    <a href="#"><img src="{{url('/imgs/temp/ad2.jpg')}}" /></a>
</div>

<div id="latest-news">
    <div class="page">
        <div class="fl">
            <div class="title-box">
                <h2 class="fl tu fb fs38">{{trans('www.base.label.latest_news')}}</h2>
                <div class="fr">
                    <a href="{{url_with_lng('/news', true)}}" class="btn see-all">{{trans('www.base.label.see_all')}}</a>
                </div>
                <div class="cb"></div>
            </div>
            <div class="latest-news">
                @foreach($latestNews as $value)
                    <div class="news">
                        <div class="img">
                            <a href="{{url_with_lng('/news/'.$value->id)}}"><img src="{{$value->getImage()}}" width="332" /></a>
                        </div>
                        <div class="date fs14 tu">{{strftime('%b. %d, %Y', strtotime($value->created_at))}}</div>
                        <h3 class="fb fs26">{{$value->title}}</h3>
                        <p class="fs20">{{$value->description}}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="ad fr">
            <a href="#"><img src="{{url('/imgs/temp/ad3.jpg')}}" /></a>
        </div>
        <div class="cb"></div>
    </div>
</div>
<script type="text/javascript">
    $main.initItemsCar();
</script>

@stop