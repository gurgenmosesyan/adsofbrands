<?php

$params = [
    'middleware' => ['web', 'auth:admin', 'language'],
    'prefix' => 'admpanel',
    'namespace' => 'Admin'
];

Route::group($params, function () {

    Route::get('/', function() {
        return redirect()->route('admin_homepage');
    });

    Route::get('/background', ['uses' => 'BackgroundController@edit', 'as' => 'admin_background']);
    Route::post('/background', ['uses' => 'BackgroundController@update', 'as' => 'admin_background_update']);

    Route::get('/homepage', ['uses' => 'HomepageController@edit', 'as' => 'admin_homepage']);
    Route::post('/homepage', ['uses' => 'HomepageController@update', 'as' => 'admin_homepage_update']);

    Route::get('/about', ['uses' => 'AboutController@edit', 'as' => 'admin_about']);
    Route::post('/about', ['uses' => 'AboutController@update', 'as' => 'admin_about_update']);

    Route::get('/guest', ['uses' => 'GuestController@table', 'as' => 'admin_guest_table']);
    Route::get('/guest/create', ['uses' => 'GuestController@create', 'as' => 'admin_guest_create']);
    Route::get('/guest/edit/{id}', ['uses' => 'GuestController@edit', 'as' => 'admin_guest_edit']);
    Route::post('/guest', ['uses' => 'GuestController@index', 'as' => 'admin_guest_index']);
    Route::post('/guest/store', ['uses' => 'GuestController@store', 'as' => 'admin_guest_store']);
    Route::post('/guest/update/{id}', ['uses' => 'GuestController@update', 'as' => 'admin_guest_update']);
    Route::post('/guest/delete/{id}', ['uses' => 'GuestController@delete', 'as' => 'admin_guest_delete']);

    Route::get('/partner', ['uses' => 'PartnerController@table', 'as' => 'admin_partner_table']);
    Route::get('/partner/create', ['uses' => 'PartnerController@create', 'as' => 'admin_partner_create']);
    Route::get('/partner/edit/{id}', ['uses' => 'PartnerController@edit', 'as' => 'admin_partner_edit']);
    Route::post('/partner', ['uses' => 'PartnerController@index', 'as' => 'admin_partner_index']);
    Route::post('/partner/store', ['uses' => 'PartnerController@store', 'as' => 'admin_partner_store']);
    Route::post('/partner/update/{id}', ['uses' => 'PartnerController@update', 'as' => 'admin_partner_update']);
    Route::post('/partner/delete/{id}', ['uses' => 'PartnerController@delete', 'as' => 'admin_partner_delete']);

    Route::get('/accommodation', ['uses' => 'AccommodationController@table', 'as' => 'admin_accommodation_table']);
    Route::get('/accommodation/create', ['uses' => 'AccommodationController@create', 'as' => 'admin_accommodation_create']);
    Route::get('/accommodation/edit/{id}', ['uses' => 'AccommodationController@edit', 'as' => 'admin_accommodation_edit']);
    Route::post('/accommodation', ['uses' => 'AccommodationController@index', 'as' => 'admin_accommodation_index']);
    Route::post('/accommodation/store', ['uses' => 'AccommodationController@store', 'as' => 'admin_accommodation_store']);
    Route::post('/accommodation/update/{id}', ['uses' => 'AccommodationController@update', 'as' => 'admin_accommodation_update']);
    Route::post('/accommodation/delete/{id}', ['uses' => 'AccommodationController@delete', 'as' => 'admin_accommodation_delete']);

    Route::get('/offer', ['uses' => 'OfferController@table', 'as' => 'admin_offer_table']);
    Route::get('/offer/create', ['uses' => 'OfferController@create', 'as' => 'admin_offer_create']);
    Route::get('/offer/edit/{id}', ['uses' => 'OfferController@edit', 'as' => 'admin_offer_edit']);
    Route::post('/offer', ['uses' => 'OfferController@index', 'as' => 'admin_offer_index']);
    Route::post('/offer/store', ['uses' => 'OfferController@store', 'as' => 'admin_offer_store']);
    Route::post('/offer/update/{id}', ['uses' => 'OfferController@update', 'as' => 'admin_offer_update']);
    Route::post('/offer/delete/{id}', ['uses' => 'OfferController@delete', 'as' => 'admin_offer_delete']);

    Route::get('/offer/text', ['uses' => 'OfferController@text', 'as' => 'admin_offer_text']);
    Route::post('/offer/text', ['uses' => 'OfferController@updateText', 'as' => 'admin_offer_text_update']);

    Route::get('/facility', ['uses' => 'FacilityController@table', 'as' => 'admin_facility_table']);
    Route::get('/facility/create', ['uses' => 'FacilityController@create', 'as' => 'admin_facility_create']);
    Route::get('/facility/edit/{id}', ['uses' => 'FacilityController@edit', 'as' => 'admin_facility_edit']);
    Route::post('/facility', ['uses' => 'FacilityController@index', 'as' => 'admin_facility_index']);
    Route::post('/facility/store', ['uses' => 'FacilityController@store', 'as' => 'admin_facility_store']);
    Route::post('/facility/update/{id}', ['uses' => 'FacilityController@update', 'as' => 'admin_facility_update']);
    Route::post('/facility/delete/{id}', ['uses' => 'FacilityController@delete', 'as' => 'admin_facility_delete']);

    Route::get('/offer/slider', ['uses' => 'OfferSliderController@table', 'as' => 'admin_offer_slider_table']);
    Route::get('/offer/slider/create', ['uses' => 'OfferSliderController@create', 'as' => 'admin_offer_slider_create']);
    Route::get('/offer/slider/edit/{id}', ['uses' => 'OfferSliderController@edit', 'as' => 'admin_offer_slider_edit']);
    Route::post('/offer/slider', ['uses' => 'OfferSliderController@index', 'as' => 'admin_offer_slider_index']);
    Route::post('/offer/slider/store', ['uses' => 'OfferSliderController@store', 'as' => 'admin_offer_slider_store']);
    Route::post('/offer/slider/update/{id}', ['uses' => 'OfferSliderController@update', 'as' => 'admin_offer_slider_update']);
    Route::post('/offer/slider/delete/{id}', ['uses' => 'OfferSliderController@delete', 'as' => 'admin_offer_slider_delete']);

    Route::get('/facility/slider', ['uses' => 'FacilitySliderController@table', 'as' => 'admin_facility_slider_table']);
    Route::get('/facility/slider/create', ['uses' => 'FacilitySliderController@create', 'as' => 'admin_facility_slider_create']);
    Route::get('/facility/slider/edit/{id}', ['uses' => 'FacilitySliderController@edit', 'as' => 'admin_facility_slider_edit']);
    Route::post('/facility/slider', ['uses' => 'FacilitySliderController@index', 'as' => 'admin_facility_slider_index']);
    Route::post('/facility/slider/store', ['uses' => 'FacilitySliderController@store', 'as' => 'admin_facility_slider_store']);
    Route::post('/facility/slider/update/{id}', ['uses' => 'FacilitySliderController@update', 'as' => 'admin_facility_slider_update']);
    Route::post('/facility/slider/delete/{id}', ['uses' => 'FacilitySliderController@delete', 'as' => 'admin_facility_slider_delete']);

    Route::get('/event', ['uses' => 'EventController@table', 'as' => 'admin_event_table']);
    Route::get('/event/create', ['uses' => 'EventController@create', 'as' => 'admin_event_create']);
    Route::get('/event/edit/{id}', ['uses' => 'EventController@edit', 'as' => 'admin_event_edit']);
    Route::post('/event', ['uses' => 'EventController@index', 'as' => 'admin_event_index']);
    Route::post('/event/store', ['uses' => 'EventController@store', 'as' => 'admin_event_store']);
    Route::post('/event/update/{id}', ['uses' => 'EventController@update', 'as' => 'admin_event_update']);
    Route::post('/event/delete/{id}', ['uses' => 'EventController@delete', 'as' => 'admin_event_delete']);

    Route::get('/event/text', ['uses' => 'EventController@text', 'as' => 'admin_event_text']);
    Route::post('/event/text', ['uses' => 'EventController@updateText', 'as' => 'admin_event_text_update']);

    Route::get('/event/slider', ['uses' => 'EventSliderController@table', 'as' => 'admin_event_slider_table']);
    Route::get('/event/slider/create', ['uses' => 'EventSliderController@create', 'as' => 'admin_event_slider_create']);
    Route::get('/event/slider/edit/{id}', ['uses' => 'EventSliderController@edit', 'as' => 'admin_event_slider_edit']);
    Route::post('/event/slider', ['uses' => 'EventSliderController@index', 'as' => 'admin_event_slider_index']);
    Route::post('/event/slider/store', ['uses' => 'EventSliderController@store', 'as' => 'admin_event_slider_store']);
    Route::post('/event/slider/update/{id}', ['uses' => 'EventSliderController@update', 'as' => 'admin_event_slider_update']);
    Route::post('/event/slider/delete/{id}', ['uses' => 'EventSliderController@delete', 'as' => 'admin_event_slider_delete']);

    Route::get('/vacancy', ['uses' => 'VacancyController@table', 'as' => 'admin_vacancy_table']);
    Route::get('/vacancy/create', ['uses' => 'VacancyController@create', 'as' => 'admin_vacancy_create']);
    Route::get('/vacancy/edit/{id}', ['uses' => 'VacancyController@edit', 'as' => 'admin_vacancy_edit']);
    Route::post('/vacancy', ['uses' => 'VacancyController@index', 'as' => 'admin_vacancy_index']);
    Route::post('/vacancy/store', ['uses' => 'VacancyController@store', 'as' => 'admin_vacancy_store']);
    Route::post('/vacancy/update/{id}', ['uses' => 'VacancyController@update', 'as' => 'admin_vacancy_update']);
    Route::post('/vacancy/delete/{id}', ['uses' => 'VacancyController@delete', 'as' => 'admin_vacancy_delete']);

    Route::get('/reserved', ['uses' => 'ReservedController@table', 'as' => 'admin_reserved_table']);
    Route::get('/reserved/create', ['uses' => 'ReservedController@create', 'as' => 'admin_reserved_create']);
    Route::get('/reserved/edit/{id}', ['uses' => 'ReservedController@edit', 'as' => 'admin_reserved_edit']);
    Route::post('/reserved', ['uses' => 'ReservedController@index', 'as' => 'admin_reserved_index']);
    Route::post('/reserved/store', ['uses' => 'ReservedController@store', 'as' => 'admin_reserved_store']);
    Route::post('/reserved/update/{id}', ['uses' => 'ReservedController@update', 'as' => 'admin_reserved_update']);
    Route::post('/reserved/delete/{id}', ['uses' => 'ReservedController@delete', 'as' => 'admin_reserved_delete']);

    Route::get('/order', ['uses' => 'OrderController@table', 'as' => 'admin_order_table']);
    Route::get('/order/create', ['uses' => 'OrderController@create', 'as' => 'admin_order_create']);
    Route::get('/order/edit/{id}', ['uses' => 'OrderController@edit', 'as' => 'admin_order_edit']);
    Route::post('/order', ['uses' => 'OrderController@index', 'as' => 'admin_order_index']);
    Route::post('/order/store', ['uses' => 'OrderController@store', 'as' => 'admin_order_store']);
    Route::post('/order/update/{id}', ['uses' => 'OrderController@update', 'as' => 'admin_order_update']);
    Route::post('/order/delete/{id}', ['uses' => 'OrderController@delete', 'as' => 'admin_order_delete']);

});
