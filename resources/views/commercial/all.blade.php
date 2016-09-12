<?php
$head->appendStyle('/css/jquery-ui.css');
$head->appendScript('/js/jquery-ui.min.js');

$title = trans('www.commercials.title');

$fbSDK = true;
$pageMenu = 'ads';
?>
@extends('layout')

@section('content')

<div class="page">

    <div id="main-inner">

        <div id="main-left" class="fl">

            <div id="filter">
                <div class="first-filter dib">
                    <div class="filter-icon dib">{{trans('www.base.label.filters')}}:</div><div class="first media-type select-box">
                        <div class="select-arrow"></div>
                        <div class="select-title fs18"></div>
                        <select name="media">
                            <option value="">{{trans('www.base.label.media_type')}}</option>
                            @foreach($mediaTypes as $value)
                                <option value="{{$value->id}}"{{$value->id == $mediaTypeId ? ' selected="selected"' : ''}}>{{$value->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div><div class="industry-type select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title fs18"></div>
                    <select name="industry">
                        <option value="">{{trans('www.base.label.industry_type')}}</option>
                        @foreach($industryTypes as $value)
                            <option value="{{$value->id}}"{{$value->id == $industryTypeId ? ' selected="selected"' : ''}}>{{$value->title}}</option>
                        @endforeach
                    </select>
                </div><div class="country select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title fs18"></div>
                    <select name="country">
                        <option value="">{{trans('www.base.label.country')}}</option>
                        @foreach($countries as $value)
                            <option value="{{$value->id}}"{{$value->id == $countryId ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                        @endforeach
                    </select>
                </div><input class="bib fsb date fs18{{empty($date) ? '' : ' big'}}" type="text" value="{{empty($date) ? trans('www.base.label.date') : date('d/m/Y', strtotime($date))}}" />
                <input type="hidden" id="alt-date" value="{{$date}}" />
            </div>

            <div id="list">
                <?php
                foreach($featuredAds as $key => $value) { ?><a href="{{$value->getLink()}}" class="item db top top-item-{{$key}}">
                    <span class="item-box db">
                        <span class="img db">
                            <img src="{{$value->getImage()}}" />
                            <span class="rating db fb fs18">{{number_format($value->rating, 1)}}</span>
                        </span>
                        <span class="title db fb fs14">{{$value->title}}</span>
                        <span class="db bottom clearfix">
                            <span class="views-count fl fb">{{$value->views_count}}</span>
                            <span class="comment fr fb">
                                {{$value->comments_count > 999  ?'999+' : $value->comments_count}}
                            </span>
                        </span>
                    </span>
                </a><?php } foreach($commercials as $key => $value) { ?><a href="{{$value->getLink()}}" class="item db item-{{$key}}">
                    <span class="item-box db">
                        <span class="img db">
                            <img src="{{$value->getImage()}}" />
                            <span class="rating db fb fs18">{{number_format($value->rating, 1)}}</span>
                        </span>
                        <span class="title db fb fs14">{{$value->title}}</span>
                        <span class="db bottom clearfix">
                            <span class="views-count fl fb">{{$value->views_count}}</span>
                            <span class="comment fr fb">
                                {{$value->comments_count > 999  ?'999+' : $value->comments_count}}
                            </span>
                        </span>
                    </span>
                </a><?php } ?>

            </div>

            <?php
            if (!empty($mediaTypeId)) {
                $commercials->appends('media', $mediaTypeId);
            }
            if (!empty($industryTypeId)) {
                $commercials->appends('industry', $industryTypeId);
            }
            if (!empty($countryId)) {
                $commercials->appends('country', $countryId);
            }
            if (!empty($categoryId)) {
                $commercials->appends('category', $categoryId);
            }
            if (!empty($date)) {
                $commercials->appends('date', $date);
            }
            ?>
            @include('pagination.default', ['pagination' => $commercials])

        </div>
        <div id="main-right" class="fr">
            @include('blocks.main_right')
        </div>
        <div class="cb"></div>

    </div>

</div>
<script type="text/javascript">
    $main.filterUrl = '{{url_with_lng('/ads')}}';
    $main.initFilterDate();
</script>

@stop