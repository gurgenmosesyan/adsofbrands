var $menu = $.extend(true, {}, $main);
$menu.listPath = '/admpanel/footerMenu';

$menu.initSearchPage = function() {
    $menu.listColumns = [
        {data: 'id'},
        {data: 'title'},
        {data: 'show_status'},
        {
            data: 'preview',
            sortable: false
        }
    ];
    if ($main.showAdminInfo) {
        $menu.listColumns.push(
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
    $menu.initSearch();
};

$menu.makeAlias = function(title, aliasObj) {
    if ($.trim(aliasObj.val()) != '' || $.trim(title) == '') {
        return;
    }
    aliasObj.loading();
    $.ajax ({
        type : 'post',
        url	: '/admpanel/core/makeAlias',
        data : {
            title  : title,
            _token : $main.token
        },
        dataType : 'json',
        success	 : function (result) {
            aliasObj.removeLoading();
            if ($.trim(aliasObj.val()) != '') {
                return;
            }
            if (result.status == 'OK') {
                aliasObj.val(result.data);
            }
        }
    });
};

$menu.initEditPage = function() {

    $menu.initForm();

    $('.title').change(function() {
        $menu.makeAlias($(this).val(), $('.alias'));
    });

    $('.static').on('ifChanged', function() {
        if ($(this).prop('checked')) {
            $('.text-label').removeClass('data-req');
        } else {
            $('.text-label').addClass('data-req');
        }
    }).trigger('ifChanged');

    CKEDITOR.config.height = 250;
};

$menu.init();
