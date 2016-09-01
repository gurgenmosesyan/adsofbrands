<div class="car-block">
    <div class="page">
        <h3 class="fb tu fs38">{{$title}}</h3>
        <p class="fs18">{{$text}}</p>
    </div>
    <div class="car-box">
        <div class="line"></div>
        <div class="car-content">
            <div class="page">
                <div class="items-car owl-carousel">
                    @include('blocks.items', ['items' => $items, 'itemRating' => $itemRating])
                </div>
                <a href="{{$link}}" class="see-all btn fb">{{trans('www.base.label.see_all')}}</a>
            </div>
        </div>
    </div>
</div>