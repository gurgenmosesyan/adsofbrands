<?php
use App\Models\Slider\Slider;

$head->appendScript('/admin/slider/slider.js');

if ($key == Slider::KEY_OFFERS) {
    $key = 'offer';
} else if ($key == Slider::KEY_FACILITIES) {
    $key = 'facility';
} else {
    $key = 'event';
}
$pageTitle = $pageSubTitle = trans('admin.'.$key.'_slider.form.title');
$pageMenu = $key.'_slider';
?>
@extends('core.layout')
@section('navButtons')
    <a href="{{route('admin_'.$key.'_slider_create')}}" class="btn btn-primary pull-right">{{trans('admin.base.label.add')}}</a>
@stop
@section('content')
<script type="text/javascript">
    $slider.listPath = '/admpanel/{{$key}}/slider';
</script>
<div class="box-body">
    <table id="data-table" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>{{trans('admin.base.label.id')}}</th>
            <th>{{trans('admin.base.label.facility')}}</th>
            <th>{{trans('admin.base.label.sort_order')}}</th>
            <th class="th-actions"></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@stop