var $language = $.extend(true, {}, $main);
$language.listPath = '/admpanel/core/language';

$language.initSearchPage = function() {
    $language.listColumns = [
        {data: 'id'},
        {data: 'name'},
        {data: 'code'}
    ];
    $language.initSearch();
};

$language.initEditPage = function() {
    $language.initForm();
};

$language.init();
