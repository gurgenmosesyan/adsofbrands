<?php
use App\Image\Image;
use App\Models\Banner\Banner;

$head->appendStyle('/css/owl.carousel.css');
$head->appendScript('/js/owl.carousel.min.js');

$meta->title(trans('www.homepage.title'), false);
$meta->description(trans('www.home.top.sub_title'));
$meta->keywords(trans('www.homepage.keywords'));
$meta->ogTitle(trans('www.homepage.title'));
$meta->ogDescription(trans('www.home.top.sub_title'));
$meta->ogImage(url('/imgs/og-logo.jpg'));
$meta->ogUrl(url_with_lng('/'));

?>
@extends('layout')

@section('content')

<div id="home-top" class="tc">
    <div class="overlay">
        <div class="titles">
            <h1 class="fb fs34">{!!trans('www.home.top.title')!!}</h1>
            <p class="light fs20 lh22">{{trans('www.home.top.sub_title')}}</p>
        </div>
    </div>
</div>

<div id="home-main">
    <div class="bg-right"></div>
    <div class="dot-bg">
        <div class="page">
            <div class="bg-coms fl"></div>
            <div class="info-box">
                <h2 class="fb fs40">{{trans('www.home.main.title')}}</h2>
                <p class="sub-title fs20 lh22">{{trans('www.home.main.sub_title')}}</p>
                <h3 class="fb fs22">{{trans('www.home.main.title2')}}</h3>
                <p class="fb info fs20">{{trans('www.home.main.text1')}}</p>
                <p class="fb info fs20">{{trans('www.home.main.text2')}}</p>
                <p class="fb info fs20">{{trans('www.home.main.text3')}}</p>
                <div class="btn-box">
                    <a href="{{url_with_lng('/ads', true)}}" class="btn-black">{{trans('www.btn.see_all_ads')}}</a>
                </div>
                <div class="social-box">
                    <div class="fl social-title fs20">{{trans('www.home.main.social.title')}}</div>
                    <span class="db fl">
                        <a href="{{trans('www.social.link.fb')}}" class="facebook social db fl" target="_blank"></a>
                        <a href="{{trans('www.social.link.twitter')}}" class="twitter social db fl" target="_blank"></a>
                        <a href="{{trans('www.social.link.google')}}" class="google social db fl" target="_blank"></a>
                        <a href="{{trans('www.social.link.youtube')}}" class="youtube social db fl" target="_blank"></a>
                        <a href="{{trans('www.social.link.instagram')}}" class="instagram social db fl" target="_blank"></a>
                        <a href="{{trans('www.social.link.pinterest')}}" class="pinterest social db fl" target="_blank"></a>
                        <span class="cb"></span>
                    </span>
                    <div class="cb"></div>
                </div>
            </div>
            <div class="cb"></div>
        </div>
    </div>
</div>

<div id="features-ads">
    @include('blocks.carousel', [
        'items' => $featuresAds,
        'ad' => true,
        'title' => trans('www.base.label.features'),
        'text' => trans('www.base.label.features.text'),
        'link' => url_with_lng('/ads', true)
    ])
</div>
<div id="top-ads">
    @include('blocks.carousel', [
        'items' => $topAds,
        'ad' => true,
        'title' => trans('www.base.label.top_ads'),
        'text' => trans('www.base.label.top_ads.text'),
        'link' => url_with_lng('/ads', true)
    ])
</div>
<div id="home-gov1" class="tc">
    {!!$banners[Banner::KEY_HOMEPAGE_1]->getBanner()!!}
</div>
<div id="top-rated-agencies">
    @include('blocks.carousel', [
        'items' => $topAgencies,
        'ad' => false,
        'title' => trans('www.base.label.top_agencies'),
        'text' => trans('www.base.label.top_rated_agencies.text'),
        'link' => url_with_lng('/agencies', true)
    ])
</div>
<div id="top-brands">
    @include('blocks.carousel', [
        'items' => $topBrands,
        'ad' => false,
        'title' => trans('www.base.label.top_brands'),
        'text' => trans('www.base.label.top_brands.text'),
        'link' => url_with_lng('/brands', true)
    ])
</div>
<div id="home-gov2" class="tc">
    {!!$banners[Banner::KEY_HOMEPAGE_2]->getBanner()!!}
</div>

<div id="news-box">
    <div class="page">
        <div class="news-right fr">
            {!!$banners[Banner::KEY_HOMEPAGE_RIGHT]->getBanner()!!}
        </div>
        <div class="news-left">
            <div class="title-box">
                <h2 class="fl tu fb fs38">{{trans('www.base.label.latest_news')}}</h2>
                <div class="news-see-all fr">
                    <a href="{{url_with_lng('/news', true)}}" class="btn see-all">{{trans('www.base.label.see_all')}}</a>
                </div>
                <div class="cb"></div>
            </div>
            <div class="news-box">
                @foreach($latestNews as $value)<div class="news">
                        <div class="img">
                            <a href="{{$value->getLink()}}"><img src="{{$value->getImage()}}" width="332" /></a>
                        </div>
                        <div class="date fs14 tu">{{strftime('%b. %d, %Y', strtotime($value->created_at))}}</div>
                        <h3 class="fb fs26">
                            <a href="{{$value->getLink()}}">{{$value->title}}</a>
                        </h3>
                        <p class="fs20">{{$value->description}}</p>
                    </div>@endforeach
            </div>
        </div>
        <div class="cb"></div>
    </div>
</div>
<script type="text/javascript">
    $main.initItemsCar();
</script>

@stop