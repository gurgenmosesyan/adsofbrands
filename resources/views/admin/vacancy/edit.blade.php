<?php
use App\Models\Vacancy\Vacancy;

$head->appendScript('/assets/plugins/ckeditor/ckeditor.js');
$head->appendScript('/admin/vacancy/vacancy.js');

$pageTitle = trans('admin.vacancy.form.title');
$pageMenu = 'vacancy';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.vacancy.form.add.sub_title');
    $url = route('admin_vacancy_store');
} else {
    $pageSubTitle = trans('admin.vacancy.form.edit.sub_title', ['id' => $vacancy->id]);
    $url = route('admin_vacancy_update', $vacancy->id);
}
$mls = $vacancy->ml->keyBy('lng_id');

$jsTrans->addTrans([
    'admin.base.label.brand',
    'admin.base.label.agency'
]);
?>
@extends('core.layout')
@section('content')
<script type="text/javascript">
    $vacancy.saveMode = '<?php echo $saveMode; ?>';
</script>
<form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
    <div class="box-body">

        @if(Auth::guard('admin')->check())
            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.type')}}</label>
                <div class="col-sm-9">
                    <select id="type" name="type" class="form-control">
                        <option value="">{{trans('admin.base.label.select')}}</option>
                        <option value="{{Vacancy::TYPE_BRAND}}"{{$vacancy->type == Vacancy::TYPE_BRAND ? ' selected="selected"' : ''}}>{{trans('admin.base.label.brand')}}</option>
                        <option value="{{Vacancy::TYPE_AGENCY}}"{{$vacancy->type == Vacancy::TYPE_AGENCY ? ' selected="selected"' : ''}}>{{trans('admin.base.label.agency')}}</option>
                    </select>
                    <div id="form-error-type" class="form-error"></div>
                </div>
            </div>

            <div id="type-id" class="form-group dn">
                <label class="col-sm-3 control-label data-req"></label>
                <div class="col-sm-9">
                    <input type="text" name="type_id" id="type-search" class="form-control" data-value="{{$vacancy->type_id or ''}}" value="{{$typeName}}">
                    <div id="form-error-type_id" class="form-error"></div>
                </div>
            </div>
        @endif

        @foreach($languages as $lng)
            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.title').' ('.$lng->code.')'}}</label>
                <div class="col-sm-9">
                    <input type="text" name="ml[{{$lng->id}}][title]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->title : ''}}">
                    <div id="form-error-ml_{{$lng->id}}_title" class="form-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.description').' ('.$lng->code.')'}}</label>
                <div class="col-sm-9">
                    <textarea name="ml[{{$lng->id}}][description]" class="form-control">{{isset($mls[$lng->id]) ? $mls[$lng->id]->description : ''}}</textarea>
                    <div id="form-error-ml_{{$lng->id}}_description" class="form-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.text').' ('.$lng->code.')'}}</label>
                <div class="col-sm-9">
                    <textarea name="ml[{{$lng->id}}][text]" class="ckeditor">{{isset($mls[$lng->id]) ? $mls[$lng->id]->text : ''}}</textarea>
                    <div id="form-error-ml_{{$lng->id}}_text" class="form-error"></div>
                </div>
            </div>
        @endforeach

        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_vacancy_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop