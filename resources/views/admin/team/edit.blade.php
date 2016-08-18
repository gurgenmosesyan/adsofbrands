<?php
use App\Core\Helpers\ImgUploader;

$head->appendScript('/admin/team/team.js');
$pageTitle = trans('admin.team.form.title');
$pageMenu = 'team';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.team.form.add.sub_title');
    $url = route('admin_team_store');
} else {
    $pageSubTitle = trans('admin.team.form.edit.sub_title', ['id' => $team->id]);
    $url = route('admin_team_update', $team->id);
}
$mls = $team->ml->keyBy('lng_id');
?>
@extends('core.layout')
@section('content')
    <form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
        <div class="box-body">

            @foreach($languages as $lng)
                <div class="form-group">
                    <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.first_name').' ('.$lng->code.')'}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="ml[{{$lng->id}}][first_name]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->first_name : ''}}">
                        <div id="form-error-ml_{{$lng->id}}_first_name" class="form-error"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.last_name').' ('.$lng->code.')'}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="ml[{{$lng->id}}][last_name]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->last_name : ''}}">
                        <div id="form-error-ml_{{$lng->id}}_last_name" class="form-error"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.position').' ('.$lng->code.')'}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="ml[{{$lng->id}}][position]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->position : ''}}">
                        <div id="form-error-ml_{{$lng->id}}_position" class="form-error"></div>
                    </div>
                </div>
            @endforeach

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.image')}}</label>
                <div class="col-sm-9">
                    <?php ImgUploader::uploader('team', 'image', 'image', $team->image); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.link')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="link" class="form-control" value="{{$team->link or ''}}">
                    <div id="form-error-link" class="form-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.sort_order')}}</label>
                <div class="col-sm-3">
                    <input type="text" name="sort_order" class="form-control" value="{{$team->sort_order or ''}}">
                    <div id="form-error-sort_order" class="form-error"></div>
                </div>
            </div>

            {{csrf_field()}}
        </div>
        <div class="box-footer">
            <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
            <a href="{{route('admin_team_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
        </div>
    </form>
@stop