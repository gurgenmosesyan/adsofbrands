@foreach($items as $value)<a href="{{$value->getLink()}}" class="item db">
        <span class="img db">
            <img src="{{$value->getImage()}}" />
            @if($itemRating)
                <span class="rating db fb fs18">{{number_format($value->rating, 1)}}</span>
            @endif
        </span>
        <span class="title db fb fs14">{{$value->title}}</span>
        <span class="db bottom clearfix">
            <span class="views-count fl fb">{{$value->views_count}}</span>
            <span class="comment fr fb">
                {{$value->comments_count > 999  ?'999+' : $value->comments_count}}
            </span>
        </span>
    </a>@endforeach