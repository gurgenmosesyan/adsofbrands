var $type = $.extend(true, {}, $main);
$type.listPath = '/admpanel/mediaType';

$type.initSearchPage = function() {
    $type.listColumns = [
        {data: 'id'},
        {data: 'title'}
    ];
    $type.initSearch();
};

$type.initEditPage = function() {

    $type.initForm();
};

$type.init();
