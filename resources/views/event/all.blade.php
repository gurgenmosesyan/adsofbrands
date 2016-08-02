<?php
$title = trans('www.menu.meeting_events');
$page = 'events';
?>
@extends('layout')

@section('content')

<div class="page">
    <div id="page-title">
        <h1 class="title">{{$title}}</h1>
    </div>
</div>

<div class="page">

    <div id="events-top">
        <div class="top-box events-top-left tc fl">
            <div class="dib">{!!trans('www.events.top.left.text')!!}</div>
        </div>
        <div class="top-box events-top-right tc fl">
            <div class="dib">{!!trans('www.events.top.right.text')!!}</div>
        </div>
        <div class="cb"></div>
    </div>

    <div id="events-first-text" class="html-content">{!!$eventText->text!!}</div>

    <div id="offers">
        @foreach($events as $key => $event)
            <div class="offer-item {{$key%2 == 0 ? 'odd' : 'even'}}">
                <h2 class="tu">{{$event->title}}</h2>
                <div class="html-content">{!!$event->text!!}</div>
            </div>
        @endforeach
    </div>

    <div id="slider-block" class="events-slider">
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

</div>
<script type="text/javascript">
    $main.initSlider();
</script>

@stop
