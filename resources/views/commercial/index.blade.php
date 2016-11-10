<?php
use App\Models\Commercial\Commercial;
use App\Models\Commercial\CommercialTag;

$head->appendStyle('/css/jquery.mCustomScrollbar.css');
$head->appendScript('/js/jquery.mCustomScrollbar.concat.min.js');

$meta->title($ad->title);
$meta->description($ad->description);
$meta->keywords(trans('www.homepage.keywords'));
$meta->ogTitle($ad->title);
$meta->ogDescription($ad->description);
if ($ad->isPrint()) {
    $image = $ad->isPrint();
} else if ($ad->isYoutube()) {
    $videoData = json_decode($ad->video_data);
    $image = 'http://img.youtube.com/vi/'.$videoData->id.'/sddefault.jpg';
} else {
    $image = $ad->getImage();
}
$meta->ogImage($image);
$meta->ogUrl($ad->getLink());

$fbSDK = true;
$shareBox = true;
$pageMenu = 'ads';

$rated = false;
if (isset($_COOKIE['rate'])) {
    $ratedData = json_decode($_COOKIE['rate'], true);
    if (isset($ratedData[$ad->id])) {
        $rated = $ratedData[$ad->id];
    }
}

$mediaType = $ad->media_type()->joinMl()->first();
$brand = $ad->brands()->select('brands.id','brands.alias','brands.image','ml.title')->join('brands_ml as ml', function($query) {
    $query->on('ml.id', '=', 'brands.id');
})->first();
$agency = $ad->agencies()->first();

if ($brand != null) {
    $brandAds = Commercial::joinMl()->join('commercial_brands as c_brands', function($query) use($brand) {
        $query->on('c_brands.commercial_id', '=', 'commercials.id')->where('c_brands.brand_id', '=', $brand->id);
    })->where('commercials.id', '!=', $ad->id)->latest()->take(7)->get();
} else {
    $brandAds = collect();
}

$query = CommercialTag::getProcessor();
foreach ($ad->tags as $value) {
    $query->orWhere('tag', $value->tag);
}
$adIds = $query->lists('commercial_id');

$similarAds = Commercial::joinMl()->whereIn('commercials.id', $adIds)->where('commercials.id', '!=', $ad->id)->take(7)->get();

$jsTrans->addTrans(['www.rate.already_rated']);
?>
@extends('layout')

@section('content')

<div class="page">

    <div id="main-inner">

        <div id="main-left" class="fl">

            <div id="com-left" class="fl">
                <div class="com-media">
                    @if($ad->isVideo())
                        @if($ad->isYoutube())
                            <iframe width="100%" height="450" src="https://www.youtube.com/embed/{{$videoData->id}}" frameborder="0" allowfullscreen></iframe>
                        @elseif($ad->isVimeo())
                            <?php $videoData = json_decode($ad->video_data); ?>
                                <iframe src="https://player.vimeo.com/video/{{$videoData->id}}" width="100%" height="450" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        @elseif($ad->isFb())
                            <iframe src="https://www.facebook.com/plugins/video.php?href={{$ad->video_data}}" width="100%" height="400" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>
                        @else
                            {!!$ad->video_data!!}
                        @endif
                    @else
                        <div class="print-image">
                            <a href="{{$ad->getOriginalImage()}}" target="_blank">
                                <img src="{{$ad->getPrintImage()}}" alt="{{$ad->title}}" />
                            </a>
                        </div>
                    @endif
                </div>
                <div class="prev-next fb">
                    @if($prevAd != null)
                        <a href="{{$prevAd->getLink()}}" class="db prev fl">
                            <span class="db fl arrow"></span>
                            <span class="db fr img" style="background-image: url('{{$prevAd->getImage()}}');"></span>
                            <span class="db w-title">
                                <span class="db w-title-inner">
                                    <span class="db w-top fs22">{{trans('www.base.label.prev_ad')}}</span>
                                    <span class="db">{{$prevAd->title}}</span>
                                </span>
                            </span>
                        </a>
                    @endif
                    @if($nextAd != null)
                        <a href="{{$nextAd->getLink()}}" class="db next fr">
                            <span class="db fl img" style="background-image: url('{{$nextAd->getImage()}}');"></span>
                            <span class="db fr arrow"></span>
                            <span class="db w-title">
                                <span class="db w-title-inner">
                                    <span class="db w-top fs22">{{trans('www.base.label.next_ad')}}</span>
                                    <span class="db">{{$nextAd->title}}</span>
                                </span>
                            </span>
                        </a>
                    @endif
                    <div class="cb"></div>
                </div>

                <div id="pod-box">
                    <div class="addthis_native_toolbox"></div>
                </div>

                <div id="comment-box">
                    <div class="fb-comments" data-href="{{$ad->getLink()}}" data-numposts="3" data-width="100%"></div>
                </div>

            </div>
            <div id="com-right" class="fr">
                <h1 class="fsb fs36">{{$ad->title}}</h1>
                <div class="view-comment fb fs24">
                    <?php /*
                    {{--<div class="dib views-count">{{$ad->views_count}}</div>--}}
                    */ ?>
                    <?php /*
                    {{--<div class="dib comment">{{$ad->comments_count > 999  ?'999+' : $ad->comments_count}}</div>--}}
                    */?>
                </div>
                <div class="rate-box{{$rated === false ? '' : ' rated-box'}}">
                    <?php $rating = number_format($ad->rating, 1); ?>
                    <div class="dib rating fb fs26">{{$rating}}</div>
                    <div class="stars-box dib">
                        @if(!$rated)
                            <div class="stars dn">
                                @for($i = 1; $i < 11; $i++)
                                    <?php $class = $rated !== false && $rated >= $i ? ' active' : ''; ?>
                                    <a href="#" class="rate rate-{{$i}} db fl{{$class}}" data-com="{{$ad->id}}" data-val="{{$i}}"></a>
                                @endfor
                                <span class="db cb"></span>
                            </div>
                        @endif
                        <div class="rated"{!!$rated === false ? '' : ' title="'.trans('www.rate.already_rated').'"'!!}>
                            <div style="width: {{$rating*10}}%;"></div>
                        </div>
                    </div>
                </div>
                @if($mediaType != null)
                    <div class="media-type">
                        <p class="dib fsb fs24 mt-title">{{trans('www.base.label.media_type')}}:</p>
                        <a href="{{url_with_lng('/ads?media='.$mediaType->id)}}" class="dib">
                            <img src="{{$mediaType->getIcon()}}" alt="{{$mediaType->title}}" />
                            <span class="dib fb fs24">{{$mediaType->title}}</span>
                        </a>
                    </div>
                @endif
                @if($brand != null || $agency != null || !empty($ad->country_id) || $ad->category_ml != null)
                    <div class="info-box">
                        @if($brand != null || $agency != null)
                            <div class="brand-agency dib">
                                @if($brand != null)
                                    <div class="brand dib">
                                        <p class="fsb fs24">{{trans('www.base.label.brand')}}</p>
                                        <a href="{{$brand->getLink()}}" class="db">
                                            <img src="{{$brand->getImage()}}" alt="brand" width="81" />
                                        </a>
                                    </div>
                                @endif
                                @if($agency != null)
                                    <div class="agency dib">
                                        <p class="fsb fs24">{{trans('www.base.label.agency')}}</p>
                                        <a href="{{$agency->getLink()}}" class="db">
                                            <img src="{{$agency->getImage()}}" alt="agency" width="81" />
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                        @if(!empty($ad->country_id) || $ad->category_ml != null)
                            <div class="country-ind dib">
                                @if(!empty($ad->country_id))
                                    <div class="country">
                                        <p class="fsb fs20 dib">{{trans('www.base.label.country')}}:</p>
                                        <p class="dib fs18"><a href="{{url_with_lng('/ads?country='.$ad->country_ml->id)}}" class="underline">{{$ad->country_ml->name}}</a></p>
                                    </div>
                                @endif
                                @if($ad->category_ml != null)
                                    <div class="industry">
                                        <p class="fsb fs20 dib">{{trans('www.base.label.industry')}}:</p>
                                        <p class="dib fs18"><a href="{{url_with_lng('/ads?industry='.$ad->category_ml->id)}}" class="underline">{{$ad->category_ml->title}}</a></p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif
                <div class="description fs18 lh21">{{$ad->description}}</div>

                @if(!$credits->isEmpty() || !empty($ad->advertising) || (!empty($ad->published_date) && $ad->published_date != '0000-00-00'))
                    <div class="credits">
                        <h2 class="fsb fs30">{{trans('www.base.label.credits')}}</h2>
                        <div id="credits-box">
                            @if(!empty($ad->advertising))
                                <div class="credit fs20">
                                    <p class="fsb position">{{$ad->advertising}}:</p>
                                    <?php $personsStr = ''; ?>
                                    @foreach($ad->advertisings as $person)
                                        <?php $personsStr .= '<a href="'.$person->link.'" class="underline" target="_blank">'.$person->name.'</a>, '; ?>
                                    @endforeach
                                    {!!mb_substr($personsStr, 0, -2)!!}
                                </div>
                            @endif
                            @foreach($credits as $value)
                                <div class="credit fs20">
                                    <p class="fsb position">{{$value->position}}:</p>
                                    <?php $personsStr = ''; ?>
                                    @foreach($value->persons as $person)
                                        <?php
                                        if (empty($person->type_id)) {
                                            $personsStr .= '<span>'.$person->name.'</span>'.$person->separator.' ';
                                        } else {
                                            $personsStr .= '<a href="'.url_with_lng($person->link.'/'.$person->alias.'/'.$person->id).'" class="underline">'.$person->name.'</a>'.$person->separator.' ';
                                        }
                                        ?>
                                    @endforeach
                                    {!!mb_substr($personsStr, 0, -2)!!}
                                </div>
                            @endforeach
                            @if(!empty($ad->published_date) && $ad->published_date != '0000-00-00')
                                <div class="credit fs20">
                                    <p class="fsb position">{{trans('www.base.label.date')}}:</p>
                                    <span>{{strftime('%B, %Y', strtotime($ad->published_date))}}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="tags">
                    @foreach($ad->tags as $value)
                        <a href="{{url_with_lng('/search?q='.$value->tag)}}" class="dib tag fb">#{{$value->tag}}</a>
                    @endforeach
                </div>
            </div>
            <div class="cb"></div>

            @if(!$brandAds->isEmpty())
                <div id="brand-ads">
                    <h3 class="fsb fs30">{{trans('www.base.label.more_from').' '.$brand->title}}</h3>
                    @include('blocks.items', ['items' => $brandAds, 'ad' => true])
                </div>
            @endif

            @if(!$similarAds->isEmpty())
                <div id="similar-ads">
                    <h3 class="fsb fs30">{{trans('www.base.label.similar_ads')}}</h3>
                    @include('blocks.items', ['items' => $similarAds, 'ad' => true])
                </div>
            @endif

        </div>
        <div id="main-right" class="fr">
            @include('blocks.main_right', ['includeTopAds' => true])
        </div>
        <div class="cb"></div>

    </div>

</div>
<script type="text/javascript">
    $('#credits-box').mCustomScrollbar();
    $main.initRate();
    setTimeout(function() {
        $main.initAdViews({{$ad->id}});
    }, 2000);
</script>

@stop