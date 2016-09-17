var $subscribe = $.extend(true, {}, $main);
$subscribe.listPath = '/admpanel/subscribe';

$subscribe.initSearchPage = function() {
    $subscribe.listColumns = [
        {data: 'id'},
        {data: 'email'}
    ];
    $subscribe.actions = {
        "data": null,
        "render": function(data) {
            return '<div class="text-center"><a class="action-remove" href="#"><i class="fa fa-trash"></i></a></div>';
        },
        "orderable": false
    };
    $subscribe.initSearch();
};

$subscribe.init();
