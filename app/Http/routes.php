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
    });

});
