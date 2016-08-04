<?php
$head->appendScript('/admin/agency/agency.js');
$pageTitle = $pageSubTitle = trans('admin.agency.form.title');
$pageMenu = 'agency';
?>
@extends('core.layout')
@section('navButtons')
    <a href="{{route('admin_agency_create')}}" class="btn btn-primary pull-right">{{trans('admin.base.label.add')}}</a>
@stop
@section('content')
<div class="box-body">
    <table id="data-table" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>{{trans('admin.base.label.id')}}</th>
            <th>{{trans('admin.base.label.title')}}</th>
            <th class="th-actions"></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@stop