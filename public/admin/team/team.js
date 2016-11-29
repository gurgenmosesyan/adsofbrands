var $team = $.extend(true, {}, $main);
$team.listPath = '/admpanel/team';

$team.initSearchPage = function() {
    $team.listColumns = [
        {data: 'id'},
        {data: 'first_name'},
        {data: 'last_name'},
        {data: 'position'}
    ];
    if ($main.showAdminInfo) {
        $team.listColumns.push(
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
    $team.initSearch();
};

$team.initEditPage = function() {

    $team.initForm();
};

$team.init();
