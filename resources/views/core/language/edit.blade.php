<?php
use App\Core\Language\Language;
use App\Core\Helpers\ImgUploader;

$head->appendScript('/core/js/language.js');
$pageTitle = trans('admin.language.form.title');
$pageMenu = 'language';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.language.form.add.sub_title');
    $url = route('core_language_store');
} else {
    $pageSubTitle = trans('admin.language.form.edit.sub_title', ['id' => $language->id]);
    $url = route('core_language_update', $language->id);
}
?>
@extends('core.layout')
@section('content')
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label data-req">{{trans('admin.base.label.name')}}</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" id="name" value="{{$language->name or ''}}">
                <div id="form-error-name" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="code" class="col-sm-2 control-label data-req">{{trans('admin.base.label.code')}}</label>
            <div class="col-sm-10">
                <input type="text" name="code" class="form-control" id="code" value="{{$language->code or ''}}">
                <div id="form-error-code" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">{{trans('admin.base.label.icon')}}</label>
            <div class="col-sm-10">
                <?php ImgUploader::uploader('language', 'icon', 'icon', $language->icon); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="default" class="col-sm-2 control-label">{{trans('admin.base.label.default')}}</label>
            <div class="col-sm-10">
                <input type="checkbox" id="default" name="default" class="minimal-checkbox" value="{{Language::DEFAULT_LNG}}" {{$language->default == Language::DEFAULT_LNG ? ' checked="checked"' : ''}}>
                <div id="form-error-default" class="form-error"></div>
            </div>
        </div>
        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('core_language_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop