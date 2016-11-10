@foreach($items as $value)<a href="{{$value->getLink()}}" class="item db">
    <span class="item-box db">
        <span class="img db">
            <img src="{{empty($value->image) ? url('/imgs/no-ava.png') : $value->getImage()}}" />
            <?php /* @if($ad)
                <span class="rating db fb fs18">{{number_format($value->rating, 1)}}</span>
            @endif */ ?>
        </span>
        <span class="title db fb fs14">{{$value->title}}</span>
        @if($ad)
            <span class="db bottom clearfix">
                <?php /* <span class="views-count fl fb">{{$value->views_count}}</span> */ ?>
                <span class="comment fr fb">
                    {{number_format($value->rating, 1)}}
                </span>
            </span>
        @endif
    </span>
</a>@endforeach