var $text = $.extend(true, {}, $main);
$text.listPath = '/admpanel/text';

$text.initSearchPage = function() {
    $main.table = $('#data-table').DataTable({
        "autoWidth": false,
        "processing": true,
        "oLanguage": {
            "sProcessing": $trans.get('admin.base.label.loading')
        },
        "serverSide": true,
        "ajax": {
            "url": $text.listPath,
            "type": "post",
            "data": {
                '_token': $main.token
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    document.location.href = xhr.responseJSON.path;
                }
            }
        },
        "columns": [
            {data: 'id'},
            {data: 'key'},
            {
                "data": null,
                "render": function(data) {
                    return '<div class="text-center"><a href="'+ $text.listPath +'/edit/'+data.id+'"><i class="fa fa-pencil"></i></a>';
                },
                "orderable": false
            }
        ],
        "order": [[0, "asc"]]
    });
};

$text.initEditPage = function() {
    $text.initForm();

    CKEDITOR.replace('text-box');
};

$text.init();
