<div id="news-box">
    @foreach($news as $value)<div class="news">
        <div class="img">
            <a href="{{$value->getLink()}}"><img src="{{$value->getImage()}}" width="357" /></a>
        </div>
        <div class="date fs14 tu">{{strftime('%b. %d, %Y', strtotime($value->created_at))}}</div>
        <h3 class="fb fs26">
            <a href="{{$value->getLink()}}">{{$value->title}}</a>
        </h3>
        <p class="fs20">{{$value->description}}</p>
        </div>@endforeach
    @if(!isset($notPaginate))
        @include('pagination.default', ['pagination' => $news, 'notPaginate' => true])
    @endif
</div>