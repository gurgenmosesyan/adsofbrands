var $menu = $.extend(true, {}, $main);
$menu.listPath = '/admpanel/footerMenu';

$menu.initSearchPage = function() {
    $menu.listColumns = [
        {data: 'id'},
        {data: 'title'}
    ];
    $menu.initSearch();
};

$menu.initEditPage = function() {

    $menu.initForm();

    CKEDITOR.config.height = 250;
};

$menu.init();
