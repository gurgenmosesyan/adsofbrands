<?php
use App\Image\Image;

$head->appendStyle('/css/jquery.fancybox.css');
$head->appendScript('/js/jquery.fancybox.pack.js');

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
        @for($i = 2; $i < 6; $i++)
            <div class="step-box fl tc{{$i == 2 ? ' active' : ''}}">
                <span class="step-item db">
                    <span class="db fl left">{{$i}}</span>
                    <span class="db right"><span>{{trans('www.booking.step.'.$i)}}</span></span>
                    <span class="fl"></span>
                </span>
            </div>
        @endfor
        <div class="cb"></div>
    </div>

    <div id="booking-2">

        @if($accommodations->isEmpty())
            <p class="empty tc">{{trans('www.booking.empty_rooms')}}</p>
        @else
            <form action="{{url_with_lng('/booking/info', false)}}" method="post">
                <table>
                    <thead>
                        <tr>
                            <th>{{trans('www.booking.room_type')}}</th>
                            <th class="price">{{trans('www.booking.room_price', ['interval' => $interval])}}</th>
                            <th class="quantity">{{trans('www.booking.room_quantity')}}</th>
                            <th class="rate">{{trans('www.booking.rate_amd')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($accommodations as $acc) {
                            if ($acc->room_quantity <= 0) { continue; }
                        ?>
                            <tr>
                                <td>
                                    <p class="acc-title">{{$acc->title}}</p>
                                    <a href="#" class="details dib" data-id="{{$acc->id}}">{{trans('www.booking.details')}}</a>
                                </td>
                                <td class="price tc" data-price="{{$acc->price}}">
                                    {{number_format($acc->price, 0, '.', '.')}}
                                </td>
                                <td class="quantity tc">
                                    <div class="select-box dib">
                                        <div class="select-arrow"></div>
                                        <div class="select-title"></div>
                                        <select name="accommodations[{{$acc->id}}][quantity]" class="main-select" data-id="{{$acc->id}}">
                                            <option value="">{{trans('www.base.label.select')}}</option>
                                            @for($i = 1; $i <= $acc->room_quantity; $i++)
                                                <option value="{{$i}}">{{trans('www.booking.room'.($i != 1 ? 's' : '').'_quantity.number', ['number' => $i])}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </td>
                                <td class="rate tc" data-rate="0">
                                    <img src="{{url('/images/booking-rate.png')}}" />
                                </td>
                            </tr>
                            @foreach($acc->details as $detail)
                                <tr class="details-box details-{{$acc->id}} detail-{{$acc->id}} dpn detail-dn">
                                    <td>{{$detail->title}}</td>
                                    <td class="quantity tc" data-price="{{$detail->price}}">{{number_format($detail->price, 0, '.', '.')}}</td>
                                    <td class="price tc">
                                        <div class="select-box dib">
                                            <div class="select-arrow"></div>
                                            <div class="select-title"></div>
                                            <select name="accommodations[{{$acc->id}}][details][{{$detail->index}}]">
                                                <option value="">{{trans('www.base.label.select')}}</option>
                                                <option value="1">1</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="rate tc" data-rate="0">
                                        <img src="{{url('/images/booking-rate.png')}}" />
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="details-box details-{{$acc->id}} dpn">
                                <td colspan="4">
                                    @foreach($acc->images as $image)
                                        <div class="img-box dib">
                                            <a href="{{$image->getImage()}}" rel="group-{{$acc->id}}">
                                                <img src="{{url(Image::show($image->image, 'accommodation.booking'))}}" />
                                            </a>
                                        </div>
                                    @endforeach
                                    <div class="text-box">
                                        <div class="text">{!!$acc->text!!}</div>
                                        @if(!$acc->facilities->isEmpty())
                                            <div class="facilities">
                                                @foreach($acc->facilities as $facility)
                                                    <p>{{$facility->title}}</p>
                                                @endforeach
                                            </div>
                                        @endif
                                        <p><span class="fb">{{trans('www.accommodation.room_size')}}</span> {{$acc->room_size}} {{trans('www.accommodation.room_size.measurement')}}</p>
                                        <p><span class="fb">{{trans('www.accommodation.bed_type')}}</span> {{$acc->bed_type}}</p>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                {{csrf_field()}}
                <div class="total-box">
                    <div class="total-text fl">{{trans('www.booking.total')}}</div>
                    <div class="total-price fr tu"><span id="total" data-price="0">0</span> {{trans('www.booking.total.amd')}}</div>
                    <div class="cb"></div>
                </div>
                <div class="tr"><input type="submit" class="btn" value="{{trans('www.booking.continue_btn')}}" /></div>
            </form>
        @endif

    </div>

</div>
<script type="text/javascript">
    $main.initFancybox();
    $('html, body').animate({scrollTop: 600}, 500);
</script>
@stop