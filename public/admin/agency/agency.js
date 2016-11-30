var $agency = $.extend(true, {}, $main);
$agency.listPath = '/admpanel/agency';

$agency.initSearchPage = function() {
    $agency.listColumns = [
        {data: 'id'},
        {data: 'title'},
        {data: 'show_status'},
        {
            data: 'preview',
            sortable: false
        }
    ];
    if ($main.showAdminInfo) {
        $agency.listColumns.push(
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
    $agency.initSearch();
};

$agency.makeAlias = function(title, aliasObj) {
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

$agency.initEditPage = function() {

    $agency.initForm();

    $('.title').change(function() {
        $agency.makeAlias($(this).val(), $('.alias'));
    });

    //CKEDITOR.config.height = 120;
};

$agency.init();
