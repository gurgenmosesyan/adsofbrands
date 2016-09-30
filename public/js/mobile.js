'use strict';

$.cookie = function(name, value, options) {
    options = options || {};
    if (value === null) {
        value = '';
        options.expires = -1;
    }
    var expires = '';
    if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
        var date;
        if (typeof options.expires == 'number') {
            date = new Date();
            date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
        } else {
            date = options.expires;
        }
        expires = '; expires=' + date.toUTCString();
    }
    var path = options.path ? '; path=' + (options.path) : '';
    var domain = options.domain ? '; domain=' + (options.domain) : '';
    var secure = options.secure ? '; secure' : '';
    document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
};

var $mobile = {};

$mobile.initBurger = function() {
    var header = $('#header'),
        mobileMenu = header.find('.top-menu'),
        login = header.find('.login a'),
        register = header.find('.registration a');

    mobileMenu.children().each(function(i,li){mobileMenu.prepend(li)});

    mobileMenu.append('<li class="login-menu"><a href="'+login.attr('href')+'" class="fs18">'+login.text()+'</a></li>');
    if (register.length > 0) {
        mobileMenu.append('<li><a href="'+register.attr('href')+'" class="fs18">'+register.text()+'</a></li>');
    }
    mobileMenu.append('<li><a href="#" class="desktop fs18">'+$trans.get('www.desktop.version')+'</a></li>');
    $('#search-form').removeClass('dn').appendTo(mobileMenu);

    mobileMenu.find('.desktop').on('click', function() {
        $.cookie("origin", "1", {
            expires: 0,
            path: "/"
        });
        document.location = "/";
        return false;
    });

    mobileMenu.appendTo('#header');

    var burger = '<a href="#" id="burger" class="db">'+
                        '<span class="burger1 db"></span>'+
                        '<span class="burger2 db"></span>'+
                        '<span class="burger3 db"></span>'+
                    '</a>';
    burger = $(burger);

    burger.on('click', function() {
        $(this).toggleClass('open');
        mobileMenu.stop().slideToggle();
        return false;
    });
    header.prepend(burger);
};

$mobile.init = function() {

    $mobile.initBurger();

    setTimeout(function() {
        if ($main.map) {
            $main.map.setOptions({draggable: false});
        }
    }, 1500);
};

$(document).ready(function() {
    $mobile.init();
});
