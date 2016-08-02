<?php
use App\Core\Helpers\Calendar;

$head->appendScript('/admin/reserved/reserved.js');
$pageTitle = trans('admin.reserved.form.title');
$pageMenu = 'reserved';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.reserved.form.add.sub_title');
    $url = route('admin_reserved_store');
} else {
    $pageSubTitle = trans('admin.reserved.form.edit.sub_title', ['id' => $reserved->id]);
    $url = route('admin_reserved_update', $reserved->id);
}
?>
@extends('core.layout')
@section('content')
    <form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
        <div class="box-body">

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.accommodation')}}</label>
                <div class="col-sm-4">
                    <select name="accommodation_id" class="form-control">
                        <option value="">{{trans('admin.base.label.select')}}</option>
                        @foreach($accommodations as $acc)
                            <option value="{{$acc->id}}"{{$reserved->accommodation_id == $acc->id ? ' selected="selected"' : ''}}>{{$acc->title}}</option>
                        @endforeach
                    </select>
                    <div id="form-error-accommodation_id" class="form-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.room_quantity')}}</label>
                <div class="col-sm-4">
                    <input type="text" name="room_quantity" class="form-control" value="{{$reserved->room_quantity or ''}}">
                    <div id="form-error-room_quantity" class="form-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.date_from')}}</label>
                <div class="col-sm-4">
                    <?php Calendar::render('date_from', $reserved->date_from); ?>
                    <div id="form-error-date_from" class="form-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.date_to')}}</label>
                <div class="col-sm-4">
                    <?php Calendar::render('date_to', $reserved->date_to); ?>
                    <div id="form-error-date_to" class="form-error"></div>
                </div>
            </div>

            {{csrf_field()}}
        </div>
        <div class="box-footer">
            <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
            <a href="{{route('admin_reserved_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
        </div>
    </form>
@stop