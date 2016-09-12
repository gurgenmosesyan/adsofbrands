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
                <div>
                    @include('blocks.items', ['items' => $brands, 'ad' => false])
                </div>
            @endif

            @if(!$agencies->isEmpty())
                <div>
                    @include('blocks.items', ['items' => $agencies, 'ad' => false])
                </div>
            @endif

            @if(!$creatives->isEmpty())
                <div>
                    @include('blocks.items', ['items' => $creatives, 'ad' => false])
                </div>
            @endif

            @if(!$ads->isEmpty())
                <div>
                    @include('blocks.items', ['items' => $ads, 'ad' => true])
                </div>
            @endif

            @if(!$news->isEmpty())
                @include('blocks.news', ['news' => $news, 'notPaginate' => true])
            @endif

        </div>

        <div id="main-right" class="fr">
            @include('blocks.main_right')
        </div>
        <div class="cb"></div>

    </div>

</div>

@stop


