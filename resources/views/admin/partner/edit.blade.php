<?php
use App\Core\Helpers\ImgUploader;

$head->appendScript('/admin/partner/partner.js');
$pageTitle = trans('admin.partner.form.title');
$pageMenu = 'partner';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.partner.form.add.sub_title');
    $url = route('admin_partner_store');
} else {
    $pageSubTitle = trans('admin.partner.form.edit.sub_title', ['id' => $partner->id]);
    $url = route('admin_partner_update', $partner->id);
}
?>
@extends('core.layout')
@section('content')
    <form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
        <div class="box-body">

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.image')}}</label>
                <div class="col-sm-9">
                    <?php ImgUploader::uploader('partner', 'image', 'image', $partner->image); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.link')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="link" class="form-control" value="{{$partner->link or ''}}">
                    <div id="form-error-link" class="form-error"></div>
                </div>
            </div>

            {{csrf_field()}}
        </div>
        <div class="box-footer">
            <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
            <a href="{{route('admin_partner_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
        </div>
    </form>
@stop