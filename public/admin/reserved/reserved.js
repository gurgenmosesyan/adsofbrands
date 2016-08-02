var $reserved = $.extend(true, {}, $main);
$reserved.listPath = '/admpanel/reserved';

$reserved.initSearchPage = function() {
    var self = this,
        searchForm = $('#search-form');
    $main.table = $('#data-table').DataTable({
        "autoWidth": false,
        "processing": true,
        "oLanguage": {
            "sProcessing": $trans.get('admin.base.label.loading')
        },
        "serverSide": true,
        "ajax": {
            "url": self.listPath,
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
            "dataType": 'json',
            error: function (xhr) {
                if (xhr.status === 401) {
                    document.location.href = xhr.responseJSON.path;
                }
            }
        },
        "columns": [
            {data: 'id'},
            {data: 'acc_title'},
            {data: 'room_quantity'},
            {data: 'date_from'},
            {data: 'date_to'},
            {data: 'type'},
            {
                data: null,
                render: function(data) {
                    return '<div class="text-center"><a href="'+ self.listPath +'/edit/'+data.id+'"><i class="fa fa-pencil"></i></a>'+
                        '<a class="action-remove" href="#"><i class="fa fa-trash"></i></a></div>';
                },
                "orderable": false
            }
        ],
        "order": [[0, "desc"]]
    });

    $('#data-table tbody').on('click', '.action-remove', function() {
        var data = $main.table.row($(this).parents('tr')).data();
        $main.confirmModal = $main.getConfirmModal();
        $main.confirmModal.modal();
        $('.delete', $main.confirmModal).on('click', function() {
            self.deleteObj(data.id);
            return false;
        });
        return false;
    });

    $reserved.initFilters();
};

$reserved.initFilters = function() {
    $('#filters').appendTo($('#data-table_length').parent('div').prev('div'));
    $('#search-form').submit(function() {
        $main.table.draw();
        return false;
    });
};

$reserved.initEditPage = function() {
    $reserved.initForm();
};

$reserved.init();
