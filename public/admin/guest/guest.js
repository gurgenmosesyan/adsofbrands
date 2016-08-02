var $guest = $.extend(true, {}, $main);
$guest.listPath = '/admpanel/guest';

$guest.initSearchPage = function() {
    $guest.listColumns = [
        {data: 'id'},
        {data: 'name'}
    ];
    $guest.initSearch();
};

$guest.initEditPage = function() {
    $guest.initForm();
};

$guest.init();
