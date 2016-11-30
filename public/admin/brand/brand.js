var $brand = $.extend(true, {}, $main);
$brand.listPath = '/admpanel/brand';

$brand.initSearchPage = function() {
    $brand.listColumns = [
        {data: 'id'},
        {data: 'title'},
        {data: 'show_status'},
        {
            data: 'preview',
            sortable: false
        }
    ];
    if ($main.showAdminInfo) {
        $brand.listColumns.push(
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
    $brand.initSearch();
};

$brand.makeAlias = function(title, aliasObj) {
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

$brand.initEditPage = function() {

    $brand.initForm();

    $('.title').change(function() {
        $brand.makeAlias($(this).val(), $('.alias'));
    });

    //CKEDITOR.config.height = 120;
};

$brand.init();
