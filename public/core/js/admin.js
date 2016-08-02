var $admin = $.extend(true, {}, $main);
$admin.listPath = '/admpanel/core/admin';

$admin.initSearchPage = function() {
    $admin.listColumns = [
        {data: 'id'},
        {data: 'email'}
    ];
    $admin.initSearch();
    /*var table = $('#data-table').DataTable({
        "autoWidth": false,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/administrator/"+$news.url,
            "type": "post"
        },
        "columns": [
            {"data": "id"},
            {"data": "title"},
            {"data": "sub_title"},
            {"data": "description"},
            {
                "data": null,
                "render": function(data) {
                    return '<div><a href="/administrator/'+$news.url+'/edit?id='+data.id+'"><i class="fa fa-pencil"></i></a>'+
                        '<a class="action-remove" href="#"><i class="fa fa-trash"></i></a></div>';
                },
                "orderable": false
            }
        ],
        "order": [[0, "desc"]]
    });
    $('#data-table tbody').on('click', '.action-remove', function() {
        var data = table.row($(this).parents('tr')).data();
        var result = confirm('Are you sure delete?');
        if (result) {
            // process delete data.id
        }
        return false;
    });*/
};

/*$news.initEdit = function() {
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
    $('#datepicker').datepicker({timePicker: true, autoclose: true});
};*/

$admin.initEditPage = function() {
    $admin.initForm();
};

$admin.init();
