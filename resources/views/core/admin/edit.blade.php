<?php
use App\Core\Admin\Admin;

$head->appendScript('/core/js/admin.js');
$pageTitle = trans('admin.admin.form.title');
$pageMenu = 'admin';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.admin.form.add.sub_title');
    $url = route('core_admin_store');
    $adminPermissions = [];
} else {
    $pageSubTitle = trans('admin.admin.form.edit.sub_title', ['id' => $admin->id]);
    $url = route('core_admin_update', $admin->id);
    $adminPermissions = $admin->permissions;
}
$permissions = require resource_path('permissions/app.php');
$corePermissions = require resource_path('permissions/core.php');
$permissions = array_merge($permissions, $corePermissions);
?>
@extends('core.layout')
@section('content')
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.email')}}</label>
            <div class="col-sm-9">
                <input type="text" name="email" class="form-control" value="{{$admin->email or ''}}">
                <div id="form-error-email" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.password')}}</label>
            <div class="col-sm-9">
                <input type="password" name="password" class="form-control">
                <div id="form-error-password" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.re_password')}}</label>
            <div class="col-sm-9">
                <input type="password" name="re_password" class="form-control">
                <div id="form-error-re_password" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.language')}}</label>
            <div class="col-sm-9">
                <select name="lng_id" class="form-control">
                    @foreach($languages as $lng)
                        <option value="{{$lng->id}}"{{$lng->id == $admin->lng_id ? ' selected="selected"' : ''}}>{{$lng->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-lng_id" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.homepage')}}</label>
            <div class="col-sm-9">
                <input type="text" name="homepage" class="form-control" value="{{$admin->homepage or ''}}">
                <div id="form-error-homepage" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.super_admin')}}</label>
            <div class="col-sm-9" style="padding-top: 2px;">
                <input type="checkbox" id="super-admin" class="minimal-checkbox" name="super_admin" value="{{Admin::SUPER_ADMIN}}"{!! $admin->isSuperAdmin() ? ' checked="checked"' : '' !!}>
                <div id="form-error-super_admin" class="form-error"></div>
            </div>
        </div>
        <div id="permissions" class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.permissions')}}</label>
            <div class="col-sm-9 row">
                @foreach($permissions as $permission)
                    <div class="col-md-4 col-sm-6">
                        <label>
                            <input type="checkbox" class="minimal-checkbox" name="permissions[{{$permission}}]" value="1"{{isset($adminPermissions[$permission]) ? ' checked="checked"' : ''}}>
                            <span style="display:inline-block; padding: 3px 0 0 3px;">
                                {{trans('admin.'.$permission.'.form.title')}}
                            </span>
                        </label>
                    </div>
                @endforeach
                <div id="form-error-permissions" class="form-error"></div>
            </div>
        </div>
        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('core_admin_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
<style>
    #permissions .icheckbox_minimal-blue {
        vertical-align: top;
    }
</style>
@stop