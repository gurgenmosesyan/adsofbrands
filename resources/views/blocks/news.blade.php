<div id="news-box">
    @foreach($news as $value)<div class="news">
        <div class="img">
            <a href="{{url_with_lng('/news/'.$value->id)}}"><img src="{{$value->getImage()}}" width="357" /></a>
        </div>
        <div class="date fs14 tu">{{strftime('%b. %d, %Y', strtotime($value->created_at))}}</div>
        <h3 class="fb fs26">{{$value->title}}</h3>
        <p class="fs20">{{$value->description}}</p>
        </div>@endforeach
</div>