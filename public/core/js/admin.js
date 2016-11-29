var $admin = $.extend(true, {}, $main);
$admin.listPath = '/admpanel/core/admin';

$admin.initSearchPage = function() {
    $admin.listColumns = [
        {data: 'id'},
        {data: 'email'},
        {data: 'super_admin'}
    ];
    $admin.initSearch();
};

$admin.initSuperAdmin = function() {
    var permissions = $('#permissions');
    $('#super-admin').on('ifChanged', function() {
        if ($(this).prop('checked')) {
            permissions.addClass('dn');
        } else {
            permissions.removeClass('dn');
        }
    }).trigger('ifChanged');
};

$admin.initEditPage = function() {
    $admin.initForm();

    $admin.initSuperAdmin();
};

$admin.init();
