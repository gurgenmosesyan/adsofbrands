<?php

$params = [
    'middleware' => ['web'],
    'prefix' => 'admpanel/core',
    'namespace' => 'Core'
];

Route::group($params, function() {

	Route::get('/login', ['middleware' => 'guest:admin', 'uses' => 'AccountController@login', 'as' => 'core_admin_login']);
	Route::post('/login', ['uses' => 'AccountController@loginApi', 'as' => 'core_admin_login_api']);

	Route::group(['middleware' => ['auth:admin', 'language']], function() {

		Route::get('/logout', ['uses' => 'AccountController@logout', 'as' => 'core_admin_logout']);

		Route::get('/admin', ['uses' => 'AdminController@table', 'as' => 'core_admin_table']);
		Route::get('/admin/create', ['uses' => 'AdminController@create', 'as' => 'core_admin_create']);
		Route::get('/admin/edit/{id}', ['uses' => 'AdminController@edit', 'as' => 'core_admin_edit']);
		Route::post('/admin', ['uses' => 'AdminController@index', 'as' => 'core_admin_index']);
		Route::post('/admin/store', ['uses' => 'AdminController@store', 'as' => 'core_admin_store']);
		Route::post('/admin/update/{id}', ['uses' => 'AdminController@update', 'as' => 'core_admin_update']);
		Route::post('/admin/delete/{id}', ['uses' => 'AdminController@delete', 'as' => 'core_admin_delete']);

		Route::get('/language', ['uses' => 'LanguageController@table', 'as' => 'core_language_table']);
		Route::get('/language/create', ['uses' => 'LanguageController@create', 'as' => 'core_language_create']);
		Route::get('/language/edit/{id}', ['uses' => 'LanguageController@edit', 'as' => 'core_language_edit']);
		Route::post('/language', ['uses' => 'LanguageController@index', 'as' => 'core_language_index']);
		Route::post('/language/store', ['uses' => 'LanguageController@store', 'as' => 'core_language_store']);
		Route::post('/language/update/{id}', ['uses' => 'LanguageController@update', 'as' => 'core_language_update']);
		Route::post('/language/delete/{id}', ['uses' => 'LanguageController@delete', 'as' => 'core_language_delete']);

		Route::get('/dictionary', ['uses' => 'DictionaryController@table', 'as' => 'core_dictionary_table']);
		Route::post('/dictionary', ['uses' => 'DictionaryController@index', 'as' => 'core_dictionary_index']);
		Route::post('/dictionary/store', ['uses' => 'DictionaryController@store', 'as' => 'core_dictionary_store']);
		Route::post('/dictionary/update', ['uses' => 'DictionaryController@update', 'as' => 'core_dictionary_update']);
		Route::post('/dictionary/delete', ['uses' => 'DictionaryController@delete', 'as' => 'core_dictionary_delete']);

		Route::get('/image/show', ['uses' => 'ImageUploaderController@show', 'as' => 'core_image_show']);
		Route::post('/image/upload', ['uses' => 'ImageUploaderController@upload', 'as' => 'core_image_upload']);

	});

});
