<?php
use App\Core\Helpers\ImgUploader;

$head->appendScript('/admin/media_type/media_type.js');
$pageTitle = trans('admin.media_type.form.title');
$pageMenu = 'media_type';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.media_type.form.add.sub_title');
    $url = route('admin_media_type_store');
} else {
    $pageSubTitle = trans('admin.media_type.form.edit.sub_title', ['id' => $mediaType->id]);
    $url = route('admin_media_type_update', $mediaType->id);
}
$mls = $mediaType->ml->keyBy('lng_id');
?>
@extends('core.layout')
@section('content')
    <form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
        <div class="box-body">

            @foreach($languages as $lng)
                <div class="form-group">
                    <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.title').' ('.$lng->code.')'}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="ml[{{$lng->id}}][title]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->title : ''}}">
                        <div id="form-error-ml_{{$lng->id}}_title" class="form-error"></div>
                    </div>
                </div>
            @endforeach

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.icon')}}</label>
                <div class="col-sm-9">
                    <?php ImgUploader::uploader('media_type', 'icon', 'icon', $mediaType->icon); ?>
                </div>
            </div>

            {{csrf_field()}}
        </div>
        <div class="box-footer">
            <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
            <a href="{{route('admin_media_type_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
        </div>
    </form>
@stop