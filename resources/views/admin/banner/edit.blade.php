<?php
use App\Models\Banner\Banner;
use App\Core\Helpers\ImgUploader;

$head->appendScript('/admin/banner/banner.js');

$pageTitle = trans('admin.banner.form.title');
$pageMenu = 'banner';
$pageSubTitle = trans('admin.banner.key.'.$banner->key);
?>
@extends('core.layout')
@section('content')
<form id="edit-form" class="form-horizontal" method="post" action="{{route('admin_banner_update', $banner->id)}}">
    <div class="box-body">

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.type')}}</label>
            <div class="col-sm-9">
                <select id="type" name="type" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    <option value="{{Banner::TYPE_IMAGE}}"{{$banner->type == Banner::TYPE_IMAGE ? ' selected="selected"' : ''}}>{{trans('admin.base.label.image')}}</option>
                    <option value="{{Banner::TYPE_EMBED}}"{{$banner->type == Banner::TYPE_EMBED ? ' selected="selected"' : ''}}>{{trans('admin.base.label.embed_code')}}</option>
                </select>
                <div id="form-error-type" class="form-error"></div>
            </div>
        </div>

        <div id="image" class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.image')}}</label>
            <div class="col-sm-9">
                <?php ImgUploader::uploader('banner', $banner->key, 'image', $banner->image); ?>
                    <div id="form-error-image" class="form-error"></div>
            </div>
        </div>

        <div id="embed" class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.embed_code')}}</label>
            <div class="col-sm-9">
                <textarea name="embed" class="form-control" rows="5">{{$banner->embed or ''}}</textarea>
                <div id="form-error-embed" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.link')}}</label>
            <div class="col-sm-9">
                <input type="text" name="link" class="form-control" value="{{$banner->link or ''}}">
                <div id="form-error-link" class="form-error"></div>
            </div>
        </div>

        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_banner_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop