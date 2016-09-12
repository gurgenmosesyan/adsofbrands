<?php
$title = trans('www.brands.title');

$fbSDK = true;
$pageMenu = 'brands';
?>
@extends('layout')

@section('content')

<div class="page">

    <div id="main-inner">

        <div id="main-left" class="fl">

            <div id="filter">
                <div class="first-filter dib">
                    <div class="filter-icon dib">{{trans('www.base.label.filters')}}:</div><div class="first country select-box">
                        <div class="select-arrow"></div>
                        <div class="select-title fs18"></div>
                        <select name="country">
                            <option value="">{{trans('www.base.label.country')}}</option>
                            @foreach($countries as $value)
                                <option value="{{$value->id}}"{{$value->id == $countryId ? ' selected="selected"' : ''}}>{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div><div class="category select-box">
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

            <div id="list">
                <?php
                foreach($topBrands as $key => $value) { ?><a href="{{$value->getLink()}}" class="item db top top-item-{{$key}}">
                <span class="item-box db">
                    <span class="img db">
                        <img src="{{$value->getImage()}}" />
                    </span>
                    <span class="title db fb fs14">{{$value->title}}</span>
                </span>
                </a><?php } foreach($brands as $key => $value) { ?><a href="{{$value->getLink()}}" class="item db item-{{$key}}">
                <span class="item-box db">
                    <span class="img db">
                        <img src="{{$value->getImage()}}" />
                    </span>
                    <span class="title db fb fs14">{{$value->title}}</span>
                </span>
                </a><?php } ?>

            </div>

            <?php
            if (!empty($countryId)) {
                $brands->appends('country', $countryId);
            }
            if (!empty($categoryId)) {
                $brands->appends('category', $categoryId);
            }
            ?>
            @include('pagination.default', ['pagination' => $brands])

        </div>
        <div id="main-right" class="fr">
            @include('blocks.main_right')
        </div>
        <div class="cb"></div>

    </div>

</div>
<script type="text/javascript">
    $main.filterUrl = '{{url_with_lng('/brands')}}';
</script>

@stop