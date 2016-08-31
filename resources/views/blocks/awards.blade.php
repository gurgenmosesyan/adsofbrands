<?php
$awardsData = [];
foreach($awards as $key => $value) {
    if (!isset($awardsData[$value->year])) {
        $awardsData[$value->year] = [];
    }
    $awardsData[$value->year][] = $value;
}
?>
<div id="awards">
    <?php $i = 1; ?>
    @foreach($awardsData as $year => $data)<div class="award award-{{$i}}{{$i%2 == 0 ? ' award-right' : ''}}">
            <div class="year fl fs30">{{$year}}</div>
            <div class="info fl">
                @foreach($data as $value)
                    <div class="info-row">
                        <p class="fl fb fs18 title">{{$value->title}}</p>
                        <p class="fl fs20 category">{{$value->category}}</p>
                        <div class="cb"></div>
                    </div>
                @endforeach
            </div>
            <div class="cb"></div>
        </div><?php $i++; ?>@endforeach
</div>