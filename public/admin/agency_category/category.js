var $category = $.extend(true, {}, $main);
$category.listPath = '/admpanel/agencyCategory';

$category.initSearchPage = function() {
    $category.listColumns = [
        {data: 'id'},
        {data: 'title'}
    ];
    $category.initSearch();
};

$category.initEditPage = function() {

    $category.initForm();
};

$category.init();
