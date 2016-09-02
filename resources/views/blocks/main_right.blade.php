<?php
use App\Models\News\News;

$topNews = News::joinMl()->top()->latest()->take(2)->get();
?>
<div class="right-ad">
    <a href="#"><img src="{{url('/imgs/temp/ad4.jpg')}}" alt="ad" /></a>
</div>
<div class="fb-like-box">
    <div class="fb-page" data-href="https://web.facebook.com/aobpage" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"></div>
</div>
@if(!$topNews->isEmpty())
    <div id="top-news">
        <h3 class="fb tu fs28">{{trans('www.base.label.top_news')}}</h3>
        @foreach($topNews as $key => $value)
            <div class="news news-{{$key}}">
                <div class="img"><img src="{{$value->getImage()}}" width="240" /></div>
                <p class="date tu fs14">{{strftime('%b. %d, %Y', strtotime($value->created_at))}}</p>
                <h4 class="fb fs20 lh23">{{$value->title}}</h4>
                <p class="description lh20">{{$value->description}}</p>
            </div>
        @endforeach
        <div><a href="{{url_with_lng('/news', true)}}" class="btn">{{trans('www.base.label.see_all')}}</a></div>
    </div>
@endif