<?php
$title = trans('www.booking.head_title');
$page = null;
$bookingPage = true;
$lngCode = cLng('code');
?>
@extends('layout')

@section('content')

<div class="page">
    <div id="page-title">
        <h1 class="title">{{$title}}</h1>
    </div>
</div>

<div class="page">
    <div id="booking-steps">
        <div class="step-box fl tc first">
            <a href="{{url_with_lng('/booking', false)}}" class="step-item db">
                <span class="db fl left">1</span>
                <span class="db right"><span>{{trans('www.booking.step.1')}}</span></span>
                <span class="fl"></span>
            </a>
        </div>
        <div class="step-box fl tc">
            <a href="{{url_with_lng('/booking/rooms', false)}}" class="step-item db">
                <span class="db fl left">2</span>
                <span class="db right"><span>{{trans('www.booking.step.2')}}</span></span>
                <span class="fl"></span>
            </a>
        </div>
        <div class="step-box fl tc">
            <a href="{{url_with_lng('/booking/info', false)}}" class="step-item db">
                <span class="db fl left">3</span>
                <span class="db right"><span>{{trans('www.booking.step.3')}}</span></span>
                <span class="fl"></span>
            </a>
        </div>
        @for($i = 4; $i < 6; $i++)
            <div class="step-box fl tc{{$i == 4 ? ' active' : ''}}">
            <span class="step-item db">
                <span class="db fl left">{{$i}}</span>
                <span class="db right"><span>{{trans('www.booking.step.'.$i)}}</span></span>
                <span class="fl"></span>
            </span>
            </div>
        @endfor
        <div class="cb"></div>
    </div>

    <div id="booking-4">

        <h2 class="tc">{{trans('www.booking.payment.select_type')}}</h2>

        <div class="tc">
            <div class="dib btn-box">
                <form action="{{route('booking_ameria', $lngCode)}}" method="post">
                    {{csrf_field()}}
                    <input type="submit" class="btn" value="{{trans('www.booking.payment.ameria')}}" />
                </form>
            </div>
            <div class="dib btn-box">
                <form action="{{route('booking_cash', $lngCode)}}" method="post">
                    {{csrf_field()}}
                    <input type="submit" class="btn" value="{{trans('www.booking.payment.cash')}}" />
                </form>
            </div>
        </div>

    </div>

</div>
<script type="text/javascript">
    $('html, body').animate({scrollTop: 600}, 500);
</script>
@stop