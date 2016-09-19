<?php
use App\Models\FooterMenu\FooterMenuManager;

$footerMenu = FooterMenuManager::get();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>{{$title.' - adsofbrands.com'}}</title>
    <link rel="icon" href="{{url('/favicon.png')}}" />
    <?php
    use App\Core\Helpers\UserAgent;

    $head->appendMainStyle('/css/main.css');
    $head->appendMainStyle('/css/media.css');

    $head->appendMainScript('/js/jquery-2.1.4.min.js');
    $head->appendMainScript('/js/main.js');

    $ua = new UserAgent();
    if ($ua->isIPhone() || $ua->isAndroidMobile() || $ua->isWinPhone()) {
        $head->appendMainStyle('/css/mobile.css');
        $head->appendMainScript('/js/mobile.js');
    }

    $head->renderStyles();
    $head->renderScripts();
    ?>
</head>
<body>
@if(isset($fbSDK))
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=176429685847374";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
@endif
<script type="text/javascript">
    $main.baseUrl = '{{url_with_lng('')}}';
    $main.token = '{{csrf_token()}}';
    var $locSettings = {"trans": <?php echo json_encode($jsTrans->getTrans()); ?>};
</script>

<div id="page">

<div id="header">
    <div class="fl">
        <a href="{{url_with_lng('', true)}}" class="logo db comfortaa-b fs24">
            <span class="comfortaa-b yel">ads</span> <span class="comfortaa-l">of</span> brands
        </a>
    </div>
    <div class="fr">
        @if(Auth::guard('brand')->check() || Auth::guard('agency')->check() || Auth::guard('creative')->check())
            <?php
            if (Auth::guard('brand')->check()) {
                $user = Auth::guard('brand')->user();
                $link = route('admin_brand_edit', $user->id);
            } else if (Auth::guard('agency')->check()) {
                $user = Auth::guard('agency')->user();
                $link = route('admin_agency_edit', $user->id);
            } else {
                $user = Auth::guard('creative')->user();
                $link = route('admin_creative_edit', $user->id);
            }
            ?>
            <div class="login fr">
                <a href="{{$link}}" class="btn">{{trans('www.base.label.profile')}}</a>
            </div>
        @else
            <div class="registration fr">
                <a href="{{url_with_lng('/register')}}" class="underline fs16">{{trans('www.base.label.register')}}</a>
            </div>
            <div class="login fr">
                <a href="{{url_with_lng('/sign-in')}}" class="btn">{{trans('www.base.label.sign_in')}}</a>
            </div>
        @endif
        <div class="fr search">
            <a href="#" id="search-icon" class="db"></a>
            <form id="search-form" action="{{url_with_lng('/search')}}" method="get"{!!empty($q) ? ' class="dn"' : ''!!} autocomplete="off">
                <input type="text" name="q" class="fs16" value="{{$q or ''}}" /><input type="submit" value="" />
            </form>
        </div>
        <ul class="top-menu clearfix fr">
            <li class="fr{{isset($pageMenu) && $pageMenu == 'news' ? ' active' : ''}}"><a href="{{url_with_lng('/news', true)}}" class="fb fs18">{{trans('www.base.label.news')}}</a></li>
            <li class="dot fr"></li>
            <li class="fr{{isset($pageMenu) && $pageMenu == 'agencies' ? ' active' : ''}}"><a href="{{url_with_lng('/agencies', true)}}" class="fb fs18">{{trans('www.base.label.agencies')}}</a></li>
            <li class="dot fr"></li>
            <li class="fr{{isset($pageMenu) && $pageMenu == 'brands' ? ' active' : ''}}"><a href="{{url_with_lng('/brands', true)}}" class="fb fs18">{{trans('www.base.label.brands')}}</a></li>
            <li class="dot fr"></li>
            <li class="fr{{isset($pageMenu) && $pageMenu == 'ads' ? ' active' : ''}}"><a href="{{url_with_lng('/ads', true)}}" class="fb fs18">{{trans('www.base.label.ads')}}</a></li>
        </ul>
        <div class="cb"></div>
    </div>
    <div class="cb"></div>
</div>

<div id="content">
@yield('content')
</div>

</div>
<div id="footer">
    <div class="footer-main">
        <div class="page">

            <div class="footer-right fr">
                <div class="subscribe">
                    <h3 class="fb fs26">{{trans('www.subscribe.title')}}</h3>
                    <form id="subscribe-form" action="{{url_with_lng('/api/subscribe')}}" method="post">
                        <input type="text" name="email" class="fs18" placeholder="{{trans('www.subscribe.placeholder')}}" /><input type="submit" class="fb fs18" value="{{trans('www.subscribe.submit')}}" />
                        {{csrf_field()}}
                        <div class="info"></div>
                    </form>
                </div>
                <div class="social-box">
                    <a href="{{trans('www.social.link.fb')}}" class="facebook social db fl" target="_blank"></a>
                    <a href="{{trans('www.social.link.twitter')}}" class="twitter social db fl" target="_blank"></a>
                    <a href="{{trans('www.social.link.google')}}" class="google social db fl" target="_blank"></a>
                    <a href="{{trans('www.social.link.youtube')}}" class="youtube social db fl" target="_blank"></a>
                    <div class="cb"></div>
                </div>
            </div>
            <div class="menu">
                <?php $separator = intval(ceil($footerMenu->count() / 4)); ?>
                <ul class="menu-col">
                    @foreach($footerMenu->slice(0, $separator) as $value)
                        @if($value->isStatic())
                            <li><a href="{{url_with_lng('/'.$value->alias)}}" class="fs18">{{$value->title}}</a></li>
                        @else
                            <li><a href="{{url_with_lng('/page/'.$value->alias)}}" class="fs18">{{$value->title}}</a></li>
                        @endif
                    @endforeach
                </ul>
                <ul class="menu-col">
                    @foreach($footerMenu->slice($separator, $separator) as $value)
                        @if($value->isStatic())
                            <li><a href="{{url_with_lng('/'.$value->alias)}}" class="fs18">{{$value->title}}</a></li>
                        @else
                            <li><a href="{{url_with_lng('/page/'.$value->alias)}}" class="fs18">{{$value->title}}</a></li>
                        @endif
                    @endforeach
                </ul>
                <ul class="menu-col">
                    @foreach($footerMenu->slice($separator*2, $separator) as $value)
                        @if($value->isStatic())
                            <li><a href="{{url_with_lng('/'.$value->alias)}}" class="fs18">{{$value->title}}</a></li>
                        @else
                            <li><a href="{{url_with_lng('/page/'.$value->alias)}}" class="fs18">{{$value->title}}</a></li>
                        @endif
                    @endforeach
                </ul>
                <ul class="menu-col last">
                    @foreach($footerMenu->slice($separator*3) as $value)
                        @if($value->isStatic())
                            <li><a href="{{url_with_lng('/'.$value->alias)}}" class="fs18">{{$value->title}}</a></li>
                        @else
                            <li><a href="{{url_with_lng('/page/'.$value->alias)}}" class="fs18">{{$value->title}}</a></li>
                        @endif
                    @endforeach
                </ul>
                <div class="cb"></div>
            </div>
            <div class="cb"></div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="page">
            <p class="fl fs14">{{trans('www.copyright.text')}}</p>
            <p class="fr fs14 privacy"><a href="{{url_with_lng('/page/privacy-policy')}}" class="underline">{{trans('www.base.label.privacy_policy')}}</a></p>
            <p class="fr fs14"><a href="{{url_with_lng('/page/terms-of-use')}}" class="underline">{{trans('www.base.label.terms_of_use')}}</a></p>
        </div>
    </div>
</div>

@if(isset($shareBox))
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55390ccd2ae53cd5"></script>
@endif
</body>
</html>