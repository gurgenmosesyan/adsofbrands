<?php
use App\Image\Image;

$title = trans('www.homepage.title');
$isHomepage = true;
$page = null;
?>
@extends('layout')

@section('content')

<div id="homepage-about" class="homepage-section">
    <div class="page">
        <div class="img-section fl">
            <img src="{{$homepage->getAboutImage()}}" alt="about-us" />
        </div>
        <div class="text-section fr">
            <h2 class="title">{{trans('www.menu.about')}}</h2>
            <div class="html-content">{!!$homepageMl->about_text!!}</div>
            <div class="btn-section tc">
                <a href="{{url_with_lng('/about')}}" class="btn">{{trans('www.btn.read_more')}}</a>
            </div>
        </div>
        <div class="cb"></div>
    </div>
</div>

@if(!$accommodations->isEmpty())
    <div id="homepage-accommodation">
        <div class="page">
            <h2 class="title">{{trans('www.menu.accommodation')}}</h2>

            <div id="home-acc-block">
                <div id="home-acc" class="owl-carousel tc">
                    @foreach($accommodations as $accommodation)
                        <div class="acc-item dib" style="background-image: url('{{url(Image::show($accommodation->images[0]->image, 'accommodation.thumb'))}}');">
                            <a href="{{url_with_lng('/accommodations/'.$accommodation->id, false)}}" class="db">
                                <span class="acc-title dib">{{$accommodation->title}}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endif

<div id="homepage-offers" class="homepage-section">
    <div class="page">
        <div class="text-section fl">
            <h2 class="title">{{trans('www.menu.special_offers')}}</h2>
            <div class="html-content">{!!$homepageMl->offers_text!!}</div>
            <div class="btn-section tc">
                <a href="{{url_with_lng('/special-offers')}}" class="btn">{{trans('www.btn.read_more')}}</a>
            </div>
        </div>
        <div class="img-section fr">
            <img src="{{$homepage->getOffersImage()}}" alt="special-offers" />
        </div>
        <div class="cb"></div>
    </div>
</div>

<div id="contact">
    <div class="page">
        <div id="map" class="fl">

        </div>
        <div id="contact-form-block" class="fr">
            <h2 class="title">Contact us</h2>
            <form id="contact-form" action="{{url_with_lng('/api/contact', false)}}" method="post">
                <div class="form-box name-box fl">
                    <input type="text" name="name" class="name-input" value="" placeholder="Name" />
                    <div id="form-error-name" class="form-error"></div>
                </div>
                <div class="form-box email-box fl">
                    <input type="text" name="email" value="" placeholder="Email" />
                    <div id="form-error-email" class="form-error"></div>
                </div>
                <div class="cb"></div>
                <div class="form-box message-box">
                    <textarea name="message" placeholder="Message"></textarea>
                    <div id="form-error-message" class="form-error"></div>
                </div>
                {{csrf_field()}}
                <div class="tc">
                    <input type="submit" class="btn" value="Send" />
                </div>
            </form>
        </div>
        <div class="cb"></div>
    </div>
</div>
<script type="text/javascript">
    $main.homepage = true;
    $main.includeGoogleMap();
    setTimeout(function() {
        $main.initMap();
    }, 1000);
    $main.initContactForm();
    $main.homeAccCarousel();
</script>

@stop