var $branch = $.extend(true, {}, $main);
$branch.listPath = '/admpanel/branch';

$branch.initSearchPage = function() {
    $branch.listColumns = [
        {data: 'id'},
        {data: 'type'},
        {data: 'brand_agency', sortable: false},
        {data: 'title'},
        {data: 'address'}
    ];
    $branch.initSearch();
};

$branch.initType = function() {
    var typeId = $('#type-id');
    $('#type').change(function() {
        if ($(this).val() == 'brand') {
            typeId.removeClass('dn').find('label').text($trans.get('admin.base.label.brand'));
        } else if ($(this).val() == 'agency') {
            typeId.removeClass('dn').find('label').text($trans.get('admin.base.label.agency'));
        } else {
            typeId.addClass('dn');
        }
    });
};

$branch.initEditPage = function() {

    $branch.initForm();

    $branch.initType();
};

$branch.init();
