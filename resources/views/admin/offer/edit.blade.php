<?php

$head->appendScript('/assets/plugins/ckeditor/ckeditor.js');
$head->appendScript('/admin/offer/offer.js');
$pageTitle = trans('admin.offer.form.title');
$pageMenu = 'offer';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.offer.form.add.sub_title');
    $url = route('admin_offer_store');
} else {
    $pageSubTitle = trans('admin.offer.form.edit.sub_title', ['id' => $offer->id]);
    $url = route('admin_offer_update', $offer->id);
}
$mls = $offer->ml->keyBy('lng_id');
?>
@extends('core.layout')
@section('content')
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.title')}}</label>
                @foreach($languages as $lng)
                    <div class="col-sm-3">
                        <div class="form-group form-group-inner">
                            <input type="text" name="ml[{{$lng->id}}][title]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->title : ''}}" placeholder="{{$lng->name}}">
                            <div id="form-error-ml_{{$lng->id}}_title" class="form-error"></div>
                        </div>
                    </div>
                @endforeach
        </div>

        @foreach($languages as $lng)
            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.text')}} ({{$lng->code}})</label>
                <div class="col-sm-9">
                    <textarea name="ml[{{$lng->id}}][text]" class="form-control ckeditor">{{isset($mls[$lng->id]) ? $mls[$lng->id]->text : ''}}</textarea>
                    <div id="form-error-ml_{{$lng->id}}_text" class="form-error"></div>
                </div>
            </div>
        @endforeach

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.sort_order')}}</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="sort_order" value="{{$offer->sort_order or ''}}">
                <div id="form-error-sort_order" class="form-error"></div>
            </div>
        </div>

        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_offer_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop