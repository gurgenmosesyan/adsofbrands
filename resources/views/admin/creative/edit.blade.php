<?php
use App\Models\Creative\Creative;
use App\Core\Helpers\ImgUploader;

$head->appendScript('/assets/plugins/ckeditor/ckeditor.js');
$head->appendScript('/assets/plugins/ckfinder/ckfinder.js');
$head->appendScript('/admin/creative/creative.js');

$pageTitle = trans('admin.creative.form.title');
$pageMenu = 'creative';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.creative.form.add.sub_title');
    $url = route('admin_creative_store');
} else {
    $pageSubTitle = trans('admin.creative.form.edit.sub_title', ['id' => $creative->id]);
    $url = route('admin_creative_update', $creative->id);
}
$mls = $creative->ml->keyBy('lng_id');

$jsTrans->addTrans([
    'admin.base.label.brand',
    'admin.base.label.agency'
]);
?>
@extends('core.layout')
@section('content')
<script type="text/javascript">
    $creative.saveMode = '<?php echo $saveMode; ?>';
</script>
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">

        @if(Auth::guard('admin')->check())
            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.type')}}</label>
                <div class="col-sm-9">
                    <select id="type" name="type" class="form-control">
                        <option value="{{Creative::TYPE_PERSONAL}}"{{$creative->type == Creative::TYPE_PERSONAL ? ' selected="selected"' : ''}}>{{trans('admin.base.label.personal')}}</option>
                        <option value="{{Creative::TYPE_BRAND}}"{{$creative->type == Creative::TYPE_BRAND ? ' selected="selected"' : ''}}>{{trans('admin.base.label.brand')}}</option>
                        <option value="{{Creative::TYPE_AGENCY}}"{{$creative->type == Creative::TYPE_AGENCY ? ' selected="selected"' : ''}}>{{trans('admin.base.label.agency')}}</option>
                    </select>
                    <div id="form-error-type" class="form-error"></div>
                </div>
            </div>

            <div id="type-id" class="form-group dn">
                <label class="col-sm-3 control-label data-req"></label>
                <div class="col-sm-9">
                    <input type="text" name="type_id" id="type-search" class="form-control" data-value="{{$creative->type_id or ''}}" value="{{$typeName}}">
                    <div id="form-error-type_id" class="form-error"></div>
                </div>
            </div>
        @endif

        @foreach($languages as $lng)
            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.name').' ('.$lng->code.')'}}</label>
                <div class="col-sm-9">
                    <input type="text" name="ml[{{$lng->id}}][title]" class="title form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->title : ''}}">
                    <div id="form-error-ml_{{$lng->id}}_title" class="form-error"></div>
                </div>
            </div>
        @endforeach

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.alias')}}</label>
            <div class="col-sm-9">
                <input type="text" name="alias" class="alias form-control" value="{{$creative->alias or ''}}">
                <div id="form-error-alias" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.image')}}</label>
            <div class="col-sm-9">
                <?php ImgUploader::uploader('creative', 'image', 'image', $creative->image); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.cover')}}</label>
            <div class="col-sm-9">
                <?php ImgUploader::uploader('creative', 'cover', 'cover', $creative->cover); ?>
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
        @endforeach

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.email')}}</label>
            <div class="col-sm-9">
                <input type="text" name="email" class="form-control" value="{{$creative->email or ''}}">
                <div id="form-error-email" class="form-error"></div>
            </div>
        </div>

        @if(Auth::guard('creative')->check())
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
                <input type="text" name="phone" class="form-control" value="{{$creative->phone or ''}}">
                <div id="form-error-phone" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.link')}}</label>
            <div class="col-sm-9">
                <input type="text" name="link" class="form-control" value="{{$creative->link or ''}}">
                <div id="form-error-link" class="form-error"></div>
            </div>
        </div>

        <h4 class="col-sm-offset-3 col-sm-9">{{trans('admin.base.label.social_pages')}}</h4>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.fb')}}</label>
            <div class="col-sm-9">
                <input type="text" name="fb" class="form-control" value="{{$creative->fb or ''}}">
                <div id="form-error-fb" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.twitter')}}</label>
            <div class="col-sm-9">
                <input type="text" name="twitter" class="form-control" value="{{$creative->twitter or ''}}">
                <div id="form-error-twitter" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.google_plus')}}</label>
            <div class="col-sm-9">
                <input type="text" name="google" class="form-control" value="{{$creative->google or ''}}">
                <div id="form-error-google" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.youtube')}}</label>
            <div class="col-sm-9">
                <input type="text" name="youtube" class="form-control" value="{{$creative->youtube or ''}}">
                <div id="form-error-youtube" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.linkedin')}}</label>
            <div class="col-sm-9">
                <input type="text" name="linkedin" class="form-control" value="{{$creative->linkedin or ''}}">
                <div id="form-error-linkedin" class="form-error"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.vimeo')}}</label>
            <div class="col-sm-9">
                <input type="text" name="vimeo" class="form-control" value="{{$creative->vimeo or ''}}">
                <div id="form-error-vimeo" class="form-error"></div>
            </div>
        </div>

        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_creative_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop