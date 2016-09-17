<?php
$head->appendScript('/admin/subscribe/subscribe.js');
$pageTitle = $pageSubTitle = trans('admin.subscribe.form.title');
$pageMenu = 'subscribe';
?>
@extends('core.layout')
@section('navButtons')
    <a href="{{route('admin_subscribe_export')}}" class="btn btn-primary pull-right">{{trans('admin.base.label.export')}}</a>
@stop
@section('content')
<div class="box-body">
    <table id="data-table" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>{{trans('admin.base.label.id')}}</th>
            <th>{{trans('admin.base.label.email')}}</th>
            <th class="th-actions"></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@stop