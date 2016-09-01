<?php
use App\Models\Brand\Brand;
use App\Core\Helpers\ImgUploader;

$head->appendScript('/assets/plugins/ckeditor/ckeditor.js');
$head->appendScript('/admin/brand/brand.js');

$pageTitle = trans('admin.brand.form.title');
$pageMenu = 'brand';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.brand.form.add.sub_title');
    $url = route('admin_brand_store');
} else {
    $pageSubTitle = trans('admin.brand.form.edit.sub_title', ['id' => $brand->id]);
    $url = route('admin_brand_update', $brand->id);
}
$mls = $brand->ml->keyBy('lng_id');
?>
@extends('core.layout')
@section('content')
    <form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
        <div class="box-body">

            @foreach($languages as $lng)
                <div class="form-group">
                    <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.title').' ('.$lng->code.')'}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="ml[{{$lng->id}}][title]" class="title form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->title : ''}}">
                        <div id="form-error-ml_{{$lng->id}}_title" class="form-error"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.sub_title').' ('.$lng->code.')'}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="ml[{{$lng->id}}][sub_title]" class="title form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->sub_title : ''}}">
                        <div id="form-error-ml_{{$lng->id}}_sub_title" class="form-error"></div>
                    </div>
                </div>
            @endforeach

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.alias')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="alias" class="alias form-control" value="{{$brand->alias or ''}}">
                    <div id="form-error-alias" class="form-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.country')}}</label>
                <div class="col-sm-9">
                    <select name="country_id" class="form-control">
                        <option value="">{{trans('admin.base.label.global')}}</option>
                        @foreach($countries as $country)
                            <option value="{{$country->id}}"{{$country->id == $brand->country_id ? ' selected="selected"' : ''}}>{{$country->name}}</option>
                        @endforeach
                    </select>
                    <div id="form-error-country_id" class="form-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.category')}}</label>
                <div class="col-sm-9">
                    <select name="category_id" class="form-control">
                        <option value="">{{trans('admin.base.label.select')}}</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}"{{$category->id == $brand->category_id ? ' selected="selected"' : ''}}>{{$category->title}}</option>
                        @endforeach
                    </select>
                    <div id="form-error-category_id" class="form-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.image')}}</label>
                <div class="col-sm-9">
                    <?php ImgUploader::uploader('brand', 'image', 'image', $brand->image); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.cover')}}</label>
                <div class="col-sm-9">
                    <?php ImgUploader::uploader('brand', 'cover', 'cover', $brand->cover); ?>
                </div>
            </div>

            @foreach($languages as $lng)
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{trans('admin.base.label.about').' ('.$lng->code.')'}}</label>
                    <div class="col-sm-9">
                        <textarea name="ml[{{$lng->id}}][about]" class="ckeditor">{{isset($mls[$lng->id]) ? $mls[$lng->id]->about : ''}}</textarea>
                        <div id="form-error-ml_{{$lng->id}}_about" class="form-error"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">{{trans('admin.base.label.address').' ('.$lng->code.')'}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="ml[{{$lng->id}}][address]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->address : ''}}">
                        <div id="form-error-ml_{{$lng->id}}_address" class="form-error"></div>
                    </div>
                </div>
            @endforeach

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.email')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="email" class="form-control" value="{{$brand->email or ''}}">
                    <div id="form-error-email" class="form-error"></div>
                </div>
            </div>

            @if(Auth::guard('brand')->check())
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{trans('admin.base.label.password')}}</label>
                    <div class="col-sm-9">
                        <input type="password" name="password" class="form-control" value="">
                        <div id="form-error-password" class="form-error"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{trans('admin.base.label.re_password')}}</label>
                    <div class="col-sm-9">
                        <input type="password" name="re_password" class="form-control" value="">
                        <div id="form-error-re_password" class="form-error"></div>
                    </div>
                </div>
            @endif

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.phone')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="phone" class="form-control" value="{{$brand->phone or ''}}">
                    <div id="form-error-phone" class="form-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.link')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="link" class="form-control" value="{{$brand->link or ''}}">
                    <div id="form-error-link" class="form-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.top')}}</label>
                <div class="col-sm-9">
                    <input type="checkbox" name="top" class="minimal-checkbox" value="{{Brand::TOP}}"{{$brand->isTop() ? ' checked="checked"' : ''}}>
                    <div id="form-error-top" class="form-error"></div>
                </div>
            </div>

            <h4 class="col-sm-offset-3 col-sm-9">{{trans('admin.base.label.social_pages')}}</h4>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.fb')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="fb" class="form-control" value="{{$brand->fb or ''}}">
                    <div id="form-error-fb" class="form-error"></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.twitter')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="twitter" class="form-control" value="{{$brand->twitter or ''}}">
                    <div id="form-error-twitter" class="form-error"></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.google_plus')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="google" class="form-control" value="{{$brand->google or ''}}">
                    <div id="form-error-google" class="form-error"></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.youtube')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="youtube" class="form-control" value="{{$brand->youtube or ''}}">
                    <div id="form-error-youtube" class="form-error"></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.linkedin')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="linkedin" class="form-control" value="{{$brand->linkedin or ''}}">
                    <div id="form-error-linkedin" class="form-error"></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.vimeo')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="vimeo" class="form-control" value="{{$brand->vimeo or ''}}">
                    <div id="form-error-vimeo" class="form-error"></div>
                </div>
            </div>

            {{csrf_field()}}
        </div>
        <div class="box-footer">
            <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
            <a href="{{route('admin_brand_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
        </div>
    </form>
@stop