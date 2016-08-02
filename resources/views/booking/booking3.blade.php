<?php
$title = trans('www.booking.head_title');
$page = null;
$bookingPage = true;
$cLngCode = cLng('code');
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
        @for($i = 3; $i < 6; $i++)
            <div class="step-box fl tc{{$i == 3 ? ' active' : ''}}">
                <span class="step-item db">
                    <span class="db fl left">{{$i}}</span>
                    <span class="db right"><span>{{trans('www.booking.step.'.$i)}}</span></span>
                    <span class="fl"></span>
                </span>
            </div>
        @endfor
        <div class="cb"></div>
    </div>

    <div id="booking-3">
        <form id="booking-3-form" action="{{url_with_lng('/api/booking/info', false)}}" method="post">
            @foreach($accommodations as $key => $acc)
                <h2>{{$acc->title}}</h2>
                <div class="row">
                    <div class="left fl"><label class="required">{{trans('www.booking.guests_name')}}</label></div>
                    <div class="middle fl">
                        <div class="form-box">
                            <input type="text" name="info[{{$key}}][first_name]" placeholder="{{trans('www.booking.first_name')}}" />
                            <div id="form-error-info_{{$key}}_first_name" class="form-error"></div>
                        </div>
                    </div>
                    <div class="right fl">
                        <div class="form-box">
                            <input type="text" name="info[{{$key}}][last_name]" placeholder="{{trans('www.booking.last_name')}}" />
                            <div id="form-error-info_{{$key}}_last_name" class="form-error"></div>
                        </div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="row">
                    <div class="left fl"><label class="required">{{trans('www.booking.citizenship')}}</label></div>
                    <div class="middle fl">
                        <div class="form-box">
                            <div class="select-box">
                                <div class="select-arrow"></div>
                                <div class="select-title"></div>
                                <select name="info[{{$key}}][citizenship]">
                                    <option value="">{{trans('www.base.label.select')}}</option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{ $country->{"name_{$cLngCode}"} }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="form-error-info_{{$key}}_citizenship" class="form-error"></div>
                        </div>
                    </div>
                    <div class="cb"></div>
                </div>
                <div class="separator"></div>
            @endforeach
            <h2>{{trans('www.booking.contact_info')}}</h2>
            <div class="row">
                <div class="left fl"><label class="required">{{trans('www.booking.contact_phone')}}</label></div>
                <div class="long fl">
                    <div class="form-box">
                        <input type="text" name="phone" />
                        <p class="help">{{trans('www.booking.contact_phone.help')}}</p>
                        <div id="form-error-phone" class="form-error"></div>
                    </div>
                </div>
                <div class="cb"></div>
            </div>
            <div class="row">
                <div class="left fl"><label class="required">{{trans('www.booking.email')}}</label></div>
                <div class="long fl">
                    <div class="form-box">
                        <input type="text" name="email" />
                        <p class="help">{{trans('www.booking.email.help')}}</p>
                        <div id="form-error-email" class="form-error"></div>
                    </div>
                </div>
                <div class="cb"></div>
            </div>
            <div class="row">
                <div class="left fl"><label>{{trans('www.booking.arrival_time.text')}}</label></div>
                <div class="long time fl">{{trans('www.booking.arrival_time')}}</div>
                <div class="cb"></div>
            </div>
            <div class="row">
                <div class="left fl"><label>{{trans('www.booking.departure_time.text')}}</label></div>
                <div class="long time fl">{{trans('www.booking.departure_time')}}</div>
                <div class="cb"></div>
            </div>
            <div class="row">
                <div class="left fl"><label>{{trans('www.booking.additional_requests')}}</label></div>
                <div class="long fl">
                    <div class="form-box">
                        <textarea name="text"></textarea>
                        <div id="form-error-text" class="form-error"></div>
                    </div>
                </div>
                <div class="cb"></div>
            </div>
            {{csrf_field()}}
            <div class="submit-btn tc">
                <input type="submit" class="btn" value="{{trans('www.booking.continue_btn')}}" />
            </div>
        </form>
    </div>

</div>
<script type="text/javascript">
    $('html, body').animate({scrollTop: 600}, 500);
</script>
@stop