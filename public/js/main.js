'use strict';

var $trans = function() {
    return $trans.get.apply(arguments);
};
$trans.transMap = null;

$trans.get = function (key, paramData) {
    try {
        if ($trans.transMap  == null) {
            var locSettings = $locSettings || {};
            $trans.transMap = locSettings.trans || {};
        }
        if (typeof $trans.transMap[key] != "undefined") {
            key = $trans.transMap[key];
            if (paramData) {
                for (var i in paramData) {
                    if (paramData.hasOwnProperty(i)) {
                        key = key.replace("{"+i+"}",paramData[i]);
                    }
                }
            }
            return key;
        }
    }
    catch(e){}
    return key;
};

var $main = {};

$main.basePath = function(path) {
    return $main.baseUrl + path;
};

$main.includeGoogleMap = function() {
    var s = document.createElement("script");
    s.type = "text/javascript";
    s.src = "https://maps.googleapis.com/maps/api/js?v=3";
    $("head").append(s);
};

$main.initMap = function() {
    $main.map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        styles: [
            {"featureType":"poi","elementType":"all","stylers":[{"color":"#C9C9C9"},{"visibility":"on"}]},
            {"featureType":"landscape","elementType":"all","stylers":[{"color":"#E6E7E7"}]}
        ],
        center: {lat: 40.531119, lng: 44.703520}
    });
    new google.maps.Marker({
        position: {lat: 40.530749, lng: 44.694859},
        map: $main.map,
        icon : "/images/marker.png"
    });
};

$main.resetForm = function(form) {
    $('.form-error', form).text('').closest('.form-box').removeClass('has-error');
};

$main.showErrors = function(errors, form) {
    for (var i in errors) {
        $('#form-error-'+ i.replace(/\./g, '_'), form).text(errors[i]).closest('.form-box').addClass('has-error');
    }
};

$main.initContactForm = function() {
    $('#contact-form').submit(function() {
        var form = $(this);
        if (form.hasClass('sending')) {
            return false;
        }
        form.addClass('sending');
        $.ajax({
            type: 'post',
            url: form.attr('action'),
            data: form.serializeArray(),
            dataType: 'json',
            success: function(result) {
                $main.resetForm(form);
                if (result.status == 'OK') {
                    alert(result.data);
                } else {
                    $main.showErrors(result.errors, form);
                }
                form.removeClass('sending');
            }
        });
        return false;
    });
};

$main.initSlider = function() {
    $('#slider').owlCarousel({
        singleItem: true,
        autoPlay: 5900,
        navigation: true,
        navigationText: ['',''],
        pagination: true,
        paginationSpeed: 1200,
        slideSpeed: 1200,
        rewindSpeed: 2000
    });
};

$main.homeAccCarousel = function() {
    $('#home-acc').owlCarousel({
        autoPlay: true,
        navigation: true,
        navigationText: ['',''],
        pagination: true,
        slideSpeed: 700,
        itemsCustom: [
            [0, 1],
            [800, 2],
            [1200, 3]
        ]
    });
};

$main.initSubscribe = function() {
    $('.top-menu .subscribe a').on('click', function() {
        var subscribeBtn = $(this).parent('li');
        subscribeBtn.addClass('dpn');
        $('.top-menu .subscribe-box').removeClass('dpn');
        $(document).bind('click', function(e) {
            var clicked = $(e.target);
            if (!clicked.parents().is('#subscribe-form')) {
                $('.top-menu .subscribe-box').addClass('dpn');
                subscribeBtn.removeClass('dpn');
                $(document).unbind('click');
            }
        });
        return false;
    });
    $('#subscribe-form').submit(function() {
        var form = $(this);
        if (form.hasClass('sending')) {
            return false;
        }
        form.addClass('sending');
        $.ajax({
            type: 'post',
            url: form.attr('action'),
            data: form.serializeArray(),
            dataType: 'json',
            success: function(result) {
                if (result.status == 'OK' || result.status == 'EXIST') {
                    $('.subscribe-box').addClass('dpn');
                    $('.top-menu .subscribe').removeClass('dpn');
                    $('#subscribe-form input:text').val('');
                    alert(result.data);
                } else if (result.errors) {
                    alert(result.errors.email);
                } else {
                    alert('Error in subscribing');
                }
                form.removeClass('sending');
            }
        });
        return false;
    });
};

$(document).ready(function() {

    $main.initSubscribe();
});
