var $team = $.extend(true, {}, $main);
$team.listPath = '/admpanel/team';

$team.initSearchPage = function() {
    $team.listColumns = [
        {data: 'id'},
        {data: 'first_name'},
        {data: 'last_name'},
        {data: 'position'}
    ];
    $team.initSearch();
};

$team.initEditPage = function() {

    $team.initForm();
};

$team.init();
