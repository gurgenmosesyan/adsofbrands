var $creative = $.extend(true, {}, $main);
$creative.listPath = '/admpanel/creative';
$creative.type = null;
$creative.resetType = true;

$creative.initSearchPage = function() {
    $creative.listColumns = [
        {data: 'id'},
        {data: 'type'},
        {data: 'brand_agency', sortable: false},
        {data: 'title'}
    ];
    $creative.initSearch();
};

$creative.initType = function() {
    var typeId = $('#type-id');
    if ($creative.saveMode == 'edit') {
        $creative.resetType = false;
    }
    $('#type').change(function() {
        if ($creative.resetType) {
            typeId.find('input').val('');
            typeId.find('.icon-remove').hide();
        }
        $creative.resetType = true;
        if ($(this).val() == 'brand') {
            $creative.type = 'brand';
            typeId.removeClass('dn').find('label').text($trans.get('admin.base.label.brand'));
        } else if ($(this).val() == 'agency') {
            $creative.type = 'agency';
            typeId.removeClass('dn').find('label').text($trans.get('admin.base.label.agency'));
        } else {
            $creative.type = null;
            typeId.addClass('dn');
        }
    }).change();
};

$creative.initSelectBox = function() {
    var typeSearch = $('#type-search');
    typeSearch.searchSelectBox({
        source : function (request, response) {
            typeSearch.loading();
            $.ajax({
                type :'post',
                url	 : '/admpanel/'+$creative.type,
                data : {
                    search : {
                        value : request.term
                    },
                    _token : $main.token
                },
                dataType :'json',
                success	 : function (json) {
                    typeSearch.removeLoading();
                    if (json.recordsTotal > 0) {
                        response($.map(json.data , function(item) {
                            item.label = item.title;
                            return item;
                        }));
                    }
                }
            });
        }
    });
};

$creative.makeAlias = function(title, aliasObj) {
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

$creative.initEditPage = function() {

    $creative.initForm();

    $creative.initType();

    $creative.initSelectBox();

    $('.title').change(function() {
        $creative.makeAlias($(this).val(), $('.alias'));
    });
};

$creative.init();
