<?php
$head->appendScript('/admin/guest/guest.js');
$pageTitle = $pageSubTitle = trans('admin.guest.form.title');
$pageMenu = 'guest';
?>
@extends('core.layout')
@section('navButtons')
    <a href="{{route('admin_guest_create')}}" class="btn btn-primary pull-right">{{trans('admin.base.label.add')}}</a>
@stop
@section('content')
<div class="box-body">
    <table id="data-table" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>{{trans('admin.base.label.id')}}</th>
            <th>{{trans('admin.base.label.name')}}</th>
            <th class="th-actions"></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@stop