<?php

$head->appendScript('/admin/agency_category/category.js');
$pageTitle = trans('admin.category.form.title');
$pageMenu = 'agency_category';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.category.form.add.sub_title');
    $url = route('admin_agency_category_store');
} else {
    $pageSubTitle = trans('admin.category.form.edit.sub_title', ['id' => $category->id]);
    $url = route('admin_agency_category_update', $category->id);
}
$mls = $category->ml->keyBy('lng_id');
?>
@extends('core.layout')
@section('content')
    <form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
        <div class="box-body">

            @foreach($languages as $lng)
                <div class="form-group">
                    <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.title').' ('.$lng->code.')'}}</label>
                    <div class="col-sm-9 separate-sections">
                        <input type="text" name="ml[{{$lng->id}}][title]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->title : ''}}">
                        <div id="form-error-ml_{{$lng->id}}_title" class="form-error"></div>
                    </div>
                </div>
            @endforeach

            {{csrf_field()}}
        </div>
        <div class="box-footer">
            <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
            <a href="{{route('admin_agency_category_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
        </div>
    </form>
@stop