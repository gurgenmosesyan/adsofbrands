<?php

$head->appendStyle('/admin/facility/facility.css');
$head->appendScript('/assets/plugins/ckeditor/ckeditor.js');
$head->appendScript('/admin/facility/facility.js');
$pageTitle = trans('admin.facility.form.title');
$pageMenu = 'facility';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.facility.form.add.sub_title');
    $url = route('admin_facility_store');
} else {
    $pageSubTitle = trans('admin.facility.form.edit.sub_title', ['id' => $facility->id]);
    $url = route('admin_facility_update', $facility->id);
}
$mls = $facility->ml->keyBy('lng_id');
?>
@extends('core.layout')
@section('content')
    <script type="text/javascript">
        $facility.images = <?php echo json_encode($images); ?>;
        $facility.saveMode = '<?php echo $saveMode; ?>';
    </script>
    <form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
        <div class="box-body">

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.title')}}</label>
                @foreach($languages as $lng)
                    <div class="col-sm-3">
                        <div class="form-group form-group-inner">
                            <input type="text" name="ml[{{$lng->id}}][title]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->title : ''}}" placeholder="{{$lng->name}}">
                            <div id="form-error-ml_{{$lng->id}}_title" class="form-error"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            @foreach($languages as $lng)
                <div class="form-group">
                    <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.text')}} ({{$lng->code}})</label>
                    <div class="col-sm-9">
                        <textarea name="ml[{{$lng->id}}][text]" class="form-control ckeditor">{{isset($mls[$lng->id]) ? $mls[$lng->id]->text : ''}}</textarea>
                        <div id="form-error-ml_{{$lng->id}}_text" class="form-error"></div>
                    </div>
                </div>
            @endforeach

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.sort_order')}}</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="sort_order" value="{{$facility->sort_order or ''}}">
                    <div id="form-error-sort_order" class="form-error"></div>
                </div>
            </div>

            <br>

            <div id="image-group" class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.images')}}</label>
                <div class="col-sm-9">
                    <a href="#" id="upload-image" class="btn btn-default">{{trans('admin.base.label.upload')}}</a>
                    <span class="img-size-help-txt">{{trans('admin.img.size.help_text', ['width' => config('facility.images.image.width'), 'height' => config('facility.images.image.height')])}}</span>
                    <div id="form-error-images" class="form-error"></div>
                    <div id="images-block"></div>
                </div>
            </div>

            {{csrf_field()}}
        </div>
        <div class="box-footer">
            <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
            <a href="{{route('admin_facility_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
        </div>
    </form>
@stop