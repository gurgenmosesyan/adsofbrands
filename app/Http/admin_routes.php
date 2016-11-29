<?php

$params = [
    'middleware' => ['web'],
    'prefix' => 'admpanel',
    'namespace' => 'Admin'
];

Route::group($params, function () {

    Route::get('/', function() {
        return redirect()->route('core_admin_login');
    });

    Route::group(['middleware' => ['auth:admin', 'language', 'access_control']], function() {

        Route::get('/mediaType', ['uses' => 'MediaTypeController@table', 'as' => 'admin_media_type_table', 'permission' => 'media_type']);
        Route::get('/mediaType/create', ['uses' => 'MediaTypeController@create', 'as' => 'admin_media_type_create', 'permission' => 'media_type']);
        Route::get('/mediaType/edit/{id}', ['uses' => 'MediaTypeController@edit', 'as' => 'admin_media_type_edit', 'permission' => 'media_type']);
        Route::post('/mediaType', ['uses' => 'MediaTypeController@index', 'as' => 'admin_media_type_index', 'permission' => 'media_type']);
        Route::post('/mediaType/store', ['uses' => 'MediaTypeController@store', 'as' => 'admin_media_type_store', 'permission' => 'media_type']);
        Route::post('/mediaType/update/{id}', ['uses' => 'MediaTypeController@update', 'as' => 'admin_media_type_update', 'permission' => 'media_type']);
        Route::post('/mediaType/delete/{id}', ['uses' => 'MediaTypeController@delete', 'as' => 'admin_media_type_delete', 'permission' => 'super_admin']);

        Route::get('/category', ['uses' => 'CategoryController@table', 'as' => 'admin_category_table', 'permission' => 'industry_type']);
        Route::get('/category/create', ['uses' => 'CategoryController@create', 'as' => 'admin_category_create', 'permission' => 'industry_type']);
        Route::get('/category/edit/{id}', ['uses' => 'CategoryController@edit', 'as' => 'admin_category_edit', 'permission' => 'industry_type']);
        Route::post('/category', ['uses' => 'CategoryController@index', 'as' => 'admin_category_index', 'permission' => 'industry_type']);
        Route::post('/category/store', ['uses' => 'CategoryController@store', 'as' => 'admin_category_store', 'permission' => 'industry_type']);
        Route::post('/category/update/{id}', ['uses' => 'CategoryController@update', 'as' => 'admin_category_update', 'permission' => 'industry_type']);
        Route::post('/category/delete/{id}', ['uses' => 'CategoryController@delete', 'as' => 'admin_category_delete', 'permission' => 'super_admin']);

        Route::get('/agencyCategory', ['uses' => 'AgencyCategoryController@table', 'as' => 'admin_agency_category_table', 'permission' => 'agency_category']);
        Route::get('/agencyCategory/create', ['uses' => 'AgencyCategoryController@create', 'as' => 'admin_agency_category_create', 'permission' => 'agency_category']);
        Route::get('/agencyCategory/edit/{id}', ['uses' => 'AgencyCategoryController@edit', 'as' => 'admin_agency_category_edit', 'permission' => 'agency_category']);
        Route::post('/agencyCategory', ['uses' => 'AgencyCategoryController@index', 'as' => 'admin_agency_category_index', 'permission' => 'agency_category']);
        Route::post('/agencyCategory/store', ['uses' => 'AgencyCategoryController@store', 'as' => 'admin_agency_category_store', 'permission' => 'agency_category']);
        Route::post('/agencyCategory/update/{id}', ['uses' => 'AgencyCategoryController@update', 'as' => 'admin_agency_category_update', 'permission' => 'agency_category']);
        Route::post('/agencyCategory/delete/{id}', ['uses' => 'AgencyCategoryController@delete', 'as' => 'admin_agency_category_delete', 'permission' => 'super_admin']);

        Route::get('/news', ['uses' => 'NewsController@table', 'as' => 'admin_news_table', 'permission' => 'news']);
        Route::get('/news/create', ['uses' => 'NewsController@create', 'as' => 'admin_news_create', 'permission' => 'news']);
        Route::get('/news/edit/{id}', ['uses' => 'NewsController@edit', 'as' => 'admin_news_edit', 'permission' => 'news']);
        Route::post('/news', ['uses' => 'NewsController@index', 'as' => 'admin_news_index', 'permission' => 'news']);
        Route::post('/news/store', ['uses' => 'NewsController@store', 'as' => 'admin_news_store', 'permission' => 'news']);
        Route::post('/news/update/{id}', ['uses' => 'NewsController@update', 'as' => 'admin_news_update', 'permission' => 'news']);
        Route::post('/news/delete/{id}', ['uses' => 'NewsController@delete', 'as' => 'admin_news_delete', 'permission' => 'super_admin']);

        Route::get('/team', ['uses' => 'TeamController@table', 'as' => 'admin_team_table', 'permission' => 'team']);
        Route::get('/team/create', ['uses' => 'TeamController@create', 'as' => 'admin_team_create', 'permission' => 'team']);
        Route::get('/team/edit/{id}', ['uses' => 'TeamController@edit', 'as' => 'admin_team_edit', 'permission' => 'team']);
        Route::post('/team', ['uses' => 'TeamController@index', 'as' => 'admin_team_index', 'permission' => 'team']);
        Route::post('/team/store', ['uses' => 'TeamController@store', 'as' => 'admin_team_store', 'permission' => 'team']);
        Route::post('/team/update/{id}', ['uses' => 'TeamController@update', 'as' => 'admin_team_update', 'permission' => 'team']);
        Route::post('/team/delete/{id}', ['uses' => 'TeamController@delete', 'as' => 'admin_team_delete', 'permission' => 'super_admin']);

        Route::get('/footerMenu', ['uses' => 'FooterMenuController@table', 'as' => 'admin_footer_menu_table', 'permission' => 'footer_menu']);
        Route::get('/footerMenu/create', ['uses' => 'FooterMenuController@create', 'as' => 'admin_footer_menu_create', 'permission' => 'footer_menu']);
        Route::get('/footerMenu/edit/{id}', ['uses' => 'FooterMenuController@edit', 'as' => 'admin_footer_menu_edit', 'permission' => 'footer_menu']);
        Route::post('/footerMenu', ['uses' => 'FooterMenuController@index', 'as' => 'admin_footer_menu_index', 'permission' => 'footer_menu']);
        Route::post('/footerMenu/store', ['uses' => 'FooterMenuController@store', 'as' => 'admin_footer_menu_store', 'permission' => 'footer_menu']);
        Route::post('/footerMenu/update/{id}', ['uses' => 'FooterMenuController@update', 'as' => 'admin_footer_menu_update', 'permission' => 'footer_menu']);
        Route::post('/footerMenu/delete/{id}', ['uses' => 'FooterMenuController@delete', 'as' => 'admin_footer_menu_delete', 'permission' => 'super_admin']);

        Route::get('/banner', ['uses' => 'BannerController@table', 'as' => 'admin_banner_table', 'permission' => 'banner']);
        Route::get('/banner/edit/{id}', ['uses' => 'BannerController@edit', 'as' => 'admin_banner_edit', 'permission' => 'banner']);
        Route::post('/banner', ['uses' => 'BannerController@index', 'as' => 'admin_banner_index', 'permission' => 'banner']);
        Route::post('/banner/update/{id}', ['uses' => 'BannerController@update', 'as' => 'admin_banner_update', 'permission' => 'banner']);

        Route::get('/subscribe', ['uses' => 'SubscribeController@table', 'as' => 'admin_subscribe_table', 'permission' => 'subscribe']);
        Route::post('/subscribe', ['uses' => 'SubscribeController@index', 'as' => 'admin_subscribe_index', 'permission' => 'subscribe']);
        Route::post('/subscribe/delete/{id}', ['uses' => 'SubscribeController@delete', 'as' => 'admin_subscribe_delete', 'permission' => 'super_admin']);
        Route::get('/subscribe/export', ['uses' => 'SubscribeController@export', 'as' => 'admin_subscribe_export', 'permission' => 'subscribe']);

        Route::get('/brand', ['uses' => 'BrandController@table', 'as' => 'admin_brand_table', 'permission' => 'brand']);
        Route::get('/brand/create', ['uses' => 'BrandController@create', 'as' => 'admin_brand_create', 'permission' => 'brand']);
        Route::post('/brand/store', ['uses' => 'BrandController@store', 'as' => 'admin_brand_store', 'permission' => 'brand']);
        Route::post('/brand/delete/{id}', ['uses' => 'BrandController@delete', 'as' => 'admin_brand_delete', 'permission' => 'super_admin']);

        Route::get('/agency', ['uses' => 'AgencyController@table', 'as' => 'admin_agency_table', 'permission' => 'agency']);
        Route::get('/agency/create', ['uses' => 'AgencyController@create', 'as' => 'admin_agency_create', 'permission' => 'agency']);
        Route::post('/agency/store', ['uses' => 'AgencyController@store', 'as' => 'admin_agency_store', 'permission' => 'agency']);
        Route::post('/agency/delete/{id}', ['uses' => 'AgencyController@delete', 'as' => 'admin_agency_delete', 'permission' => 'super_admin']);

    });

    Route::group(['middleware' => ['auth:all', 'access_control']], function() {

        Route::post('/brand', ['uses' => 'BrandController@index', 'as' => 'admin_brand_index', 'permission' => 'brand']);
        Route::post('/agency', ['uses' => 'AgencyController@index', 'as' => 'admin_agency_index', 'permission' => 'agency']);

        Route::get('/award', ['uses' => 'AwardController@table', 'as' => 'admin_award_table', 'permission' => 'award']);
        Route::get('/award/create', ['uses' => 'AwardController@create', 'as' => 'admin_award_create', 'permission' => 'award']);
        Route::get('/award/edit/{id}', ['uses' => 'AwardController@edit', 'as' => 'admin_award_edit', 'permission' => 'award']);
        Route::post('/award', ['uses' => 'AwardController@index', 'as' => 'admin_award_index', 'permission' => 'award']);
        Route::post('/award/store', ['uses' => 'AwardController@store', 'as' => 'admin_award_store', 'permission' => 'award']);
        Route::post('/award/update/{id}', ['uses' => 'AwardController@update', 'as' => 'admin_award_update', 'permission' => 'award']);
        Route::post('/award/delete/{id}', ['uses' => 'AwardController@delete', 'as' => 'admin_award_delete', 'permission' => 'super_admin']);

        Route::get('/commercial', ['uses' => 'CommercialController@table', 'as' => 'admin_commercial_table', 'permission' => 'commercial']);
        Route::get('/commercial/create', ['uses' => 'CommercialController@create', 'as' => 'admin_commercial_create', 'permission' => 'commercial']);
        Route::get('/commercial/edit/{id}', ['uses' => 'CommercialController@edit', 'as' => 'admin_commercial_edit', 'permission' => 'commercial']);
        Route::post('/commercial', ['uses' => 'CommercialController@index', 'as' => 'admin_commercial_index', 'permission' => 'commercial']);
        Route::post('/commercial/store', ['uses' => 'CommercialController@store', 'as' => 'admin_commercial_store', 'permission' => 'commercial']);
        Route::post('/commercial/update/{id}', ['uses' => 'CommercialController@update', 'as' => 'admin_commercial_update', 'permission' => 'commercial']);
        Route::post('/commercial/delete/{id}', ['uses' => 'CommercialController@delete', 'as' => 'admin_commercial_delete', 'permission' => 'super_admin']);
        Route::post('/commercial/brand', ['uses' => 'CommercialController@brand', 'as' => 'admin_commercial_brand', 'permission' => 'commercial']);
        Route::post('/commercial/agency', ['uses' => 'CommercialController@agency', 'as' => 'admin_commercial_agency', 'permission' => 'commercial']);
        Route::post('/commercial/creative', ['uses' => 'CommercialController@creative', 'as' => 'admin_commercial_creative', 'permission' => 'commercial']);

        Route::get('/creative/edit/{id}', ['uses' => 'CreativeController@edit', 'as' => 'admin_creative_edit', 'permission' => 'creative']);
        Route::post('/creative/update/{id}', ['uses' => 'CreativeController@update', 'as' => 'admin_creative_update', 'permission' => 'creative']);
    });

    Route::group(['middleware' => ['auth:brand_agency', 'access_control']], function() {

        Route::get('/creative', ['uses' => 'CreativeController@table', 'as' => 'admin_creative_table', 'permission' => 'creative']);
        Route::get('/creative/create', ['uses' => 'CreativeController@create', 'as' => 'admin_creative_create', 'permission' => 'creative']);
        Route::post('/creative', ['uses' => 'CreativeController@index', 'as' => 'admin_creative_index', 'permission' => 'creative']);
        Route::post('/creative/store', ['uses' => 'CreativeController@store', 'as' => 'admin_creative_store', 'permission' => 'creative']);
        Route::post('/creative/delete/{id}', ['uses' => 'CreativeController@delete', 'as' => 'admin_creative_delete', 'permission' => 'super_admin']);

        Route::get('/branch', ['uses' => 'BranchController@table', 'as' => 'admin_branch_table', 'permission' => 'branch']);
        Route::get('/branch/create', ['uses' => 'BranchController@create', 'as' => 'admin_branch_create', 'permission' => 'branch']);
        Route::get('/branch/edit/{id}', ['uses' => 'BranchController@edit', 'as' => 'admin_branch_edit', 'permission' => 'branch']);
        Route::post('/branch', ['uses' => 'BranchController@index', 'as' => 'admin_branch_index', 'permission' => 'branch']);
        Route::post('/branch/store', ['uses' => 'BranchController@store', 'as' => 'admin_branch_store', 'permission' => 'branch']);
        Route::post('/branch/update/{id}', ['uses' => 'BranchController@update', 'as' => 'admin_branch_update', 'permission' => 'branch']);
        Route::post('/branch/delete/{id}', ['uses' => 'BranchController@delete', 'as' => 'admin_branch_delete', 'permission' => 'super_admin']);

        Route::get('/vacancy', ['uses' => 'VacancyController@table', 'as' => 'admin_vacancy_table', 'permission' => 'vacancy']);
        Route::get('/vacancy/create', ['uses' => 'VacancyController@create', 'as' => 'admin_vacancy_create', 'permission' => 'vacancy']);
        Route::get('/vacancy/edit/{id}', ['uses' => 'VacancyController@edit', 'as' => 'admin_vacancy_edit', 'permission' => 'vacancy']);
        Route::post('/vacancy', ['uses' => 'VacancyController@index', 'as' => 'admin_vacancy_index', 'permission' => 'vacancy']);
        Route::post('/vacancy/store', ['uses' => 'VacancyController@store', 'as' => 'admin_vacancy_store', 'permission' => 'vacancy']);
        Route::post('/vacancy/update/{id}', ['uses' => 'VacancyController@update', 'as' => 'admin_vacancy_update', 'permission' => 'vacancy']);
        Route::post('/vacancy/delete/{id}', ['uses' => 'VacancyController@delete', 'as' => 'admin_vacancy_delete', 'permission' => 'super_admin']);

    });

    Route::group(['middleware' => ['auth:brand', 'access_control']], function() {
        Route::get('/brand/edit/{id}', ['uses' => 'BrandController@edit', 'as' => 'admin_brand_edit', 'permission' => 'brand']);
        Route::post('/brand/update/{id}', ['uses' => 'BrandController@update', 'as' => 'admin_brand_update', 'permission' => 'brand']);
    });

    Route::group(['middleware' => ['auth:agency', 'access_control']], function() {
        Route::get('/agency/edit/{id}', ['uses' => 'AgencyController@edit', 'as' => 'admin_agency_edit', 'permission' => 'agency']);
        Route::post('/agency/update/{id}', ['uses' => 'AgencyController@update', 'as' => 'admin_agency_update', 'permission' => 'agency']);
    });

});
