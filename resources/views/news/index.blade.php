<?php

$head->appendStyle('/css/owl.carousel.css');
$head->appendScript('/js/owl.carousel.min.js');

$meta->title($news->title);
$meta->description($news->description);
$meta->keywords(trans('www.homepage.keywords'));
$meta->ogTitle($news->title);
$meta->ogDescription($news->description);
$meta->ogImage($news->getImage());
$meta->ogUrl($news->getLink());

$fbSDK = true;
$shareBox = true;
$pageMenu = 'news';

$text = $news->text;
if (strpos($text, '{album}') !== false) {
    if (!$news->images->isEmpty()) {
        $slider = '<div id="news-slider" class="owl-carousel tc">';
        foreach ($news->images as $value) {
            $slider .= '<img src="'.$value->getImage().'" />';
        }
        $slider .= '</div>';
        $slider = '</strong></p>'.$slider.'<p><strong>';
        $text = str_replace('{album}', $slider, $text);
    }
}

?>
@extends('layout')

@section('content')

<div class="page">

    <div id="main-inner">

        <div id="main-left" class="fl">

            <div id="news-inner">
                <div class="html">
                    <div class="news-img fr">
                        <img src="{{$news->getImage()}}" alt="{{$news->title}}" />
                    </div>
                    <h1 class="fsb fs40">{{$news->title}}</h1>
                    <p class="date tu">{{strftime('%b. %d, %Y', strtotime($news->date))}}</p>
                    {!! $text !!}
                    <div class="cb"></div>
                </div>
            </div>

            <div id="pod-box">
                <div class="addthis_inline_share_toolbox"></div>
            </div>

            <div id="comment-box">
                <div class="fb-comments" data-href="{{$news->getLink()}}" data-numposts="3"></div>
            </div>

            @if(!$relNews->isEmpty())
                <div id="rel-news">
                    <h3 class="rel-title fsb fs32">{{trans('www.related_news.title')}}</h3>
                    @include('blocks.news', ['news' => $relNews, 'notPaginate' => true])
                </div>
            @endif

        </div>
        <div id="main-right" class="fr">
            @include('blocks.main_right', ['newsSkipId' => $news->id])
        </div>
        <div class="cb"></div>

    </div>

</div>
<script>
    $main.initNewsSlider();
</script>

@stop