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
        @for($i = 1; $i < 6; $i++)
            <div class="step-box fl tc{{$i == 1 ? ' first active' : ''}}">
                <span class="step-item db">
                    <span class="db fl left">{{$i}}</span>
                    <span class="db right"><span>{{trans('www.booking.step.'.$i)}}</span></span>
                    <span class="fl"></span>
                </span>
            </div>
        @endfor
        <div class="cb"></div>
    </div>

    <div id="booking-1" class="tc">
        <h2>{{trans('www.booking.step1.text')}}</h2>

        <form action="{{url_with_lng('/booking/rooms', false)}}" method="post">
            <div class="dib left">
                <p>{{trans('www.booking.arrival_date')}}</p>
                <div>
                    <input type="text" id="from" value="{{date('d/m/Y', strtotime($startDate))}}" />
                    <input type="hidden" id="from-hidden" name="start_date" value="{{date('Y-m-d', strtotime($startDate))}}" />
                </div>
            </div>
            <div class="dib right">
                <p>{{trans('www.booking.depart_date')}}</p>
                <div>
                    <input type="text" id="to" value="{{date('d/m/Y', strtotime($endDate))}}" />
                    <input type="hidden" id="to-hidden" name="end_date" value="{{date('Y-m-d', strtotime($endDate))}}" />
                </div>
            </div>
            <div class="cb"></div>
            {{csrf_field()}}
            <input type="submit" class="btn tu" value="{{trans('www.booking.show_available_rooms')}}" />
        </form>

    </div>

</div>
<script type="text/javascript">
    $('html, body').animate({scrollTop: 600}, 500);
</script>
@stop