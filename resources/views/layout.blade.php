<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>{{$title.' - adsofbrands.com'}}</title>
    <link rel="shortcut icon" href="{{url('/favicon.ico')}}" type="image/x-icon" />
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
<script type="text/javascript">
    $main.baseUrl = '{{url('')}}';
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
        <div class="registration fr">
            <a href="{{url_with_lng('/registration')}}" class="underline fs16">{{trans('www.base.label.register')}}</a>
        </div>
        <div class="login fr">
            <a href="{{url_with_lng('/login')}}" class="btn">{{trans('www.base.label.sign_in')}}</a>
        </div>
        <div class="fr search">
            <a href="" class="db"></a>
        </div>
        <ul class="top-menu clearfix fr">
            <li class="fr"><a href="{{url_with_lng('/news', true)}}" class="fb fs18">{{trans('www.base.label.news')}}</a></li>
            <li class="dot fr"></li>
            <li class="fr"><a href="{{url_with_lng('/agencies', true)}}" class="fb fs18">{{trans('www.base.label.agencies')}}</a></li>
            <li class="dot fr"></li>
            <li class="fr"><a href="{{url_with_lng('/brands', true)}}" class="fb fs18">{{trans('www.base.label.brands')}}</a></li>
            <li class="dot fr"></li>
            <li class="fr"><a href="{{url_with_lng('/ads', true)}}" class="fb fs18">{{trans('www.base.label.ads')}}</a></li>
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

</div>

</body>
</html>