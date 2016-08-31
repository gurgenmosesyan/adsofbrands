<?php

Route::get('/language', ['uses' => 'LanguageController@index', 'as' => 'language']);

Route::group(['middleware' => ['web', 'front']], function() {

    Route::get('/', 'IndexController@index');

    Route::group(['prefix' => '{lngCode}'], function() {

        Route::get('/', 'IndexController@index');
        Route::get('/about', 'AboutController@index');
        Route::get('/vacancies', 'VacancyController@all');
        Route::get('/vacancies/{id}', 'VacancyController@index');

        Route::get('/booking', ['uses' => 'BookingController@booking1', 'as' => 'booking1']);

        Route::post('/api/contact', 'ApiController@contact');
        Route::post('/api/subscribe', 'ApiController@subscribe');

        Route::group(['middleware' => 'guest:all'], function() {
            Route::get('/sign-in', 'AccountController@login');
            Route::get('/register', 'AccountController@register');
            Route::get('/activation/{hash}', 'AccountController@activation');
            Route::get('/reset', 'AccountController@forgot');
            Route::get('/reset/{hash}', 'AccountController@reset');
            Route::post('/api/login', 'AccountApiController@login');
            Route::post('/api/register', 'AccountApiController@register');
            Route::post('/api/forgot', 'AccountApiController@forgot');
            Route::post('/api/reset', 'AccountApiController@reset');
        });

        Route::get('/brands/{alias}/{id}', 'BrandController@index');
        Route::get('/brands/{alias}/{id}/key-people', 'BrandController@creatives');
        Route::get('/brands/{alias}/{id}/awards', 'BrandController@awards');
        Route::get('/brands/{alias}/{id}/vacancies', 'BrandController@vacancies');
        Route::get('/brands/{alias}/{id}/news', 'BrandController@news');
        Route::get('/brands/{alias}/{id}/partner-agencies', 'BrandController@agencies');
        Route::get('/brands/{alias}/{id}/contacts', 'BrandController@contacts');

    });

});
