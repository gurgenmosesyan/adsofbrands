var $type = $.extend(true, {}, $main);
$type.listPath = '/admpanel/mediaType';

$type.initSearchPage = function() {
    $type.listColumns = [
        {data: 'id'},
        {data: 'title'}
    ];
    if ($main.showAdminInfo) {
        $type.listColumns.push(
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
    $type.initSearch();
};

$type.initEditPage = function() {

    $type.initForm();
};

$type.init();
