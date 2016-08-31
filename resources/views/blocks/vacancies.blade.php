<?php
$jsTrans->addTrans([
    'www.base.label.show_more',
    'www.base.label.show_less',
]);
?>
<div id="vacancies">
    @foreach($vacancies as $key => $value)
        <div class="vacancy vacancy-{{$key}}">
            <h3 class="fsb fs24">{{$value->title}}</h3>
            <div class="left fl">
                <div class="html fs18 lh21">
                    <p>{{$value->description}}</p>
                    <div class="hidden dn">{!!$value->text!!}</div>
                </div>
            </div>
            <div class="fl">
                <a href="#" class="show-more db fb">{{trans('www.base.label.show_more')}}</a>
            </div>
            <div class="cb"></div>
        </div>
    @endforeach
</div>
<script type="text/javascript">
    $main.initVacancy();
</script>