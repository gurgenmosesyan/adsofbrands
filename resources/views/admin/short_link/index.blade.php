<?php
$head->appendScript('/admin/short_link/short_link.js');
$pageTitle = $pageSubTitle = trans('admin.short_link.form.title');
$pageMenu = 'short_link';
?>
@extends('core.layout')
@section('navButtons')
    <a href="{{route('admin_short_link_create')}}" class="btn btn-primary pull-right">{{trans('admin.base.label.add')}}</a>
@stop
@section('content')
<div class="box-body">
    <table id="data-table" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>{{trans('admin.base.label.id')}}</th>
            <th>{{trans('admin.base.label.short_link')}}</th>
            <th>{{trans('admin.base.label.link')}}</th>
            @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->isSuperAdmin())
                <th>{{trans('admin.base.label.created_by')}}</th>
                <th>{{trans('admin.base.label.updated_by')}}</th>
            @endif
            <th class="th-actions"></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@stop