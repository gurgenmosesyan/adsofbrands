<div id="branches">
    <div class="left fl">
        @foreach($branches as $value)
            <div class="branch">
                <h3 class="fsb fs24">{{$value->title}}</h3>
                <p class="contact-info phone fs18">{{$value->phone}}</p>
                <p class="contact-info address fs18">{{$value->address}}</p>
                <p class="contact-info email fs18"><a href="mailto:{{$value->email}}" class="underline">{{$value->email}}</a></p>
            </div>
        @endforeach
    </div>
    <div class="right fr">
        <div id="map"></div>
    </div>
    <div class="cb"></div>
</div>
<script type="text/javascript">
    $main.includeGoogleMap();
    $main.coordinates = <?php echo json_encode($branches); ?>;
    setTimeout(function() {
        $main.initMap();
    }, 1000);
</script>