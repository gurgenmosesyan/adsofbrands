<?php
$title = trans('www.booking.head_title');
$page = null;
$bookingPage = true;
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
        <div class="step-box fl tc">
            <a href="{{url_with_lng('/booking/payment', false)}}" class="step-item db">
                <span class="db fl left">4</span>
                <span class="db right"><span>{{trans('www.booking.step.4')}}</span></span>
                <span class="fl"></span>
            </a>
        </div>
        <div class="step-box fl tc active">
            <span class="step-item db">
                <span class="db fl left">5</span>
                <span class="db right"><span>{{trans('www.booking.step.5')}}</span></span>
                <span class="fl"></span>
            </span>
        </div>
        <div class="cb"></div>
    </div>

    <div id="booking-5" class="tc">

        <p class="booking-result {{$success ? 'success' : 'error'}}">{{$message}}</p>

        <?php
        if (isset($ameria)) {
            $conf = config('ameria');
            $cLngCode = cLng('code');
            $cLngCode = $cLngCode == 'hy' ? 'am' : $cLngCode;
            echo '<iframe id="idIframe" src="'.$conf['check_url'].'?lang='.$cLngCode.'&paymentid='.$paymentId.'" width="560px" height="820px" frameborder="0"></iframe>';
        }
        ?>

    </div>

</div>
    <script type="text/javascript">
        $('html, body').animate({scrollTop: 600}, 500);
    </script>
@stop