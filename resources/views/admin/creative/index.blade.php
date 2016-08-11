<?php
$head->appendScript('/admin/creative/creative.js');
$pageTitle = $pageSubTitle = trans('admin.creative.form.title');
$pageMenu = 'creative';
?>
@extends('core.layout')
@section('navButtons')
    <a href="{{route('admin_creative_create')}}" class="btn btn-primary pull-right">{{trans('admin.base.label.add')}}</a>
@stop
@section('content')
<div class="box-body">
    <table id="data-table" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>{{trans('admin.base.label.id')}}</th>
            <th>{{trans('admin.base.label.type')}}</th>
            <th>{{trans('admin.base.label.brand_agency')}}</th>
            <th>{{trans('admin.base.label.name')}}</th>
            <th class="th-actions"></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@stop