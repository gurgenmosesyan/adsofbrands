<?php
$title = trans('www.menu.special_offers');
$page = 'offers';
?>
@extends('layout')

@section('content')

<div class="page">
    <div id="page-title">
        <h1 class="title">{{$title}}</h1>
    </div>
</div>

<div class="page">

    <div id="offers-first-text" class="html-content">{!!$offerText->text!!}</div>

    <div id="offers">
        @foreach($offers as $key => $offer)
            <div class="offer-item {{$key%2 == 0 ? 'odd' : 'even'}}">
                <h2 class="tu">{{$offer->title}}</h2>
                <div class="html-content">{!!$offer->text!!}</div>
            </div>
        @endforeach
    </div>

    <div id="slider-block" class="offers-slider">
        <div id="slider" class="owl-carousel">
            @foreach($slider as $item)
                <div class="slider-item" style="background-image: url('{{$item->first_image->getImage()}}');">
                    <a href="{{url_with_lng('/hotel-facilities/'.$item->id)}}" class="db">
                        <span class="slider-title title">{{$item->title}}</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div id="offer-bottom">
        <div class="offer-bottom-text tc">{!!trans('www.special_offers.bottom_text')!!}</div>
    </div>

</div>
<script type="text/javascript">
    $main.initSlider();
</script>

@stop
