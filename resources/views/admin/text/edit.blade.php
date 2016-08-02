<?php
//$head->appendScript('/assets/plugins/ckeditor/ckeditor.js');
$head->appendScript('/admin/text/text.js');
$pageTitle = trans('admin.text.form.title');
$pageMenu = 'text';
$pageSubTitle = trans('admin.text.form.key.'.$text->key);
$mls = $text->ml->keyBy('lng_id');
?>
@extends('core.layout')
@section('content')
    <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
    <form id="edit-form" class="form-horizontal" method="post" action="{{route('admin_text_update', $text->id)}}">
        <div class="box-body">

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.text')}}</label>
                <div class="col-sm-9">
                    @foreach($languages as $lng)
                        <div>
                            <textarea id="text-box" rows="7" name="ml[{{$lng->id}}][text]" class="form-control ckeditor" placeholder="{{$lng->name}}">{{isset($mls[$lng->id]) ? $mls[$lng->id]->text : ''}}</textarea>
                            <div id="form-error-ml_{{$lng->id}}_text" class="form-error"></div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{csrf_field()}}
        </div>
        <div class="box-footer">
            <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
            <a href="{{route('admin_text_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
        </div>
    </form>
@stop