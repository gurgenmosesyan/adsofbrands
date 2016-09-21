<?php

$meta->title(trans('www.contacts.head_title'));
$meta->description(trans('www.contacts.description'));
$meta->keywords(trans('www.homepage.keywords'));
$meta->ogTitle(trans('www.contacts.head_title'));
$meta->ogDescription(trans('www.contacts.description'));
$meta->ogImage(url('/imgs/og-logo.jpg'));
$meta->ogUrl(url_with_lng('/contacts'));

$fbSDK = true;
?>
@extends('layout')

@section('content')

<div class="page">

    <div id="main-inner">

        <div id="main-left" class="fl">

            <div id="contact-left" class="fl">
                <h1 class="fsb fs36">{{trans('www.contacts.title')}}</h1>
                <form id="contact-form" action="{{url_with_lng('/api/contacts')}}" method="post">
                    <div class="form-box">
                        <input type="text" name="name" placeholder="{{trans('www.base.label.full_name')}}" />
                        <div id="form-error-name" class="form-error"></div>
                    </div>
                    <div class="form-box">
                        <input type="text" name="email" placeholder="{{trans('www.base.label.email')}}" />
                        <div id="form-error-email" class="form-error"></div>
                    </div>
                    <div class="form-box">
                        <input type="text" name="phone" placeholder="{{trans('www.base.label.mobile_number')}}" />
                        <div id="form-error-phone" class="form-error"></div>
                    </div>
                    <div class="form-box">
                        <input type="text" name="subject" class="subject" placeholder="{{trans('www.base.label.subject')}}" />
                        <div id="form-error-subject" class="form-error"></div>
                    </div>
                    <div class="form-box">
                        <textarea name="message" class="message" placeholder="{{trans('www.base.label.message')}}"></textarea>
                        <div id="form-error-message" class="form-error"></div>
                    </div>
                    {{csrf_field()}}
                    <div class="form-box">
                        <input type="submit" class="fb fs22" value="{{trans('www.contacts.submit')}}" />
                    </div>
                </form>
            </div>
            <div id="contact-right" class="fl">
                <div id="map"></div>
            </div>
            <div class="cb"></div>

        </div>

        <div id="main-right" class="fr">
            @include('blocks.main_right')
        </div>
        <div class="cb"></div>

    </div>

</div>
<script type="text/javascript">
    $main.includeGoogleMap();
    $main.coordinates = <?php echo json_encode([['lat' => 40.186914, 'lng' => 44.514853]]); ?>;
    setTimeout(function() {
        $main.initMap(true);
    }, 1000);
    $main.initContactForm();
</script>

@stop