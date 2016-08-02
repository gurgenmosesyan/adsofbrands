<?php
$head->appendScript('/core/js/admin.js');
$pageTitle = trans('admin.admin.form.title');
$pageMenu = 'admin';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.admin.form.add.sub_title');
    $url = route('core_admin_store');
} else {
    $pageSubTitle = trans('admin.admin.form.edit.sub_title', ['id' => $admin->id]);
    $url = route('core_admin_update', $admin->id);
}
?>
@extends('core.layout')
@section('content')
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">
        <div class="form-group">
            <label for="email" class="col-sm-3 control-label data-req">{{trans('admin.base.label.email')}}</label>
            <div class="col-sm-9">
                <input type="text" name="email" class="form-control" id="username" value="{{$admin->email or ''}}">
                <div id="form-error-email" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-3 control-label data-req">{{trans('admin.base.label.password')}}</label>
            <div class="col-sm-9">
                <input type="password" name="password" class="form-control" id="password">
                <div id="form-error-password" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="re_password" class="col-sm-3 control-label data-req">{{trans('admin.base.label.re_password')}}</label>
            <div class="col-sm-9">
                <input type="password" name="re_password" class="form-control" id="re_password">
                <div id="form-error-re_password" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="re_password" class="col-sm-3 control-label data-req">{{trans('admin.base.label.language')}}</label>
            <div class="col-sm-9">
                <select name="lng_id" class="form-control">
                    @foreach($languages as $lng)
                        <option value="{{$lng->id}}"{{$lng->id == $admin->lng_id ? ' selected="selected"' : ''}}>{{$lng->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-lng_id" class="form-error"></div>
            </div>
        </div>
        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('core_admin_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop