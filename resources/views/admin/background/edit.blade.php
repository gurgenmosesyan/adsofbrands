<?php

use App\Core\Helpers\ImgUploader;
        
$head->appendScript('/admin/background/background.js');
$pageTitle = $pageSubTitle = trans('admin.background.form.title');
$pageMenu = 'background';
?>
@extends('core.layout')
@section('content')
    <form id="edit-form" class="form-horizontal" method="post" action="{{route('admin_background_update')}}">
        <div class="box-body">

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.homepage')}}</label>
                <div class="col-sm-9">
                    <?php
                    $value = $background == null ? null : $background->homepage;
                    ImgUploader::uploader('background', 'homepage', 'homepage', $value);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.about')}}</label>
                <div class="col-sm-9">
                    <?php
                    $value = $background == null ? null : $background->about;
                    ImgUploader::uploader('background', 'about', 'about', $value);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.accommodations')}}</label>
                <div class="col-sm-9">
                    <?php
                    $value = $background == null ? null : $background->accommodation;
                    ImgUploader::uploader('background', 'accommodation', 'accommodation', $value);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.special_offers')}}</label>
                <div class="col-sm-9">
                    <?php
                    $value = $background == null ? null : $background->offer;
                    ImgUploader::uploader('background', 'offer', 'offer', $value);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.hotel_facilities')}}</label>
                <div class="col-sm-9">
                    <?php
                    $value = $background == null ? null : $background->facility;
                    ImgUploader::uploader('background', 'facility', 'facility', $value);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.meeting_events')}}</label>
                <div class="col-sm-9">
                    <?php
                    $value = $background == null ? null : $background->event;
                    ImgUploader::uploader('background', 'event', 'event', $value);
                    ?>
                </div>
            </div>

            {{csrf_field()}}
        </div>
        <div class="box-footer">
            <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        </div>
    </form>
@stop