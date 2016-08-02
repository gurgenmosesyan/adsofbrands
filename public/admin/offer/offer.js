var $offer = $.extend(true, {}, $main);
$offer.listPath = '/admpanel/offer';

$offer.initSearchPage = function() {
    $offer.listColumns = [
        {data: 'id'},
        {data: 'title'},
        {data: 'sort_order'}
    ];
    $offer.order = [[2, 'asc']];
    $offer.initSearch();
};

$offer.initEditPage = function() {

    $offer.initForm();

    CKEDITOR.config.height = 120;
};

$offer.init();
