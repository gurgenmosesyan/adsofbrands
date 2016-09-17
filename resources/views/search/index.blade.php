<?php
$title = trans('www.search.title');
?>
@extends('layout')

@section('content')

<div class="page">

    <div id="main-inner">

        <div id="main-left" class="fl">

            @if(mb_strlen($q) < 2)
                <p class="empty-search fs18">{{trans('www.search.min_chars')}}</p>
            @elseif($brands->isEmpty() && $agencies->isEmpty() && $ads->isEmpty() && $creatives->isEmpty() && $news->isEmpty())
                <p class="empty-search fs18">{!!trans('www.search.empty_result', ['q' => htmlentities($q)])!!}</p>
            @endif

            @if(!$brands->isEmpty())
                <div class="search-box">
                    <h3 class="fsb fs20">{{trans('www.base.label.brands').' ('.$brands->count().')'}}</h3>
                    @include('blocks.items', ['items' => $brands, 'ad' => false])
                </div>
            @endif

            @if(!$agencies->isEmpty())
                <div class="search-box">
                    <h3 class="fsb fs20">{{trans('www.base.label.agencies').' ('.$agencies->count().')'}}</h3>
                    @include('blocks.items', ['items' => $agencies, 'ad' => false])
                </div>
            @endif

            @if(!$creatives->isEmpty())
                <div class="search-box">
                    <h3 class="fsb fs20">{{trans('www.base.label.creatives').' ('.$creatives->count().')'}}</h3>
                    @include('blocks.items', ['items' => $creatives, 'ad' => false])
                </div>
            @endif

            @if(!$ads->isEmpty())
                <div class="search-box">
                    <h3 class="fsb fs20">{{trans('www.base.label.ads').' ('.$ads->count().')'}}</h3>
                    @include('blocks.items', ['items' => $ads, 'ad' => true])
                </div>
            @endif

            @if(!$news->isEmpty())
                <div class="search-box">
                    <h3 class="fsb fs20">{{trans('www.base.label.news').' ('.$news->count().')'}}</h3>
                    @include('blocks.news', ['news' => $news, 'notPaginate' => true])
                </div>
            @endif

        </div>

        <div id="main-right" class="fr">
            @include('blocks.main_right')
        </div>
        <div class="cb"></div>

    </div>

</div>

@stop


