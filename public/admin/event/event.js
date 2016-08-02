var $event = $.extend(true, {}, $main);
$event.listPath = '/admpanel/event';

$event.initSearchPage = function() {
    $event.listColumns = [
        {data: 'id'},
        {data: 'title'},
        {data: 'sort_order'}
    ];
    $event.order = [[2, 'asc']];
    $event.initSearch();
};

$event.initEditPage = function() {

    $event.initForm();

    CKEDITOR.config.height = 120;
};

$event.init();
