var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.styles(
        [
            'main.css',
            'media.css'
        ],
        'public/css/main.css'
    ).
        styles(
        [
            'owl.carousel.css'
        ],
        'public/css/carousel.css'
    ).
        styles(
        [
            'jquery.mCustomScrollbar.css'
        ],
        'public/css/scrollbar.css'
    ).
        scripts(
        [
            'jquery-2.1.4.min.js',
            'main.js',
            'account.js'
        ],
        'public/js/main.js'
    ).
        scripts(
        [
            'owl.carousel.min.js'
        ],
        'public/js/carousel.js'
    ).
        scripts(
        [
            'jquery.mCustomScrollbar.concat.min.js'
        ],
        'public/js/scrollbar.js'
    ).
        version(
        [
            'css/main.css',
            'css/carousel.css',
            'css/scrollbar.css',
            'js/main.js',
            'js/carousel.js',
            'js/scrollbar.js'
        ]
    );
});
