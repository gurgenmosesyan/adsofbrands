<?php

use App\Core\Helpers\ImgUploader;

$head->appendScript('/assets/plugins/ckeditor/ckeditor.js');
$head->appendScript('/admin/homepage/homepage.js');
$pageTitle = $pageSubTitle = trans('admin.homepage.form.title');
$pageMenu = 'homepage';
?>
@extends('core.layout')
@section('content')
    <form id="edit-form" class="form-horizontal" method="post" action="{{route('admin_homepage_update')}}">
        <div class="box-body">

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.about_image')}}</label>
                <div class="col-sm-9">
                    <?php
                    $value = $homepage == null ? null : $homepage->about_image;
                    ImgUploader::uploader('homepage', 'about_image', 'about_image', $value);
                    ?>
                </div>
            </div>

            @foreach($languages as $lng)
                <div class="form-group">
                    <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.about_text')}} ({{$lng->code}})</label>
                    <div class="col-sm-9">
                        <textarea name="ml[{{$lng->id}}][about_text]" class="form-control ckeditor">{{isset($ml[$lng->id]) ? $ml[$lng->id]->about_text : ''}}</textarea>
                        <div id="form-error-ml_{{$lng->id}}_about_text" class="form-error"></div>
                    </div>
                </div>
            @endforeach

            <hr />

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.offers_image')}}</label>
                <div class="col-sm-9">
                    <?php
                    $value = $homepage == null ? null : $homepage->offers_image;
                    ImgUploader::uploader('homepage', 'offers_image', 'offers_image', $value);
                    ?>
                </div>
            </div>

            @foreach($languages as $lng)
                <div class="form-group">
                    <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.offers_text')}} ({{$lng->code}})</label>
                    <div class="col-sm-9">
                        <textarea name="ml[{{$lng->id}}][offers_text]" class="form-control ckeditor">{{isset($ml[$lng->id]) ? $ml[$lng->id]->offers_text : ''}}</textarea>
                        <div id="form-error-ml_{{$lng->id}}_offers_text" class="form-error"></div>
                    </div>
                </div>
            @endforeach

            {{csrf_field()}}
        </div>
        <div class="box-footer">
            <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        </div>
    </form>
@stop