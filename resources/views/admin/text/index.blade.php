<?php
$head->appendScript('/admin/text/text.js');
$pageTitle = $pageSubTitle = trans('admin.text.form.title');
$pageMenu = 'text';
?>
@extends('core.layout')
@section('content')
<div class="box-body">
    <table id="data-table" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>{{trans('admin.base.label.id')}}</th>
            <th>{{trans('admin.base.label.key')}}</th>
            <th class="th-actions"></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@stop