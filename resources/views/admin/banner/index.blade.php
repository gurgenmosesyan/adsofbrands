<?php
$head->appendScript('/admin/banner/banner.js');
$pageTitle = $pageSubTitle = trans('admin.banner.form.title');
$pageMenu = 'banner';
?>
@extends('core.layout')
@section('content')
<div class="box-body">
    <table id="data-table" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>{{trans('admin.base.label.key')}}</th>
            <th>{{trans('admin.base.label.type')}}</th>
            <th class="th-actions"></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<style>
    #data-table_filter,
    #data-table_length {
        display: none;
    }
</style>
@stop