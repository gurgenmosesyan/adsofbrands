<?php
use App\Models\ShortLink\ShortLink;

$head->appendScript('/admin/short_link/short_link.js');
$pageTitle = trans('admin.short_link.form.title');
$pageMenu = 'short_link';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.short_link.form.add.sub_title');
    $url = route('admin_short_link_store');
} else {
    $pageSubTitle = trans('admin.short_link.form.edit.sub_title', ['id' => $shortLink->id]);
    $url = route('admin_short_link_update', $shortLink->id);
}

?>
@extends('core.layout')
@section('content')
    <form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
        <div class="box-body">

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.short_link')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="short_link" class="form-control" value="{{$shortLink->short_link or ''}}">
                    <div id="form-error-short_link" class="form-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.link')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="link" class="form-control" value="{{$shortLink->link or ''}}">
                    <div id="form-error-link" class="form-error"></div>
                </div>
            </div>

            {!! csrf_field() !!}
        </div>
        <div class="box-footer">
            <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
            <a href="{{route('admin_short_link_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
        </div>
    </form>
@stop