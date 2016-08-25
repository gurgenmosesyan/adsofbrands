<?php
use App\Models\Commercial\Commercial;
use App\Core\Helpers\ImgUploader;
use App\Core\Helpers\Calendar;

$head->appendStyle('/admin/commercial/commercial.css');
$head->appendScript('/admin/commercial/commercial.js');

$pageTitle = trans('admin.commercial.form.title');
$pageMenu = 'commercial';
$youtubeId = $youtubeUrl = $vimeoId = $vimeoUrl = $fbVideoId = $embedCode = '';
if ($saveMode == 'add') {
    $pageSubTitle = trans('admin.commercial.form.add.sub_title');
    $url = route('admin_commercial_store');
} else {
    $pageSubTitle = trans('admin.commercial.form.edit.sub_title', ['id' => $commercial->id]);
    $url = route('admin_commercial_update', $commercial->id);
    if ($commercial->isVideo()) {
        if ($commercial->isYoutube()) {
            $commercial->video_data = json_decode($commercial->video_data);
            $youtubeId = $commercial->video_data->id;
            $youtubeUrl = $commercial->video_data->url;
        } else if ($commercial->isVimeo()) {
            $commercial->video_data = json_decode($commercial->video_data);
            $vimeoIdId = $commercial->video_data->id;
            $vimeoUrl = $commercial->video_data->url;
        } else if ($commercial->isFb()) {
            $fbVideoId = $commercial->video_data;
        } else {
            $embedCode = $commercial->video_data;
        }
    }
}
$mls = $commercial->ml->keyBy('lng_id');

$jsTrans->addTrans([
    'admin.base.label.position',
    'admin.base.label.name',
    'admin.base.label.creative',
    'admin.base.label.brand',
    'admin.base.label.agency',
    'admin.base.label.sort',
    'admin.base.label.link',
    'admin.base.field.not_valid'
]);
?>
@extends('core.layout')
@section('content')
<script type="text/javascript">
    $commercial.brands = <?php echo json_encode($brands); ?>;
    $commercial.agencies = <?php echo json_encode($agencies); ?>;
    $commercial.tags = <?php echo json_encode($commercial->tags); ?>;
    $commercial.advertisings = <?php echo json_encode($advertisings); ?>;
    $commercial.credits = <?php echo json_encode($credits); ?>;
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
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.short_description').' ('.$lng->code.')'}}</label>
                <div class="col-sm-9">
                    <textarea name="ml[{{$lng->id}}][description]" class="form-control">{{isset($mls[$lng->id]) ? $mls[$lng->id]->description : ''}}</textarea>
                    <div id="form-error-ml_{{$lng->id}}_description" class="form-error"></div>
                </div>
            </div>
        @endforeach

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.alias')}}</label>
            <div class="col-sm-9">
                <input type="text" name="alias" class="alias form-control" value="{{$commercial->alias or ''}}">
                <div id="form-error-alias" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.media_type')}}</label>
            <div class="col-sm-9">
                <select name="media_type_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($mediaTypes as $value)
                        <option value="{{$value->id}}"{{$value->id == $commercial->media_type_id ? ' selected="selected"' : ''}}>{{$value->title}}</option>
                    @endforeach
                </select>
                <div id="form-error-media_type_id" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.industry_type')}}</label>
            <div class="col-sm-9">
                <select name="industry_type_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($industryTypes as $value)
                        <option value="{{$value->id}}"{{$value->id == $commercial->industry_type_id ? ' selected="selected"' : ''}}>{{$value->title}}</option>
                    @endforeach
                </select>
                <div id="form-error-industry_type_id" class="form-error"></div>
            </div>
        </div>

        @if(Auth::guard('brand')->guest())
            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.brands')}}</label>
                <div class="col-sm-9">
                    <input type="text" id="brand-input" class="form-control" value="">
                    <div id="brand-block" style="margin-top: 10px;"></div>
                    <div id="form-error-brands" class="form-error"></div>
                </div>
            </div>
        @endif

        @if(Auth::guard('agency')->guest())
            <div class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.agencies')}}</label>
                <div class="col-sm-9">
                    <input type="text" id="agency-input" class="form-control" value="">
                    <div id="agency-block" style="margin-top: 10px;"></div>
                    <div id="form-error-agencies" class="form-error"></div>
                </div>
            </div>
        @endif

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.country')}}</label>
            <div class="col-sm-9">
                <select name="country_id" class="form-control">
                    <option value="">{{trans('admin.base.label.global')}}</option>
                    @foreach($countries as $value)
                        <option value="{{$value->id}}"{{$value->id == $commercial->country_id ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                    @endforeach
                </select>
                <div id="form-error-country_id" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.category')}}</label>
            <div class="col-sm-9">
                <select name="category_id" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    @foreach($categories as $value)
                        <option value="{{$value->id}}"{{$value->id == $commercial->category_id ? ' selected="selected"' : ''}}>{{$value->title}}</option>
                    @endforeach
                </select>
                <div id="form-error-category_id" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.image')}}</label>
            <div class="col-sm-9">
                <?php ImgUploader::uploader('commercial', 'image', 'image', $commercial->image); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.type')}}</label>
            <div class="col-sm-9">
                <select id="type-select" name="type" class="form-control">
                    <option value="">{{trans('admin.base.label.select')}}</option>
                    <option value="{{Commercial::TYPE_VIDEO}}"{{$commercial->isVideo() ? ' selected="selected"' : ''}}>{{trans('admin.commercial.type.video')}}</option>
                    <option value="{{Commercial::TYPE_PRINT}}"{{$commercial->isPrint() ? ' selected="selected"' : ''}}>{{trans('admin.commercial.type.print')}}</option>
                </select>
                <div id="form-error-type" class="form-error"></div>
            </div>
        </div>

        <div id="video-box" class="dn">

            <div id="video-type" class="form-group">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.video_type')}}</label>
                <div class="col-sm-9">
                    <select id="video-type-select" name="video_type" class="form-control">
                        <option value="">{{trans('admin.base.label.select')}}</option>
                        <option value="{{Commercial::VIDEO_TYPE_YOUTUBE}}"{{$commercial->isYoutube() ? ' selected="selected"' : ''}}>{{trans('admin.base.label.youtube')}}</option>
                        <option value="{{Commercial::VIDEO_TYPE_VIMEO}}"{{$commercial->isVimeo() ? ' selected="selected"' : ''}}>{{trans('admin.base.label.vimeo')}}</option>
                        <option value="{{Commercial::VIDEO_TYPE_FB}}"{{$commercial->isFb() ? ' selected="selected"' : ''}}>{{trans('admin.base.label.fb')}}</option>
                        <option value="{{Commercial::VIDEO_TYPE_EMBED}}"{{$commercial->isEmbed() ? ' selected="selected"' : ''}}>{{trans('admin.base.label.embed_code')}}</option>
                    </select>
                    <div id="form-error-video_type" class="form-error"></div>
                </div>
            </div>

            <div id="video-youtube" class="form-group dn">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.youtube_url')}}</label>
                <div class="col-sm-9">
                    <input type="text" id="youtube-url" name="youtube_url" class="form-control" value="{{$youtubeUrl}}">
                    <input type="hidden" id="youtube-id" name="youtube_id" value="{{$youtubeId}}">
                    <div id="youtube-img" class="dn" style="margin-top: 10px;"></div>
                    <div id="form-error-youtube_url" class="form-error"></div>
                    <div id="form-error-youtube_id" class="form-error"></div>
                </div>
            </div>

            <div id="video-vimeo" class="form-group dn">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.vimeo_url')}}</label>
                <div class="col-sm-9">
                    <input type="text" id="vimeo-url" name="vimeo_url" class="form-control" value="{{$vimeoUrl}}">
                    <input type="hidden" id="vimeo-id" name="vimeo_id" value="{{$vimeoId}}">
                    <div id="vimeo-img" class="dn-" style="margin-top: 10px;"></div>
                    <div id="form-error-vimeo_url" class="form-error"></div>
                    <div id="form-error-vimeo_id" class="form-error"></div>
                </div>
            </div>

            <div id="video-fb" class="form-group dn">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.fb_video_id')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="fb_video_id" class="form-control" value="{{$fbVideoId}}">
                    <div id="form-error-fb_video_id" class="form-error"></div>
                </div>
            </div>

            <div id="video-embed" class="form-group dn">
                <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.embed_code')}}</label>
                <div class="col-sm-9">
                    <textarea name="embed_code" class="form-control">{{$embedCode}}</textarea>
                    <div id="form-error-embed_code" class="form-error"></div>
                </div>
            </div>
        </div>

        <div id="print-block" class="form-group dn">
            <label class="col-sm-3 control-label data-req">{{trans('admin.base.label.print_image')}}</label>
            <div class="col-sm-9">
                <?php ImgUploader::uploader('commercial', 'image_print', 'image_print', $commercial->image_print); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.advertising_info')}}</label>
            <div class="col-sm-9">
                <div id="advertisings" class="dn">
                    <div class="row">
                        <div class="col-sm-3">
                            <input type="text" name="advertising" class="form-control" value="{{$commercial->advertising or ''}}" placeholder="{{trans('admin.base.label.title')}}">
                            <div id="form-error-advertising" class="form-error"></div>
                        </div>
                        <div id="adv-info" class="col-sm-9"></div>
                    </div>
                </div>
                <a href="#" id="add-advertising" class="btn btn-default"><i class="fa fa-plus"></i></a>
                <div id="form-error-advertisings" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label{{Auth::guard('creative')->check() ? ' data-req' : ''}}">{{trans('admin.base.label.credits')}}</label>
            <div class="col-sm-9">
                <div id="credits"></div>
                <a href="#" id="add-credit" class="btn btn-default"><i class="fa fa-plus"></i></a>
                <div id="form-error-credits" class="form-error"></div>
                <div id="form-error-credits_creative" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.featured')}}</label>
            <div class="col-sm-9">
                <input type="checkbox" name="featured" class="minimal-checkbox" value="{{Commercial::FEATURED}}"{{$commercial->isFeatured() ? ' checked="checked"' : ''}}>
                <div id="form-error-featured" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.top')}}</label>
            <div class="col-sm-9">
                <input type="checkbox" name="top" class="minimal-checkbox" value="{{Commercial::TOP}}"{{$commercial->isTop() ? ' checked="checked"' : ''}}>
                <div id="form-error-top" class="form-error"></div>
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
            <label class="col-sm-3 control-label">{{trans('admin.base.label.published_date')}}</label>
            <div class="col-sm-4">
                <?php Calendar::render('published_date', $commercial->published_date); ?>
                <div id="form-error-published_date" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.rating')}}</label>
            <div class="col-sm-4">
                <input type="text" name="rating" class="form-control" value="{{$commercial->rating}}">
                <div id="form-error-rating" class="form-error"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">{{trans('admin.base.label.quantity_vote')}}</label>
            <div class="col-sm-4">
                <input type="text" name="qt" class="form-control" value="{{$commercial->qt}}">
                <div id="form-error-qt" class="form-error"></div>
            </div>
        </div>

        {{csrf_field()}}
    </div>
    <div class="box-footer">
        <input type="submit" class="nav-btn nav-btn-save btn btn-primary" value="{{trans('admin.base.label.save')}}">
        <a href="{{route('admin_commercial_table')}}" class="nav-btn nav-btn-cancel btn btn-default">{{trans('admin.base.label.cancel')}}</a>
    </div>
</form>
@stop