<?php
use App\Models\Creative\Creative;
        
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

        @foreach($languages as $lng)
            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.name').' ('.$lng->code.')'}}</label>
                <div class="col-sm-9">
                    <input type="text" name="ml[{{$lng->id}}][title]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->title : ''}}">
                    <div id="form-error-ml_{{$lng->id}}_title" class="form-error"></div>
                </div>
            </div>
        @endforeach

        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_creative_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop