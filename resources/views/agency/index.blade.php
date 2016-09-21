<?php
$title = $agency->title;

$description = mb_substr(trim(strip_tags($agency->about)), 0, 250);

$meta->title($agency->title);
$meta->description($description);
$meta->keywords(trans('www.homepage.keywords'));
$meta->ogTitle($agency->title);
$meta->ogDescription($description);
$image = empty($agency->cover) ? $agency->getImage() : $agency->getCover();
$meta->ogImage($image);
$meta->ogUrl($agency->getLink());

$fbSDK = true;

$url = $agency->getLink();
$pageMenu = 'agencies';
?>
@extends('layout')

@section('content')

<div class="page">

    <div id="main-inner">

        <div id="main-left" class="fl">

            @include('blocks.main_top', ['model' => $agency])

            <ul class="menu">
                <li class="first{{$alias == 'work' ? ' active' : ''}}"><a href="{{$url.'?work=1'}}" class="fsb fs18">{{trans('www.base.label.work')}}</a></li><li{!!$alias == 'creatives' ? ' class="active"' : ''!!}><a href="{{$url.'/creatives'}}" class="fsb fs18">{{trans('www.base.label.creatives')}}</a></li><li{!!$alias == 'awards' ? ' class="active"' : ''!!}><a href="{{$url.'/awards'}}" class="fsb fs18">{{trans('www.base.label.awards')}}</a></li><li{!!$alias == 'vacancies' ? ' class="active"' : ''!!}><a href="{{$url.'/vacancies'}}" class="fsb fs18">{{trans('www.base.label.vacancies')}}</a></li><li{!!$alias == 'news' ? ' class="active"' : ''!!}><a href="{{$url.'/news'}}" class="fsb fs18">{{trans('www.base.label.news')}}</a></li><li{!!$alias == 'brands' ? ' class="active"' : ''!!}><a href="{{$url.'/clients'}}" class="fsb fs18">{{trans('www.base.label.clients')}}</a></li><li{!!$alias == 'about' ? ' class="active"' : ''!!}><a href="{{$url.'/about'}}" class="fsb fs18">{{trans('www.base.label.about')}}</a></li><li class="last{{$alias == 'contacts' ? ' active' : ''}}"><a href="{{$url.'/contacts'}}" class="fsb fs18">{{trans('www.base.label.contacts')}}</a></li>
            </ul>

            @if($alias == 'work')
                <div id="items">
                    @include('blocks.items', ['items' => $items, 'ad' => true])
                    @include('pagination.default', ['pagination' => $items])
                </div>
            @elseif($alias == 'creatives' || $alias == 'brands')
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
                @include('blocks.about', ['about' => $agency->about])
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