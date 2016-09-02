<?php
$title = $creative->title;

$fbSDK = true;

$url = $creative->getLink();
?>
@extends('layout')

@section('content')

    <div class="page">

        <div id="main-inner">

            <div id="main-left" class="fl">

                @include('blocks.main_top', ['model' => $creative])

                <ul class="menu">
                    <li class="first{{$alias == 'ads' ? ' active' : ''}}"><a href="{{$url}}" class="fsb fs18">{{trans('www.base.label.ads')}}</a></li><li{!!$alias == 'clients' ? ' class="active"' : ''!!}><a href="{{$url.'/clients'}}" class="fsb fs18">{{trans('www.base.label.clients')}}</a></li><li{!!$alias == 'awards' ? ' class="active"' : ''!!}><a href="{{$url.'/awards'}}" class="fsb fs18">{{trans('www.base.label.awards')}}</a></li><li{!!$alias == 'about' ? ' class="active"' : ''!!}><a href="{{$url.'/about'}}" class="fsb fs18">{{trans('www.base.label.about')}}</a></li>
                </ul>

                @if($alias == 'ads')
                    <div id="items">
                        @include('blocks.items', ['items' => $items, 'ad' => true])
                    </div>
                @elseif($alias == 'brands')
                    <div id="items">
                        @include('blocks.items', ['items' => $items, 'ad' => false])
                    </div>
                @elseif($alias == 'awards')
                    @include('blocks.awards', ['awards' => $awards])
                @elseif($alias == 'about')
                    @include('blocks.about', ['about' => $creative->about])
                @endif

            </div>
            <div id="main-right" class="fr">
                @include('blocks.main_right')
            </div>
            <div class="cb"></div>

        </div>

    </div>

@stop