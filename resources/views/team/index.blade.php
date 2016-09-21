<?php

$meta->title(trans('www.team.title'));
$meta->description(trans('www.team.description'));
$meta->keywords(trans('www.homepage.keywords'));
$meta->ogTitle(trans('www.team.title'));
$meta->ogDescription(trans('www.team.description'));
$meta->ogImage(url('/imgs/og-logo.jpg'));
$meta->ogUrl(url_with_lng('/team'));

$fbSDK = true;
?>
@extends('layout')

@section('content')

    <div class="page">

        <div id="main-inner">

            <div id="main-left" class="fl">

                <div id="team" class="tc">
                    <h1 class="fb fs32">{{trans('www.team.title')}}</h1>

                    <?php
                    foreach($team as $value) {
                        if(empty($value->link)) {
                            echo '<span class="team dib">';
                        } else {
                            echo '<a href="'.htmlentities($value->link).'" class="team dib" target="_blank">';
                        }
                    ?><span class="db team-img">
                            <img src="{{$value->getImage()}}" alt="{{$value->first_name.' '.$value->last_name}}" width="166" />
                        </span>
                        <span class="db team-title fsb fs22">{{$value->first_name.' '.$value->last_name}}</span>
                        <span class="db position">{{$value->position}}</span><?php
                        if(empty($value->link)) {
                            echo '</span>';
                        } else {
                            echo '</a>';
                        }
                    }
                    ?>

                </div>

            </div>
            <div id="main-right" class="fr">
                @include('blocks.main_right')
            </div>
            <div class="cb"></div>

        </div>

    </div>

@stop