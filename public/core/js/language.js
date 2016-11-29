var $language = $.extend(true, {}, $main);
$language.listPath = '/admpanel/core/language';

$language.initSearchPage = function() {
    $language.listColumns = [
        {data: 'id'},
        {data: 'name'},
        {data: 'code'}
    ];
    if ($main.showAdminInfo) {
        $language.listColumns.push(
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
    $language.initSearch();
};

$language.initEditPage = function() {
    $language.initForm();
};

$language.init();
