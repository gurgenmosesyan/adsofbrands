<?php
use App\Models\News\News;
use App\Core\Helpers\ImgUploader;

$head->appendStyle('/admin/news/news.css');
$head->appendScript('/assets/plugins/ckeditor/ckeditor.js');
$head->appendScript('/assets/plugins/ckfinder/ckfinder.js');
$head->appendScript('/admin/news/news.js');

$pageTitle = trans('admin.news.form.title');
$pageMenu = 'news';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.news.form.add.sub_title');
    $url = route('admin_news_store');
} else {
    $pageSubTitle = trans('admin.news.form.edit.sub_title', ['id' => $news->id]);
    $url = route('admin_news_update', $news->id);
}
$mls = $news->ml->keyBy('lng_id');
?>
@extends('core.layout')
@section('content')
<script type="text/javascript">
    $news.brands = <?php echo json_encode($brands); ?>;
    $news.agencies = <?php echo json_encode($agencies); ?>;
    $news.creatives = <?php echo json_encode($creatives); ?>;
    $news.tags = <?php echo json_encode($news->tags); ?>;
</script>
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
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.description').' ('.$lng->code.')'}}</label>
                <div class="col-sm-9">
                    <textarea name="ml[{{$lng->id}}][description]" class="form-control">{{isset($mls[$lng->id]) ? $mls[$lng->id]->description : ''}}</textarea>
                    <div id="form-error-ml_{{$lng->id}}_description" class="form-error"></div>
                </div>
            </div>
        @endforeach

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.alias')}}</label>
            <div class="col-sm-9">
                <input type="text" name="alias" class="alias form-control" value="{{$news->alias or ''}}">
                <div id="form-error-alias" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.image')}}</label>
            <div class="col-sm-9">
                <?php ImgUploader::uploader('news', 'image', 'image', $news->image); ?>
            </div>
        </div>

        @foreach($languages as $lng)
            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.text').' ('.$lng->code.')'}}</label>
                <div class="col-sm-9">
                    <textarea name="ml[{{$lng->id}}][text]" class="ckeditor">{{isset($mls[$lng->id]) ? $mls[$lng->id]->text : ''}}</textarea>
                    <div id="form-error-ml_{{$lng->id}}_text" class="form-error"></div>
                </div>
            </div>
        @endforeach

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.top')}}</label>
            <div class="col-sm-9">
                <input type="checkbox" name="top" class="minimal-checkbox" value="{{News::TOP}}"{{$news->isTop() ? ' checked="checked"' : ''}}>
                <div id="form-error-top" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.brands')}}</label>
            <div class="col-sm-9">
                <input type="text" id="brand-input" class="form-control" value="">
                <div id="brand-block" style="margin-top: 10px;"></div>
                <div id="form-error-brands" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.agencies')}}</label>
            <div class="col-sm-9">
                <input type="text" id="agency-input" class="form-control" value="">
                <div id="agency-block" style="margin-top: 10px;"></div>
                <div id="form-error-agencies" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.creatives')}}</label>
            <div class="col-sm-9">
                <input type="text" id="creative-input" class="form-control" value="">
                <div id="creative-block" style="margin-top: 10px;"></div>
                <div id="form-error-creatives" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.tags')}}</label>
            <div class="col-sm-9">
                <input type="text" id="tag" class="form-control" value="">
                <div id="tags" style="margin-top: 10px;"></div>
                <div id="form-error-tags" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.status')}}</label>
            <div class="col-sm-9 show-status-box">
                <label>
                    <input type="radio" name="show_status" class="minimal-checkbox" value="{{News::STATUS_ACTIVE}}"{{$news->show_status == News::STATUS_ACTIVE ? ' checked="checked"' : ''}}>
                    <span>{{trans('admin.base.label.active')}}</span>
                </label>
                <label>
                    <input type="radio" name="show_status" class="minimal-checkbox" value="{{News::STATUS_INACTIVE}}"{{$news->show_status == News::STATUS_INACTIVE ? ' checked="checked"' : ''}}>
                    <span>{{trans('admin.base.label.inactive')}}</span>
                </label>
                <div id="form-error-show_status" class="form-error"></div>
            </div>
        </div>

        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_news_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop