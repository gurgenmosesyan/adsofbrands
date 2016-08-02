var $order = $.extend(true, {}, $main);
$order.listPath = '/admpanel/order';

$order.initSearchPage = function() {
    var self = this,
        searchForm = $('#search-form');
    var order = self.order || [[0, "desc"]];
    $main.table = $('#data-table').DataTable({
        "autoWidth": false,
        "processing": true,
        "oLanguage": {
            "sProcessing": $trans.get('admin.base.label.loading')
        },
        "serverSide": true,
        "ajax": {
            "url": $order.listPath,
            "type": "post",
            "data": function(data) {
                data.search.accommodation_id = searchForm.find('.acc-id').val();
                data.search.type = searchForm.find('.type').val();
                data.search.from_date_from = searchForm.find('.from-date-from').val();
                data.search.to_date_from = searchForm.find('.to-date-from').val();
                data.search.from_date_to = searchForm.find('.from-date-to').val();
                data.search.to_date_to = searchForm.find('.to-date-to').val();
                data._token = $main.token;
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    document.location.href = xhr.responseJSON.path;
                }
            }
        },
        "columns": [
            {data: 'id'},
            {data: 'accommodations', orderable: false},
            {data: 'price'},
            {data: 'date_from'},
            {data: 'date_to'},
            {data: 'info', orderable: false},
            {data: 'phone'},
            {data: 'email'},
            {data: 'type'}
        ],
        "order": order
    });

    $order.initFilters();
};

$order.initFilters = function() {
    $('#filters').appendTo($('#data-table_length').parent('div').prev('div'));
    $('#search-form').submit(function() {
        $main.table.draw();
        return false;
    });
};

$order.initEditPage = function() {

    $order.initForm();
};

$order.init();
