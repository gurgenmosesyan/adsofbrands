<?php
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
                </div><div class="month select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title fs18"></div>
                    <select name="month" class="date">
                        <option value="">{{trans('www.base.label.month')}}</option>
                        @for($i = 1; $i < 13; $i++)
                            <?php $date = date('2016-'.$i.'-01'); ?>
                            <option value="{{$i}}"{{$i == $month ? ' selected="selected"' : ''}}>{{strftime('%b', strtotime($date))}}</option>
                        @endfor
                    </select>
                </div><div class="year select-box">
                    <div class="select-arrow"></div>
                    <div class="select-title fs18"></div>
                    <select name="year" class="date">
                        <option value="">{{trans('www.base.label.year')}}</option>
                        @for($i = date('Y'); $i > 1904; $i--)
                            <option value="{{$i}}"{{$i == $year ? ' selected="selected"' : ''}}>{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div id="list">
                @include('blocks.items', ['items' => $commercials, 'ad' => true])
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
            if (!empty($month)) {
                $commercials->appends('month', $month);
                $commercials->appends('year', $year);
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
</script>

@stop