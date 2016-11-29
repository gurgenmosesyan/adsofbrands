var $category = $.extend(true, {}, $main);
$category.listPath = '/admpanel/agencyCategory';

$category.initSearchPage = function() {
    $category.listColumns = [
        {data: 'id'},
        {data: 'title'}
    ];
    if ($main.showAdminInfo) {
        $category.listColumns.push(
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
    $category.initSearch();
};

$category.initEditPage = function() {

    $category.initForm();
};

$category.init();
