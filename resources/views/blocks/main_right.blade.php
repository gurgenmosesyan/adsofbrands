<?php
use App\Models\News\News;
use App\Models\Banner\Banner;
use App\Models\Banner\BannerManager;

$banner = BannerManager::getBanners(Banner::KEY_RIGHT_BLOCK);

$query = News::joinMl()->top();
if (isset($newsSkipId)) {
    $query->where('news.id', '!=', $newsSkipId);
}
$topNews = $query->latest()->take(2)->get();
?>
<div class="right-com">
    {!!$banner->getBanner()!!}
</div>
<div class="fb-like-box">
    <div class="fb-page" data-href="https://facebook.com/aobpage" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"></div>
</div>
@if(isset($includeTopAds))
    <div class="right-top-ads">
        <h3 class="fb fs28 tu tc">{{trans('www.base.label.our_tops')}}</h3>
        @include('blocks.items', ['items' => $topAds, 'ad' => true])
    </div>
@endif
@if(!$topNews->isEmpty())
    <div id="top-news">
        <h3 class="fb tu fs28">{{trans('www.base.label.top_news')}}</h3>
        @foreach($topNews as $key => $value)
            <div class="news news-{{$key}}">
                <div class="img">
                    <a href="{{$value->getLink()}}">
                        <img src="{{$value->getImage()}}" alt="{{$value->title}}" width="240" />
                    </a>
                </div>
                <p class="date tu fs14">{{strftime('%b. %d, %Y', strtotime($value->created_at))}}</p>
                <h4 class="fb fs20 lh23">
                    <a href="{{$value->getLink()}}">{{$value->title}}</a>
                </h4>
                <p class="description lh20">{{$value->description}}</p>
            </div>
        @endforeach
        <div><a href="{{url_with_lng('/news', true)}}" class="btn">{{trans('www.base.label.see_all')}}</a></div>
    </div>
@endif