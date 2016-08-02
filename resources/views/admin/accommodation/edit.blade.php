<?php
use App\Models\Accommodation\Accommodation;

$head->appendStyle('/admin/accommodation/accommodation.css');
$head->appendScript('/assets/plugins/ckeditor/ckeditor.js');
$head->appendScript('/admin/accommodation/accommodation.js');
$pageTitle = trans('admin.accommodation.form.title');
$pageMenu = 'accommodation';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.accommodation.form.add.sub_title');
    $url = route('admin_accommodation_store');
} else {
    $pageSubTitle = trans('admin.accommodation.form.edit.sub_title', ['id' => $accommodation->id]);
    $url = route('admin_accommodation_update', $accommodation->id);
}
$mls = $accommodation->ml->keyBy('lng_id');

$jsTrans->addTrans(['admin.base.label.price']);
?>
@extends('core.layout')
@section('content')
<script type="text/javascript">
    $accommodation.languages = <?php echo json_encode($languages); ?>;
    $accommodation.facilities = <?php echo json_encode($facilities); ?>;
    $accommodation.details = <?php echo json_encode($details); ?>;
    $accommodation.images = <?php echo json_encode($images); ?>;
    $accommodation.saveMode = '<?php echo $saveMode; ?>';
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
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.room_quantity')}}</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="room_quantity" value="{{$accommodation->room_quantity or ''}}">
                <div id="form-error-room_quantity" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.price')}}</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="price" value="{{$accommodation->price or ''}}">
                <div id="form-error-price" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.room_size')}}</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="room_size" value="{{$accommodation->room_size or ''}}">
                <div id="form-error-room_size" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.bed_type')}}</label>
            @foreach($languages as $lng)
                <div class="col-sm-3">
                    <div class="form-group form-group-inner">
                        <input type="text" name="ml[{{$lng->id}}][bed_type]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->bed_type : ''}}" placeholder="{{$lng->name}}">
                        <div id="form-error-ml_{{$lng->id}}_bed_type" class="form-error"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.facilities')}}</label>
            <div class="col-sm-9">
                <div id="facilities" class="separate-sections"></div>
                <div id="form-error-facilities" class="form-error"></div>
                <div>
                    <a href="#" id="add-facility" class="btn btn-default"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
        <br>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.details')}}</label>
            <div class="col-sm-9">
                <div id="details" class="separate-sections"></div>
                <div id="form-error-details" class="form-error"></div>
                <div>
                    <a href="#" id="add-detail" class="btn btn-default"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
        <br>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.sort_order')}}</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="sort_order" value="{{$accommodation->sort_order or ''}}">
                <div id="form-error-sort_order" class="form-error"></div>
            </div>
        </div>

        <div id="image-group" class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.images')}}</label>
            <div class="col-sm-9">
                <a href="#" id="upload-image" class="btn btn-default">{{trans('admin.base.label.upload')}}</a>
                <div id="form-error-images" class="form-error"></div>
                <div id="images-block"></div>
            </div>
        </div>

        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_accommodation_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop