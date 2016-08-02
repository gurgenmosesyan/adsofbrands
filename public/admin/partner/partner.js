var $partner = $.extend(true, {}, $main);
$partner.listPath = '/admpanel/partner';

$partner.initSearchPage = function() {
    $partner.listColumns = [
        {data: 'id'},
        {
            data: 'image',
            render: function(data) {
                return '<img src="/images/partner/'+ data +'" height="70">';
            },
            orderable: false
        },
        {data: 'link'}
    ];
    $partner.initSearch();
};

$partner.initEditPage = function() {
    $partner.initForm();
};

$partner.init();
