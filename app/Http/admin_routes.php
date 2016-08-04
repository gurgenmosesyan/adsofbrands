<?php

$params = [
    'middleware' => ['web', 'auth:admin', 'language'],
    'prefix' => 'admpanel',
    'namespace' => 'Admin'
];

Route::group($params, function () {

    Route::get('/', function() {
        return redirect()->route('admin_media_type_table');
    });

    Route::get('/mediaType', ['uses' => 'MediaTypeController@table', 'as' => 'admin_media_type_table']);
    Route::get('/mediaType/create', ['uses' => 'MediaTypeController@create', 'as' => 'admin_media_type_create']);
    Route::get('/mediaType/edit/{id}', ['uses' => 'MediaTypeController@edit', 'as' => 'admin_media_type_edit']);
    Route::post('/mediaType', ['uses' => 'MediaTypeController@index', 'as' => 'admin_media_type_index']);
    Route::post('/mediaType/store', ['uses' => 'MediaTypeController@store', 'as' => 'admin_media_type_store']);
    Route::post('/mediaType/update/{id}', ['uses' => 'MediaTypeController@update', 'as' => 'admin_media_type_update']);
    Route::post('/mediaType/delete/{id}', ['uses' => 'MediaTypeController@delete', 'as' => 'admin_media_type_delete']);

    Route::get('/industryType', ['uses' => 'IndustryTypeController@table', 'as' => 'admin_industry_type_table']);
    Route::get('/industryType/create', ['uses' => 'IndustryTypeController@create', 'as' => 'admin_industry_type_create']);
    Route::get('/industryType/edit/{id}', ['uses' => 'IndustryTypeController@edit', 'as' => 'admin_industry_type_edit']);
    Route::post('/industryType', ['uses' => 'IndustryTypeController@index', 'as' => 'admin_industry_type_index']);
    Route::post('/industryType/store', ['uses' => 'IndustryTypeController@store', 'as' => 'admin_industry_type_store']);
    Route::post('/industryType/update/{id}', ['uses' => 'IndustryTypeController@update', 'as' => 'admin_industry_type_update']);
    Route::post('/industryType/delete/{id}', ['uses' => 'IndustryTypeController@delete', 'as' => 'admin_industry_type_delete']);

    Route::get('/category', ['uses' => 'CategoryController@table', 'as' => 'admin_category_table']);
    Route::get('/category/create', ['uses' => 'CategoryController@create', 'as' => 'admin_category_create']);
    Route::get('/category/edit/{id}', ['uses' => 'CategoryController@edit', 'as' => 'admin_category_edit']);
    Route::post('/category', ['uses' => 'CategoryController@index', 'as' => 'admin_category_index']);
    Route::post('/category/store', ['uses' => 'CategoryController@store', 'as' => 'admin_category_store']);
    Route::post('/category/update/{id}', ['uses' => 'CategoryController@update', 'as' => 'admin_category_update']);
    Route::post('/category/delete/{id}', ['uses' => 'CategoryController@delete', 'as' => 'admin_category_delete']);

    Route::get('/brand', ['uses' => 'BrandController@table', 'as' => 'admin_brand_table']);
    Route::get('/brand/create', ['uses' => 'BrandController@create', 'as' => 'admin_brand_create']);
    Route::get('/brand/edit/{id}', ['uses' => 'BrandController@edit', 'as' => 'admin_brand_edit']);
    Route::post('/brand', ['uses' => 'BrandController@index', 'as' => 'admin_brand_index']);
    Route::post('/brand/store', ['uses' => 'BrandController@store', 'as' => 'admin_brand_store']);
    Route::post('/brand/update/{id}', ['uses' => 'BrandController@update', 'as' => 'admin_brand_update']);
    Route::post('/brand/delete/{id}', ['uses' => 'BrandController@delete', 'as' => 'admin_brand_delete']);

});
