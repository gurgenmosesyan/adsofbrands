<?php

$meta->title(trans('www.agencies.title'));
$meta->description(trans('www.agencies.list.description'));
$meta->keywords(trans('www.homepage.keywords'));
$meta->ogTitle(trans('www.agencies.title'));
$meta->ogDescription(trans('www.agencies.list.description'));
$meta->ogImage(url('/imgs/og-logo.jpg'));
$meta->ogUrl(url_with_lng('/agencies'));

$fbSDK = true;
$pageMenu = 'agencies';
?>
@extends('layout')

@section('content')

<div class="page">

    <div id="main-inner">

        <div id="main-left" class="fl">

            <div id="filter">
                <div class="first-filter dib">
                    <div class="filter-icon dib">{{trans('www.base.label.filters')}}:</div><div class="first category select-box">
                        <div class="select-arrow"></div>
                        <div class="select-title fs18"></div>
                        <select name="category">
                            <option value="">{{trans('www.base.label.category')}}</option>
                            @foreach($categories as $value)
                                <option value="{{$value->id}}"{{$value->id == $categoryId ? ' selected="selected"' : ''}}>{{$value->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div id="list">
                @include('blocks.items', ['items' => $agencies, 'ad' => false])
            </div>

            <?php
            if (!empty($categoryId)) {
                $agencies->appends('category', $categoryId);
            }
            ?>
            @include('pagination.default', ['pagination' => $agencies])

        </div>
        <div id="main-right" class="fr">
            @include('blocks.main_right')
        </div>
        <div class="cb"></div>

    </div>

</div>
<script type="text/javascript">
    $main.filterUrl = '{{url_with_lng('/agencies')}}';
</script>

@stop