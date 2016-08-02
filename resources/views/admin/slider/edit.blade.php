<?php
use App\Models\Slider\Slider;

if ($key == Slider::KEY_OFFERS) {
    $key = 'offer';
} else if ($key == Slider::KEY_FACILITIES) {
    $key = 'facility';
} else {
    $key = 'event';
}

$head->appendScript('/admin/slider/slider.js');
$pageTitle = trans('admin.'.$key.'_slider.form.title');
$pageMenu = $key.'_slider';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.'.$key.'_slider.form.add.sub_title');
    $url = route('admin_'.$key.'_slider_store');
} else {
    $pageSubTitle = trans('admin.'.$key.'_slider.form.edit.sub_title', ['id' => $slider->id]);
    $url = route('admin_'.$key.'_slider_update', $slider->id);
}
?>
@extends('core.layout')
@section('content')
<script type="text/javascript">
    $slider.listPath = '/admpanel/{{$key}}/slider';
</script>
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.facility')}}</label>
            <div class="col-sm-9">
                <select name="facility_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($facilities as $facility)
                        <option value="{{$facility->id}}"{{$slider->facility_id == $facility->id ? ' selected="selected"' : ''}}>{{$facility->title}}</option>
                    @endforeach
                </select>
                <div id="form-error-facility_id" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.sort_order')}}</label>
            <div class="col-sm-3">
                <input type="text" name="sort_order" class="form-control" value="{{$slider->sort_order or ''}}">
                <div id="form-error-sort_order" class="form-error"></div>
            </div>
        </div>

        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_'.$key.'_slider_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop