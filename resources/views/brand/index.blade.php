<?php

$description = mb_substr(trim(strip_tags($brand->about)), 0, 250);

$meta->title($brand->title);
$meta->description($description);
$meta->keywords(trans('www.homepage.keywords'));
$meta->ogTitle($brand->title);
$meta->ogDescription($description);
$image = empty($brand->cover) ? $brand->getImage() : $brand->getCover();
$meta->ogImage($image);
$meta->ogUrl($brand->getLink());

$fbSDK = true;

$url = $brand->getLink();
$pageMenu = 'brands';
?>
@extends('layout')

@section('content')

<div class="page">

    <div id="main-inner">

        <div id="main-left" class="fl">

            @include('blocks.main_top', ['model' => $brand])

            <ul class="menu">
                <li class="first{{$alias == 'ads' ? ' active' : ''}}"><a href="{{$url.'?ads=1'}}" class="fsb fs18">{{trans('www.base.label.ads')}}</a></li><li{!!$alias == 'creatives' ? ' class="active"' : ''!!}><a href="{{$url.'/key-people'}}" class="fsb fs18">{{trans('www.base.label.key_people')}}</a></li><li{!!$alias == 'awards' ? ' class="active"' : ''!!}><a href="{{$url.'/awards'}}" class="fsb fs18">{{trans('www.base.label.awards')}}</a></li><li{!!$alias == 'vacancies' ? ' class="active"' : ''!!}><a href="{{$url.'/vacancies'}}" class="fsb fs18">{{trans('www.base.label.vacancies')}}</a></li><li{!!$alias == 'news' ? ' class="active"' : ''!!}><a href="{{$url.'/news'}}" class="fsb fs18">{{trans('www.base.label.news')}}</a></li><li{!!$alias == 'agencies' ? ' class="active"' : ''!!}><a href="{{$url.'/partner-agencies'}}" class="fsb fs18">{{trans('www.base.label.partner_agencies')}}</a></li><li{!!$alias == 'about' ? ' class="active"' : ''!!}><a href="{{$url.'/about'}}" class="fsb fs18">{{trans('www.base.label.about')}}</a></li><li class="last{{$alias == 'contacts' ? ' active' : ''}}"><a href="{{$url.'/contacts'}}" class="fsb fs18">{{trans('www.base.label.contacts')}}</a></li>
            </ul>

            @if($alias == 'ads')
                <div id="items">
                    @include('blocks.items', ['items' => $items, 'ad' => true])
                    @include('pagination.default', ['pagination' => $items])
                </div>
            @elseif($alias == 'creatives' || $alias == 'agencies')
                <div id="items">
                    @include('blocks.items', ['items' => $items, 'ad' => false])
                    @include('pagination.default', ['pagination' => $items])
                </div>
            @elseif($alias == 'awards')
                @include('blocks.awards', ['awards' => $awards])
            @elseif($alias == 'vacancies')
                @include('blocks.vacancies', ['vacancies' => $vacancies])
            @elseif($alias == 'news')
                @include('blocks.news', ['news' => $news])
            @elseif($alias == 'about')
                @include('blocks.about', ['about' => $brand->about])
            @elseif($alias == 'contacts')
                @include('blocks.branches', ['branches' => $branches])
            @endif

        </div>
        <div id="main-right" class="fr">
            @include('blocks.main_right')
        </div>
        <div class="cb"></div>

    </div>

</div>
@if($scroll)
    <script type="text/javascript">
        $(document).ready(function() {
            $('html, body').animate({
                scrollTop: 565
            }, 400);
        });
    </script>
@endif

@stop