var $branch = $.extend(true, {}, $main);
$branch.listPath = '/admpanel/branch';
$branch.type = null;
$branch.resetType = true;

$branch.initSearchPage = function() {
    $branch.listColumns = [
        {data: 'id'}
    ];
    if ($branch.isAdmin) {
        $branch.listColumns.push({data: 'type'});
        $branch.listColumns.push({data: 'brand_agency', sortable: false});
    }
    $branch.listColumns = $branch.listColumns.concat([
        {data: 'title'}
    ]);
    $branch.initSearch();
};

$branch.initType = function() {
    var typeId = $('#type-id');
    if ($branch.saveMode == 'edit') {
        $branch.resetType = false;
    }
    $('#type').change(function() {
        if ($branch.resetType) {
            typeId.find('input').val('');
            typeId.find('.icon-remove').hide();
        }
        $branch.resetType = true;
        if ($(this).val() == 'brand') {
            $branch.type = 'brand';
            typeId.removeClass('dn').find('label').text($trans.get('admin.base.label.brand'));
        } else if ($(this).val() == 'agency') {
            $branch.type = 'agency';
            typeId.removeClass('dn').find('label').text($trans.get('admin.base.label.agency'));
        } else {
            $branch.type = null;
            typeId.addClass('dn');
        }
    }).change();
};

$branch.initSelectBox = function() {
    var typeSearch = $('#type-search');
    typeSearch.searchSelectBox({
        source : function (request, response) {
            typeSearch.loading();
            $.ajax({
                type :'post',
                url	 : '/admpanel/'+$branch.type,
                data : {
                    search : {
                        value : request.term
                    },
                    _token : $main.token
                },
                dataType :'json',
                success	 : function (json) {
                    typeSearch.removeLoading();
                    if (json.recordsTotal > 0) {
                        response($.map(json.data , function(item) {
                            item.label = item.title;
                            return item;
                        }));
                    }
                }
            });
        }
    });
};

//map
$branch.initMarker = function(position, address) {
    if ($branch.marker) {
        $branch.marker.setPosition(position);
    } else {
        $branch.marker = new google.maps.Marker({position: position, map: $branch.map, draggable: true});
        google.maps.event.addListener($branch.marker, 'dragend', function (event) {
            $('#lat-input').val(event.latLng.lat());
            $('#lng-input').val(event.latLng.lng());
        });
    }
    $('#lat-input').val(position.lat());
    $('#lng-input').val(position.lng());
    if (address) {
        $('#pac-input').val(address);
    }
};

$branch.geocodePosition = function(pos) {
    $branch.geocoder.geocode({
        latLng: pos
    }, function(responses) {
        if (responses && responses.length > 0) {
            $branch.initMarker(pos, responses[0].formatted_address);
        } else {
            $branch.initMarker(pos);
        }
    });
};

$branch.autoCompleteCallback = function() {

    var place = $branch.autocomplete.getPlace();

    var zoom;
    if (place.geometry.viewport) {
        //$branch.map.fitBounds(place.geometry.viewport);
        zoom = 12;
    } else {
        zoom = 15;
    }
    var position = place.geometry.location;
    $branch.map.setCenter(position);
    $branch.map.setZoom(zoom);
    $branch.initMarker(position);
};

$branch.initMap = function() {
    function initialize() {
        var latLng = new google.maps.LatLng(40.207521, 44.418573);
        var mapOptions = {
            center: latLng,
            zoom: 10
        };
        $branch.map = new google.maps.Map(document.getElementById('map'), mapOptions);
        /*$branch.map.addListener('zoom_changed', function() {
            $('#map-zoom').val($branch.map.getZoom());
        });*/
        $branch.geocoder = new google.maps.Geocoder();

        var input = document.getElementById('pac-input');
        $branch.autocomplete = new google.maps.places.Autocomplete(input);
        //$branch.autocomplete.bindTo('bounds', $branch.map);
        google.maps.event.addDomListener(input, 'keydown', function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
            }
        });
        google.maps.event.addListener($branch.autocomplete, 'place_changed', $branch.autoCompleteCallback);
        google.maps.event.addListener($branch.map, 'click', function(event) {
            $branch.geocodePosition(event.latLng);
            if ($branch.map.getZoom() < 14) {
                $branch.map.setCenter(event.latLng);
                $branch.map.setZoom(15);
            }
        });
        if ($branch.lat && $branch.lng) {
            var position = new google.maps.LatLng($branch.lat, $branch.lng);
            $branch.initMarker(position);
            $branch.map.setCenter(position);
            var zoom = $branch.mapZoom ? $branch.mapZoom : 15;
            $branch.map.setZoom(zoom);
        }
    }
    google.maps.event.addDomListener(window, 'load', initialize);
};

$branch.initEditPage = function() {

    $branch.initForm();

    $branch.initType();

    $branch.initSelectBox();

    $branch.initMap();
};

$branch.init();
