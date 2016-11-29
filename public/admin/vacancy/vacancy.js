var $vacancy = $.extend(true, {}, $main);
$vacancy.listPath = '/admpanel/vacancy';
$vacancy.type = null;
$vacancy.resetType = true;

$vacancy.initSearchPage = function() {
    $vacancy.listColumns = [
        {data: 'id'}
    ];
    if ($vacancy.isAdmin) {
        $vacancy.listColumns.push({data: 'type'});
        $vacancy.listColumns.push({data: 'brand_agency', sortable: false});
    }
    $vacancy.listColumns.push({data: 'title'});
    if ($main.showAdminInfo) {
        $vacancy.listColumns.push(
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
    $vacancy.initSearch();
};

$vacancy.initType = function() {
    var typeId = $('#type-id');
    if ($vacancy.saveMode == 'edit') {
        $vacancy.resetType = false;
    }
    $('#type').change(function() {
        if ($vacancy.resetType) {
            typeId.find('input').val('');
            typeId.find('.icon-remove').hide();
        }
        $vacancy.resetType = true;
        if ($(this).val() == 'brand') {
            $vacancy.type = 'brand';
            typeId.removeClass('dn').find('label').text($trans.get('admin.base.label.brand'));
        } else if ($(this).val() == 'agency') {
            $vacancy.type = 'agency';
            typeId.removeClass('dn').find('label').text($trans.get('admin.base.label.agency'));
        } else {
            $vacancy.type = null;
            typeId.addClass('dn');
        }
    }).change();
};

$vacancy.initSelectBox = function() {
    var typeSearch = $('#type-search');
    typeSearch.searchSelectBox({
        source : function (request, response) {
            typeSearch.loading();
            $.ajax({
                type :'post',
                url	 : '/admpanel/'+$vacancy.type,
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

$vacancy.initEditPage = function() {

    $vacancy.initForm();

    $vacancy.initType();

    $vacancy.initSelectBox();
};

$vacancy.init();
