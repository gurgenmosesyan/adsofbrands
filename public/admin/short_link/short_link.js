var $shortLink = $.extend(true, {}, $main);
$shortLink.listPath = '/admpanel/shortLink';

$shortLink.initSearchPage = function() {
    $shortLink.listColumns = [
        {data: 'id'},
        {data: 'short_link'},
        {data: 'link'}
    ];
    if ($main.showAdminInfo) {
        $shortLink.listColumns.push(
            {
                data: 'created_by',
                sortable: false
            },
            {
                data: 'updated_by',
                sortable: false
            }
        );
    }
    $shortLink.initSearch();
};

$shortLink.initEditPage = function() {

    $shortLink.initForm();
};

$shortLink.init();
