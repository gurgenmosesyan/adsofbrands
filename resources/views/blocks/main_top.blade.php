@if(empty($model->cover))
    <div class="empty-cover">
        <div class="img-box tc">
            <img src="{{url('/imgs/no-photo.png')}}" />
            <p class="fsb">{{trans('www.base.label.no_photo')}}</p>
        </div>
        <div class="dot"></div>
    </div>
@else
    <div class="cover" style="background-image: url('{{$model->getCover()}}');"></div>
@endif
<div class="logo-box fl">
    <div class="logo"><img src="{{$model->getImage()}}" /></div>
</div>
<div class="main-title fl">
    <h1 class="fb fs32">{{$model->title}}</h1>
    <p>{{$model->sub_title}}</p>
</div>
<div class="phone-box fl fs18">
    @if(!empty($model->phone))
        <p class="contact-info phone">{{$model->phone}}</p>
    @endif
    @if(!empty($model->link))
        <p class="contact-info link"><a href="{{$model->link}}" class="underline" target="_blank">{{$model->link}}</a></p>
    @endif
</div>
@if(!empty($model->fb) || !empty($model->twitter) || !empty($model->google) || !empty($model->youtube) || !empty($model->linkedin) || !empty($model->vimeo))
    <div class="social-pages fl fs18">
        <p>{{trans('www.social_pages.title')}}</p>
        <ul>
            @if(!empty($model->fb))
                <li><a href="{{$model->fb}}" class="db facebook" target="_blank"></a></li>
            @endif
            @if(!empty($model->twitter))
                <li><a href="{{$model->twitter}}" class="db twitter" target="_blank"></a></li>
            @endif
            @if(!empty($model->google))
                <li><a href="{{$model->google}}" class="db google" target="_blank"></a></li>
            @endif
            @if(!empty($model->youtube))
                <li><a href="{{$model->youtube}}" class="db youtube" target="_blank"></a></li>
            @endif
            <?php /*
            @if(!empty($model->linkedin))
                <li><a href="{{$model->linkedin}}" class="db linkedin" target="_blank"></a></li>
            @endif
            @if(!empty($model->vimeo))
                <li><a href="{{$model->vimeo}}" class="db vimeo" target="_blank"></a></li>
            @endif */ ?>
        </ul>
    </div>
@endif
<div class="cb"></div>