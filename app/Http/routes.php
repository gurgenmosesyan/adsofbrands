<?php

Route::get('/language', ['uses' => 'LanguageController@index', 'as' => 'language']);

Route::group(['middleware' => ['web', 'front']], function() {

    Route::get('/', 'IndexController@index');

    Route::group(['prefix' => '{lngCode}'], function() {

        Route::get('/', 'IndexController@index');
        Route::get('/about', 'AboutController@index');
        Route::get('/vacancies', 'VacancyController@all');
        Route::get('/vacancies/{id}', 'VacancyController@index');
        Route::get('/accommodations/{id}', 'AccommodationController@index');
        Route::get('/special-offers', 'OfferController@all');
        Route::get('/hotel-facilities', 'FacilityController@all');
        Route::get('/hotel-facilities/{id}', 'FacilityController@index');
        Route::get('/meeting-and-events', 'EventController@all');

        Route::get('/booking', ['uses' => 'BookingController@booking1', 'as' => 'booking1']);
        Route::any('/booking/rooms', ['uses' => 'BookingController@booking2', 'as' => 'booking2']);
        Route::any('/booking/info', ['uses' => 'BookingController@booking3', 'as' => 'booking3']);
        Route::post('/api/booking/info', ['uses' => 'BookingApiController@booking3', 'as' => 'booking3_api']);
        Route::get('/booking/payment', ['uses' => 'BookingController@booking4', 'as' => 'booking4']);
        Route::any('/booking/cash', ['uses' => 'BookingController@cash', 'as' => 'booking_cash']);
        Route::any('/booking/ameria', ['uses' => 'BookingController@ameria', 'as' => 'booking_ameria']);
        Route::any('/booking/ameria/result', ['uses' => 'BookingController@ameriaBack', 'as' => 'booking_ameria_back']);

        Route::post('/api/contact', 'ApiController@contact');
        Route::post('/api/subscribe', 'ApiController@subscribe');
    });

});
