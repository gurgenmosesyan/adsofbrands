<?php
use App\Models\Award\Award;
        
$head->appendScript('/admin/award/award.js');

$pageTitle = trans('admin.award.form.title');
$pageMenu = 'award';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.award.form.add.sub_title');
    $url = route('admin_award_store');
} else {
    $pageSubTitle = trans('admin.award.form.edit.sub_title', ['id' => $award->id]);
    $url = route('admin_award_update', $award->id);
}
$mls = $award->ml->keyBy('lng_id');

$jsTrans->addTrans([
    'admin.base.label.brand',
    'admin.base.label.agency',
    'admin.base.label.creative'
]);
?>
@extends('core.layout')
@section('content')
<script type="text/javascript">
    $award.saveMode = '<?php echo $saveMode; ?>';
</script>
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">

        @if(Auth::guard('admin')->check())
            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.type')}}</label>
                <div class="col-sm-9">
                    <select id="type" name="type" class="form-control">
                        <option value="">{{trans('admin.base.label.select')}}</option>
                        <option value="{{Award::TYPE_BRAND}}"{{$award->type == Award::TYPE_BRAND ? ' selected="selected"' : ''}}>{{trans('admin.base.label.brand')}}</option>
                        <option value="{{Award::TYPE_AGENCY}}"{{$award->type == Award::TYPE_AGENCY ? ' selected="selected"' : ''}}>{{trans('admin.base.label.agency')}}</option>
                        <option value="{{Award::TYPE_CREATIVE}}"{{$award->type == Award::TYPE_CREATIVE ? ' selected="selected"' : ''}}>{{trans('admin.base.label.creative')}}</option>
                    </select>
                    <div id="form-error-type" class="form-error"></div>
                </div>
            </div>

            <div id="type-id" class="form-group dn">
                <label class="col-sm-3 control-label data-req"></label>
                <div class="col-sm-9">
                    <input type="text" name="type_id" id="type-search" class="form-control" data-value="{{$award->type_id or ''}}" value="{{$typeName}}">
                    <div id="form-error-type_id" class="form-error"></div>
                </div>
            </div>
        @endif

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.year')}}</label>
            <div class="col-sm-9">
                <select name="year" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @for($i = date('Y'); $i > 1899; $i--)
                        <option value="{{$i}}"{{$award->year == $i ? ' selected="selected"' : ''}}>{{$i}}</option>
                    @endfor
                </select>
                <div id="form-error-year" class="form-error"></div>
            </div>
        </div>

        @foreach($languages as $lng)
            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.title').' ('.$lng->code.')'}}</label>
                <div class="col-sm-9">
                    <input type="text" name="ml[{{$lng->id}}][title]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->title : ''}}">
                    <div id="form-error-ml_{{$lng->id}}_title" class="form-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.category').' ('.$lng->code.')'}}</label>
                <div class="col-sm-9">
                    <input type="text" name="ml[{{$lng->id}}][category]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->category : ''}}">
                    <div id="form-error-ml_{{$lng->id}}_category" class="form-error"></div>
                </div>
            </div>
        @endforeach

        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_award_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop