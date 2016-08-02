<?php
use App\Models\Vacancy\Vacancy;
use App\Core\Helpers\Calendar;

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
?>
@extends('core.layout')
@section('content')
    <form id="edit-form" class="form-horizontal" method="post" action="{{$url}}">
        <div class="box-body">

            <div id="form-error-ml" class="form-error"></div>

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

            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.function')}}</label>
                @foreach($languages as $lng)
                    <div class="col-sm-3">
                        <div class="form-group form-group-inner">
                            <input type="text" name="ml[{{$lng->id}}][function]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->function : ''}}" placeholder="{{$lng->name}}">
                            <div id="form-error-ml_{{$lng->id}}_function" class="form-error"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.term')}}</label>
                @foreach($languages as $lng)
                    <div class="col-sm-3">
                        <div class="form-group form-group-inner">
                            <input type="text" name="ml[{{$lng->id}}][term]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->term : ''}}" placeholder="{{$lng->name}}">
                            <div id="form-error-ml_{{$lng->id}}_term" class="form-error"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.location')}}</label>
                @foreach($languages as $lng)
                    <div class="col-sm-3">
                        <div class="form-group form-group-inner">
                            <input type="text" name="ml[{{$lng->id}}][location]" class="form-control" value="{{isset($mls[$lng->id]) ? $mls[$lng->id]->location : ''}}" placeholder="{{$lng->name}}">
                            <div id="form-error-ml_{{$lng->id}}_location" class="form-error"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.published_on')}}</label>
                <div class="col-sm-3">
                    <?php Calendar::render('published_at', $vacancy->published_at); ?>
                    <div id="form-error-published_at" class="form-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.start_date')}}</label>
                <div class="col-sm-1" style="padding-top: 5px;">
                    <strong>{{trans('admin.base.label.asap')}}:</strong>&nbsp;&nbsp;
                    <input type="checkbox" id="asap" name="asap" class="minimal-checkbox" value="{{Vacancy::ASAP_YES}}"{{$vacancy->asap == Vacancy::ASAP_YES ? ' checked="checked"' : ''}}>
                    <div id="form-error-asap" class="form-error"></div>
                </div>
                <div id="start-date" class="col-sm-3">
                    <?php Calendar::render('start_date', $vacancy->start_date); ?>
                    <div id="form-error-start_date" class="form-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.opening_date')}}</label>
                <div class="col-sm-3">
                    <?php Calendar::render('open_date', $vacancy->open_date); ?>
                    <div id="form-error-open_date" class="form-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.application_deadline')}}</label>
                <div class="col-sm-3">
                    <?php Calendar::render('deadline', $vacancy->deadline); ?>
                    <div id="form-error-deadline" class="form-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.job_description')}}</label>
                <div class="col-sm-9 separate-sections">
                    @foreach($languages as $lng)
                        <div class="form-group form-group-inner">
                            <textarea name="ml[{{$lng->id}}][description]" class="form-control" placeholder="{{$lng->name}}">{{isset($mls[$lng->id]) ? $mls[$lng->id]->description : ''}}</textarea>
                            <div id="form-error-ml_{{$lng->id}}_description" class="form-error"></div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.job_responsibilities')}}</label>
                <div class="col-sm-9 separate-sections">
                    @foreach($languages as $lng)
                        <div class="form-group form-group-inner">
                            <textarea name="ml[{{$lng->id}}][responsibilities]" class="form-control" placeholder="{{$lng->name}}">{{isset($mls[$lng->id]) ? $mls[$lng->id]->responsibilities : ''}}</textarea>
                            <div id="form-error-ml_{{$lng->id}}_responsibilities" class="form-error"></div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.required_qualifications')}}</label>
                <div class="col-sm-9 separate-sections">
                    @foreach($languages as $lng)
                        <div class="form-group form-group-inner">
                            <textarea name="ml[{{$lng->id}}][qualifications]" class="form-control" placeholder="{{$lng->name}}">{{isset($mls[$lng->id]) ? $mls[$lng->id]->qualifications : ''}}</textarea>
                            <div id="form-error-ml_{{$lng->id}}_qualifications" class="form-error"></div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.application_procedures')}}</label>
                <div class="col-sm-9 separate-sections">
                    @foreach($languages as $lng)
                        <div class="form-group form-group-inner">
                            <textarea name="ml[{{$lng->id}}][procedures]" class="form-control" placeholder="{{$lng->name}}">{{isset($mls[$lng->id]) ? $mls[$lng->id]->procedures : ''}}</textarea>
                            <div id="form-error-ml_{{$lng->id}}_procedures" class="form-error"></div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">{{trans('admin.base.label.about')}}</label>
                <div class="col-sm-9 separate-sections">
                    @foreach($languages as $lng)
                        <div class="form-group form-group-inner">
                            <textarea name="ml[{{$lng->id}}][about]" class="form-control" placeholder="{{$lng->name}}">{{isset($mls[$lng->id]) ? $mls[$lng->id]->about : ''}}</textarea>
                            <div id="form-error-ml_{{$lng->id}}_about" class="form-error"></div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{csrf_field()}}
        </div>
        <div class="box-footer">
            <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
            <a href="{{route('admin_vacancy_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
        </div>
    </form>
@stop