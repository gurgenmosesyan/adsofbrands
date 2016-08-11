var $award = $.extend(true, {}, $main);
$award.listPath = '/admpanel/award';
$award.type = null;
$award.resetType = true;

$award.initSearchPage = function() {
    $award.listColumns = [
        {data: 'id'},
        {data: 'type'},
        {data: 'brand_agency_creative', sortable: false},
        {data: 'year'},
        {data: 'title'}
    ];
    $award.initSearch();
};

$award.initType = function() {
    var typeId = $('#type-id');
    if ($award.saveMode == 'edit') {
        $award.resetType = false;
    }
    $('#type').change(function() {
        if ($award.resetType) {
            typeId.find('input').val('');
            typeId.find('.icon-remove').hide();
        }
        $award.resetType = true;
        if ($(this).val() == 'brand') {
            $award.type = 'brand';
            typeId.removeClass('dn').find('label').text($trans.get('admin.base.label.brand'));
        } else if ($(this).val() == 'agency') {
            $award.type = 'agency';
            typeId.removeClass('dn').find('label').text($trans.get('admin.base.label.agency'));
        } else if ($(this).val() == 'creative') {
            $award.type = 'creative';
            typeId.removeClass('dn').find('label').text($trans.get('admin.base.label.creative'));
        } else {
            $award.type = null;
            typeId.addClass('dn');
        }
    }).change();
};

$award.initSelectBox = function() {
    var typeSearch = $('#type-search');
    typeSearch.searchSelectBox({
        source : function (request, response) {
            typeSearch.loading();
            $.ajax({
                type :'post',
                url	 : '/admpanel/'+$award.type,
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
                            item.label = item.title ? item.title : item.name;
                            return item;
                        }));
                    }
                }
            });
        }
    });
};

$award.initEditPage = function() {

    $award.initForm();

    $award.initType();

    $award.initSelectBox();
};

$award.init();
