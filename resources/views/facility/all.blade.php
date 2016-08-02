<?php
$title = trans('www.menu.hotel_facilities');
$page = 'facilities';

$count = $facilities->count();
$separator = ceil($count / 2);
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
            <div class="dib">{!!trans('www.facilities.top.left.text')!!}</div>
        </div>
        <div class="top-box events-top-right tc fl">
            <div class="dib">{!!trans('www.facilities.top.right.text')!!}</div>
        </div>
        <div class="cb"></div>
    </div>

    <div id="facilities">
        <div class="facility-box left tc fl">
            <div class="center-box dib">
                @foreach($facilities->slice(0, $separator) as $facility)
                    <div class="facility-item">
                        <a href="{{url_with_lng('/hotel-facilities/'.$facility->id, false)}}" class="db">
                            {{$facility->title}}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="facility-box right tc fl">
            <div class="center-box dib">
                @foreach($facilities->slice($separator) as $facility)
                    <div class="facility-item">
                        <a href="{{url_with_lng('/hotel-facilities/'.$facility->id, false)}}" class="db">
                            {{$facility->title}}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="cb"></div>
    </div>

    <div id="slider-block" class="facility-slider">
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
