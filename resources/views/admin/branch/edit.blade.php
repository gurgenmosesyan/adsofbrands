<?php
use App\Models\Branch\Branch;

$head->appendScript('/admin/branch/branch.js');

$pageTitle = trans('admin.branch.form.title');
$pageMenu = 'branch';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.branch.form.add.sub_title');
    $url = route('admin_branch_store');
} else {
    $pageSubTitle = trans('admin.branch.form.edit.sub_title', ['id' => $branch->id]);
    $url = route('admin_branch_update', $branch->id);
}
$mls = $branch->ml->keyBy('lng_id');

$jsTrans->addTrans([
    'admin.base.label.brand',
    'admin.base.label.agency'
]);
?>
@extends('core.layout')
@section('content')
    <form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
        <div class="box-body">

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.type')}}</label>
                <div class="col-sm-9">
                    <select id="type" name="type" class="form-control">
                        <option value="">{{trans('admin.base.label.select')}}</option>
                        <option value="{{Branch::TYPE_BRAND}}"{{$branch->type == Branch::TYPE_BRAND ? ' selected="selected"' : ''}}>{{trans('admin.base.label.brand')}}</option>
                        <option value="{{Branch::TYPE_AGENCY}}"{{$branch->type == Branch::TYPE_AGENCY ? ' selected="selected"' : ''}}>{{trans('admin.base.label.agency')}}</option>
                    </select>
                    <div id="form-error-type" class="form-error"></div>
                </div>
            </div>

            <div id="type-id" class="form-group dn">
                <label class="col-sm-3 control-label data-req"></label>
                <div class="col-sm-9">
                    <input type="text" name="type_id" class="form-control" value="">
                    <div id="form-error-type_id" class="form-error"></div>
                </div>
            </div>

            @foreach($languages as $lng)
                <div class="form-group">
                    <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.title').' ('.$lng->code.')'}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="ml[{{$lng->id}}][title]" class="title form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->title : ''}}">
                        <div id="form-error-ml_{{$lng->id}}_title" class="form-error"></div>
                    </div>
                </div>
            @endforeach

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.phone')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="phone" class="form-control" value="{{$branch->phone or ''}}">
                    <div id="form-error-phone" class="form-error"></div>
                </div>
            </div>

            @foreach($languages as $lng)
                <div class="form-group">
                    <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.address').' ('.$lng->code.')'}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="ml[{{$lng->id}}][address]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->address : ''}}">
                        <div id="form-error-ml_{{$lng->id}}_address" class="form-error"></div>
                    </div>
                </div>
            @endforeach

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.email')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="email" class="form-control" value="{{$branch->email or ''}}">
                    <div id="form-error-email" class="form-error"></div>
                </div>
            </div>

            {{csrf_field()}}
        </div>
        <div class="box-footer">
            <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
            <a href="{{route('admin_branch_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
        </div>
    </form>
@stop