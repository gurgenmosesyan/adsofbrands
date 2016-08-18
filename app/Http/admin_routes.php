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

    Route::get('/agencyCategory', ['uses' => 'AgencyCategoryController@table', 'as' => 'admin_agency_category_table']);
    Route::get('/agencyCategory/create', ['uses' => 'AgencyCategoryController@create', 'as' => 'admin_agency_category_create']);
    Route::get('/agencyCategory/edit/{id}', ['uses' => 'AgencyCategoryController@edit', 'as' => 'admin_agency_category_edit']);
    Route::post('/agencyCategory', ['uses' => 'AgencyCategoryController@index', 'as' => 'admin_agency_category_index']);
    Route::post('/agencyCategory/store', ['uses' => 'AgencyCategoryController@store', 'as' => 'admin_agency_category_store']);
    Route::post('/agencyCategory/update/{id}', ['uses' => 'AgencyCategoryController@update', 'as' => 'admin_agency_category_update']);
    Route::post('/agencyCategory/delete/{id}', ['uses' => 'AgencyCategoryController@delete', 'as' => 'admin_agency_category_delete']);

    Route::get('/brand', ['uses' => 'BrandController@table', 'as' => 'admin_brand_table']);
    Route::get('/brand/create', ['uses' => 'BrandController@create', 'as' => 'admin_brand_create']);
    Route::get('/brand/edit/{id}', ['uses' => 'BrandController@edit', 'as' => 'admin_brand_edit']);
    Route::post('/brand', ['uses' => 'BrandController@index', 'as' => 'admin_brand_index']);
    Route::post('/brand/store', ['uses' => 'BrandController@store', 'as' => 'admin_brand_store']);
    Route::post('/brand/update/{id}', ['uses' => 'BrandController@update', 'as' => 'admin_brand_update']);
    Route::post('/brand/delete/{id}', ['uses' => 'BrandController@delete', 'as' => 'admin_brand_delete']);

    Route::get('/agency', ['uses' => 'AgencyController@table', 'as' => 'admin_agency_table']);
    Route::get('/agency/create', ['uses' => 'AgencyController@create', 'as' => 'admin_agency_create']);
    Route::get('/agency/edit/{id}', ['uses' => 'AgencyController@edit', 'as' => 'admin_agency_edit']);
    Route::post('/agency', ['uses' => 'AgencyController@index', 'as' => 'admin_agency_index']);
    Route::post('/agency/store', ['uses' => 'AgencyController@store', 'as' => 'admin_agency_store']);
    Route::post('/agency/update/{id}', ['uses' => 'AgencyController@update', 'as' => 'admin_agency_update']);
    Route::post('/agency/delete/{id}', ['uses' => 'AgencyController@delete', 'as' => 'admin_agency_delete']);

    Route::get('/branch', ['uses' => 'BranchController@table', 'as' => 'admin_branch_table']);
    Route::get('/branch/create', ['uses' => 'BranchController@create', 'as' => 'admin_branch_create']);
    Route::get('/branch/edit/{id}', ['uses' => 'BranchController@edit', 'as' => 'admin_branch_edit']);
    Route::post('/branch', ['uses' => 'BranchController@index', 'as' => 'admin_branch_index']);
    Route::post('/branch/store', ['uses' => 'BranchController@store', 'as' => 'admin_branch_store']);
    Route::post('/branch/update/{id}', ['uses' => 'BranchController@update', 'as' => 'admin_branch_update']);
    Route::post('/branch/delete/{id}', ['uses' => 'BranchController@delete', 'as' => 'admin_branch_delete']);

    Route::get('/vacancy', ['uses' => 'VacancyController@table', 'as' => 'admin_vacancy_table']);
    Route::get('/vacancy/create', ['uses' => 'VacancyController@create', 'as' => 'admin_vacancy_create']);
    Route::get('/vacancy/edit/{id}', ['uses' => 'VacancyController@edit', 'as' => 'admin_vacancy_edit']);
    Route::post('/vacancy', ['uses' => 'VacancyController@index', 'as' => 'admin_vacancy_index']);
    Route::post('/vacancy/store', ['uses' => 'VacancyController@store', 'as' => 'admin_vacancy_store']);
    Route::post('/vacancy/update/{id}', ['uses' => 'VacancyController@update', 'as' => 'admin_vacancy_update']);
    Route::post('/vacancy/delete/{id}', ['uses' => 'VacancyController@delete', 'as' => 'admin_vacancy_delete']);

    Route::get('/creative', ['uses' => 'CreativeController@table', 'as' => 'admin_creative_table']);
    Route::get('/creative/create', ['uses' => 'CreativeController@create', 'as' => 'admin_creative_create']);
    Route::get('/creative/edit/{id}', ['uses' => 'CreativeController@edit', 'as' => 'admin_creative_edit']);
    Route::post('/creative', ['uses' => 'CreativeController@index', 'as' => 'admin_creative_index']);
    Route::post('/creative/store', ['uses' => 'CreativeController@store', 'as' => 'admin_creative_store']);
    Route::post('/creative/update/{id}', ['uses' => 'CreativeController@update', 'as' => 'admin_creative_update']);
    Route::post('/creative/delete/{id}', ['uses' => 'CreativeController@delete', 'as' => 'admin_creative_delete']);

    Route::get('/award', ['uses' => 'AwardController@table', 'as' => 'admin_award_table']);
    Route::get('/award/create', ['uses' => 'AwardController@create', 'as' => 'admin_award_create']);
    Route::get('/award/edit/{id}', ['uses' => 'AwardController@edit', 'as' => 'admin_award_edit']);
    Route::post('/award', ['uses' => 'AwardController@index', 'as' => 'admin_award_index']);
    Route::post('/award/store', ['uses' => 'AwardController@store', 'as' => 'admin_award_store']);
    Route::post('/award/update/{id}', ['uses' => 'AwardController@update', 'as' => 'admin_award_update']);
    Route::post('/award/delete/{id}', ['uses' => 'AwardController@delete', 'as' => 'admin_award_delete']);

    Route::get('/news', ['uses' => 'NewsController@table', 'as' => 'admin_news_table']);
    Route::get('/news/create', ['uses' => 'NewsController@create', 'as' => 'admin_news_create']);
    Route::get('/news/edit/{id}', ['uses' => 'NewsController@edit', 'as' => 'admin_news_edit']);
    Route::post('/news', ['uses' => 'NewsController@index', 'as' => 'admin_news_index']);
    Route::post('/news/store', ['uses' => 'NewsController@store', 'as' => 'admin_news_store']);
    Route::post('/news/update/{id}', ['uses' => 'NewsController@update', 'as' => 'admin_news_update']);
    Route::post('/news/delete/{id}', ['uses' => 'NewsController@delete', 'as' => 'admin_news_delete']);

    Route::get('/commercial', ['uses' => 'CommercialController@table', 'as' => 'admin_commercial_table']);
    Route::get('/commercial/create', ['uses' => 'CommercialController@create', 'as' => 'admin_commercial_create']);
    Route::get('/commercial/edit/{id}', ['uses' => 'CommercialController@edit', 'as' => 'admin_commercial_edit']);
    Route::post('/commercial', ['uses' => 'CommercialController@index', 'as' => 'admin_commercial_index']);
    Route::post('/commercial/store', ['uses' => 'CommercialController@store', 'as' => 'admin_commercial_store']);
    Route::post('/commercial/update/{id}', ['uses' => 'CommercialController@update', 'as' => 'admin_commercial_update']);
    Route::post('/commercial/delete/{id}', ['uses' => 'CommercialController@delete', 'as' => 'admin_commercial_delete']);

    Route::get('/team', ['uses' => 'TeamController@table', 'as' => 'admin_team_table']);
    Route::get('/team/create', ['uses' => 'TeamController@create', 'as' => 'admin_team_create']);
    Route::get('/team/edit/{id}', ['uses' => 'TeamController@edit', 'as' => 'admin_team_edit']);
    Route::post('/team', ['uses' => 'TeamController@index', 'as' => 'admin_team_index']);
    Route::post('/team/store', ['uses' => 'TeamController@store', 'as' => 'admin_team_store']);
    Route::post('/team/update/{id}', ['uses' => 'TeamController@update', 'as' => 'admin_team_update']);
    Route::post('/team/delete/{id}', ['uses' => 'TeamController@delete', 'as' => 'admin_team_delete']);

    Route::get('/footerMenu', ['uses' => 'FooterMenuController@table', 'as' => 'admin_footer_menu_table']);
    Route::get('/footerMenu/create', ['uses' => 'FooterMenuController@create', 'as' => 'admin_footer_menu_create']);
    Route::get('/footerMenu/edit/{id}', ['uses' => 'FooterMenuController@edit', 'as' => 'admin_footer_menu_edit']);
    Route::post('/footerMenu', ['uses' => 'FooterMenuController@index', 'as' => 'admin_footer_menu_index']);
    Route::post('/footerMenu/store', ['uses' => 'FooterMenuController@store', 'as' => 'admin_footer_menu_store']);
    Route::post('/footerMenu/update/{id}', ['uses' => 'FooterMenuController@update', 'as' => 'admin_footer_menu_update']);
    Route::post('/footerMenu/delete/{id}', ['uses' => 'FooterMenuController@delete', 'as' => 'admin_footer_menu_delete']);

});
