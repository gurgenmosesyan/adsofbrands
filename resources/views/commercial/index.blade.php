<?php
use App\Models\Commercial\Commercial;
use App\Models\Commercial\CommercialTag;

$head->appendScript('/js/jquery.mCustomScrollbar.concat.min.js');
$head->appendStyle('/css/jquery.mCustomScrollbar.css');

$title = $ad->title;

$fbSDK = true;
$pageMenu = 'ads';

$mediaType = $ad->media_type()->joinMl()->first();
$brand = $ad->brands()->select('brands.id','brands.alias','brands.image','ml.title')->join('brands_ml as ml', function($query) {
    $query->on('ml.id', '=', 'brands.id');
})->first();
$agency = $ad->agencies()->first();

$brandAds = Commercial::joinMl()->join('commercial_brands as c_brands', function($query) use($brand) {
    $query->on('c_brands.commercial_id', '=', 'commercials.id')->where('c_brands.brand_id', '=', $brand->id);
})->latest()->take(7)->get();

$query = CommercialTag::getProcessor();
foreach ($ad->tags as $value) {
    $query->orWhere('tag', $value->tag);
}
$adIds = $query->lists('commercial_id');

$similarAds = Commercial::joinMl()->whereIn('commercials.id', $adIds)->where('commercials.id', '!=', $ad->id)->paginate(27);
?>
@extends('layout')

@section('content')

<div class="page">

    <div id="main-inner">

        <div id="main-left" class="fl">

            <div id="ad-left" class="fl">
                <div class="ad-media">
                    @if($ad->isVideo())
                        @if($ad->isYoutube())
                            <?php $videoData = json_decode($ad->video_data); ?>
                            <iframe width="100%" height="450" src="https://www.youtube.com/embed/{{$videoData->id}}" frameborder="0" allowfullscreen></iframe>
                        @elseif($ad->isVimeo())
                            <?php $videoData = json_decode($ad->video_data); ?>
                                <iframe src="https://player.vimeo.com/video/{{$videoData->id}}" width="100%" height="450" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        @elseif($ad->isFb())
                            <iframe src="https://www.facebook.com/plugins/video.php?href={{$ad->video_data}}" width="100%" height="450" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>
                        @else
                            {!!$ad->video_data!!}
                        @endif
                    @else
                        <div class="print-image">
                            <img src="{{$ad->getPrintImage()}}" alt="{{$ad->title}}" />
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
            </div>
            <div id="ad-right" class="fr">
                <h1 class="fsb fs36">{{$ad->title}}</h1>
                <div class="view-comment fb fs24">
                    <div class="dib views-count">{{$ad->views_count}}</div>
                    <div class="dib comment">{{$ad->comments_count > 999  ?'999+' : $ad->comments_count}}</div>
                </div>
                @if($mediaType != null)
                    <div class="media-type">
                        <p class="dib fsb fs24 mt-title">{{trans('www.base.label.media_type')}}:</p>
                        <div class="dib">
                            <img src="{{$mediaType->getIcon()}}" alt="{{$mediaType->title}}" />
                            <p class="dib fb fs24">{{$mediaType->title}}</p>
                        </div>
                    </div>
                @endif
                <div class="info-box">
                    <div class="brand-agency dib">
                        <div class="brand dib">
                            <p class="fsb fs24">{{trans('www.base.label.brand')}}</p>
                            <a href="{{$brand->getLink()}}" class="db">
                                <img src="{{$brand->getImage()}}" alt="brand" width="81" />
                            </a>
                        </div>
                        <div class="agency dib">
                            <p class="fsb fs24">{{trans('www.base.label.agency')}}</p>
                            <a href="{{$agency->getLink()}}" class="db">
                                <img src="{{$agency->getImage()}}" alt="agency" width="81" />
                            </a>
                        </div>
                    </div>
                    <div class="country-ind dib">
                        @if(!empty($ad->country_id))
                            <div class="country">
                                <p class="fsb fs20 dib">{{trans('www.base.label.country')}}:</p>
                                <p class="dib fs18">{{$ad->country_ml->name}}</p>
                            </div>
                        @endif
                        @if($ad->category_ml != null)
                            <div class="industry">
                                <p class="fsb fs20 dib">{{trans('www.base.label.industry')}}:</p>
                                <p class="dib fs18">{{$ad->category_ml->title}}</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="description fs18 lh21">{{$ad->description}}</div>

                @if(!$credits->isEmpty() || !empty($ad->advertising))
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
                                            $personsStr .= '<a href="'.url_with_lng('/creative/'.$person->alias.'/'.$person->id).'" class="underline">'.$person->name.'</a>'.$person->separator.' ';
                                        }
                                        ?>
                                    @endforeach
                                    {!!mb_substr($personsStr, 0, -2)!!}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="tags">
                    @foreach($ad->tags as $value)
                        <div class="dib tag fb">#{{$value->tag}}</div>
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
                @include('pagination.default', ['pagination' => $similarAds])
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
</script>

@stop