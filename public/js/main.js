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

$main.initClock = function() {
    function runClock(date) {
        var m = date.getMinutes();
        var minute = (m * 6) + 90;
        var hour = ((date.getHours() % 12 ) * 30) + (m / 2)  + 90;
        $('#hour').css({
            '-webkit-transform': 'rotate(' + hour + 'deg)',
            '-moz-transform': 'rotate(' + hour + 'deg)',
            '-ms-transform': 'rotate(' + hour + 'deg)',
            '-o-transform': 'rotate(' + hour + 'deg)',
            'transform': 'rotate(' + hour + 'deg)'
        });
        $('#minute').css({
            '-webkit-transform': 'rotate(' + minute + 'deg)',
            '-moz-transform': 'rotate(' + minute + 'deg)',
            '-ms-transform': 'rotate(' + minute + 'deg)',
            '-o-transform': 'rotate(' + minute + 'deg)',
            'transform': 'rotate(' + minute + 'deg)'
        });
    }
    var time = $main.time*1000;
    var date = new Date(time);
    runClock(date);
    setInterval(function() {
        time += 15000;
        date = new Date(time);
        runClock(date);
    }, 15000);
};

$main.initCalendar = function() {
    var fromObj = $('#from'),
        fromMinDate = fromObj.val(),
        toObj = $('#to'),
        toMinDate = toObj.val();
    fromObj.datepicker({
        defaultDate: '+1w',
        altField: '#from-hidden',
        altFormat: 'yy-mm-dd',
        minDate: fromMinDate,
        dateFormat: 'dd/mm/yy',
        numberOfMonths: 2,
        onClose: function(selectedDate, dateObj) {
            var d = new Date((dateObj.selectedMonth+1)+'/'+dateObj.selectedDay+'/'+dateObj.selectedYear);
            var time = d.getTime() + 86400000;
            d = new Date(time);
            var minDate = d.getDate()+'/'+(parseInt(d.getMonth())+1)+'/'+d.getFullYear();
            $('#to').datepicker('option', 'minDate', minDate);
        }
    });
    toObj.datepicker({
        defaultDate: '+1w',
        altField: '#to-hidden',
        altFormat: 'yy-mm-dd',
        minDate: toMinDate,
        dateFormat: 'dd/mm/yy',
        numberOfMonths: 2
    });
};

$main.animateToContact = function() {
    $('html, body').animate({
        scrollTop: $('#contact').offset().top
    }, 700);
};

$main.initContactLink = function() {
    var hash = document.location.hash.substr(1);
    if (hash == 'contacts') {
        $main.animateToContact();
    }
    $('#contact-link').on('click', function() {
        if ($main.homepage) {
            document.location.hash = 'contacts';
            $main.animateToContact();
            return false;
        }
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

$main.initGuests = function() {
    $('#guests-car').owlCarousel({
        autoPlay: true,
        navigation: true,
        navigationText: ['',''],
        pagination: true,
        slideSpeed: 700,
        itemsCustom: [
            [0, 1],
            [500, 2],
            [775, 3],
            [1000, 4]
        ]
    });
};

$main.initAccCarousel = function() {
    $('#acc-car').owlCarousel({
        autoPlay: true,
        navigation: true,
        navigationText: ['',''],
        pagination: true,
        slideSpeed: 700,
        itemsCustom: [
            [0, 1],
            [680, 2],
            [950, 3],
            [1230, 4]
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

$main.initAccSubMenu = function() {
    $('#acc-top-menu .acc-link').on('click', function() {
        var subMenu = $('#acc-sub-menu');
        subMenu.stop().slideToggle();
        $(document).bind('click', function(e) {
            var clicked = $(e.target);
            if (!clicked.parents().is('#acc-sub-menu')) {
                subMenu.stop().slideToggle();
                $(document).unbind('click');
            }
        });
        return false;
    });
};

$main.numberFormat = function(number) {
    number = number.toString();
    number = number.split('').reverse().join('');
    var n = '';
    for (var i = 0, l = number.length; i < l; i++) {
        n += number[i];
        if ((i%3 == 2) && (i != l-1)) {
            n += '.';
        }
    }
    return n.split('').reverse().join('');
};

$main.initSelect = function(obj) {
    obj.find('select').change(function() {
        var self = $(this),
            text = self.find('option:selected').text();
        self.prev('.select-title').text($.trim(text));

        var quantity = self.val(),
            td = self.closest('td'),
            detailRow = $('.detail-'+self.data('id'));
        if (quantity) {
            var price = parseInt(quantity) * parseInt(td.prev('td').data('price'));
            td.next('td').data('rate', price).html($main.numberFormat(price));
            if (self.hasClass('main-select')) {
                detailRow.removeClass('detail-dn');
            }
        } else {
            td.next('td').data('rate', 0).html('<img src="/images/booking-rate.png" />');
            if (self.hasClass('main-select')) {
                detailRow.addClass('detail-dn');
                detailRow.find('select').each(function() {
                    $(this).val('').change();
                });
            }
        }
        $main.setTotal();

    }).change();
};

$main.setTotal = function() {
    var totalPrice = 0;
    $('#booking-2').find('td.rate').each(function() {
        totalPrice += $(this).data('rate');
    });
    $('#total').data('price', totalPrice).text($main.numberFormat(totalPrice));
};

$main.initFancybox = function() {
    $('#booking-2').find('.img-box a').fancybox({
        prevEffect: 'fade',
        nextEffect: 'fade'
    });
};

$main.initDetails = function() {
    var bookingBox = $('#booking-2');
    bookingBox.find('.details').on('click', function() {
        var details = bookingBox.find('.details-'+$(this).data('id'));
        details.toggleClass('dpn');
        return false;
    });
};

$main.initBooking3Form = function() {
    $('#booking-3-form').submit(function() {
        var form = $(this);
        if (form.hasClass('loading')) {
            return false;
        }
        form.addClass('loading');
        $.ajax({
            type: 'post',
            url: form.attr('action'),
            data: form.serializeArray(),
            dataType: 'json',
            success: function(result) {
                $main.resetForm(form);
                if (result.status == 'OK') {
                    document.location.href = result.data.link;
                } else {
                    $main.showErrors(result.errors, form);
                    $('html, body').animate({
                        scrollTop: $('.has-error:first', form).offset().top - 20
                    }, 500);
                }
                form.removeClass('loading');
            }
        });
        return false;
    });
};

$(document).ready(function() {

    $main.initClock();

    $main.initCalendar();

    $main.initContactLink();

    $main.initSubscribe();

    $main.initAccSubMenu();

    $main.initSelect($('#booking-2'));
    $main.initSelect($('#booking-3'));

    $main.initDetails();

    $main.initBooking3Form();
});
