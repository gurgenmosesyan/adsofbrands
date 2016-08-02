var $dictionary = {};

$dictionary.initSearchPage = function() {
    var actions = {
        "data": null,
        "render": function(data) {
            return  '<div class="text-center">'+
                        '<a href="/admpanel/core/dictionary/edit/'+data.id+'" class="action-edit">'+
                            '<i class="fa fa-pencil"></i>'+
                        '</a>'+
                        '<a class="action-remove" href="#">'+
                            '<i class="fa fa-trash"></i>'+
                        '</a>'+
                    '</div>';
        },
        "orderable": false
    };
    $dictionary.listColumns.push(actions);
    $dictionary.table = $('#data-table').DataTable({
        "autoWidth": false,
        "processing": true,
        "oLanguage": {
            "sProcessing": $trans.get('admin.base.label.loading')
        },
        "serverSide": true,
        "ajax": {
            "url": '/admpanel/core/dictionary?app='+$dictionary.appId,
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
        "columns": $dictionary.listColumns,
        "order": [],
        "paging": false
    });
    var tableBody = $('#data-table tbody');
    tableBody.on('click', '.action-edit', function() {
        var data = $dictionary.table.row($(this).parents('tr')).data();
        $dictionary.edit(data);
        return false;
    });

    tableBody.on('click', '.action-remove', function() {
        var data = $dictionary.table.row($(this).parents('tr')).data();
        $dictionary.confirmModal = $main.getConfirmModal();
        $dictionary.confirmModal.modal();
        $('.delete', $dictionary.confirmModal).on('click', function() {
            $dictionary.deleteObj(data.key);
            return false;
        });
        return false;
    });

    $('.dataTables_length').appendTo($('#data-table_filter').parent('div').next('div'));
};

$dictionary.deleteObj = function(key) {
    $.ajax({
        type: 'post',
        url: '/admpanel/core/dictionary/delete',
        data: {
            key: key,
            app_id: $dictionary.appId,
            _token: $main.token
        },
        dataType: 'json',
        success: function(result) {
            if (result.status == 'OK') {
                $dictionary.confirmModal.modal('hide');
                $dictionary.table.ajax.reload();
            }
        }
    });
};

$dictionary.resetForm = function() {
    $('input[type="text"]', $dictionary.form).val('');
};

$dictionary.removeErrors = function() {
    $('.form-error', $dictionary.form).text('');
    $('.form-group', $dictionary.form).removeClass('has-error');
};

$dictionary.showErrors = function(errors) {
    for (var i in errors) {
        $('#form-error-'+ i.replace('.', '_')).text(errors[i]).closest('.form-group').addClass('has-error');
    }
};

$dictionary.edit = function(data) {
    $dictionary.removeErrors();
    for (var i in data) {
        $('.'+i, $dictionary.form).val(data[i]);
    }
    $dictionary.save();
};

$dictionary.save = function() {
    $dictionary.modal.modal();
    setTimeout(function() {
        $('input[name="key"]', $dictionary.modal).focus();
    }, 500);
    $dictionary.form.submit(function() {
        if ($('button', $dictionary.form).prop('disabled')) {
            return false;
        }
        $('button', $dictionary.form).prop('disabled', true);
        $.ajax({
            type: 'post',
            url: $dictionary.form.attr('action'),
            data: $dictionary.form.serializeArray(),
            dataType: 'json',
            success: function(result) {
                $dictionary.removeErrors();
                if (result.status == 'OK') {
                    $dictionary.modal.modal('hide');
                    $dictionary.table.ajax.reload();
                } else {
                    $dictionary.showErrors(result.errors);
                }
                $('button', $dictionary.form).prop('disabled', false);
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    document.location.href = xhr.responseJSON.path;
                }
            }
        });
        return false;
    });
};

$dictionary.initAdd = function() {
    $('#add-dictionary').on('click', function() {
        $dictionary.resetForm();
        $dictionary.save();
        return false;
    });
};

$dictionary.initApp = function() {
    $('#app-select').change(function() {
        document.location.href = '/admpanel/core/dictionary?app='+$(this).val();
    });
};

$dictionary.init = function() {

    $dictionary.modal = $('#dictionary-modal');
    $dictionary.form = $('form', $dictionary.modal);

    $dictionary.initSearchPage();

    $dictionary.initAdd();

    $dictionary.initApp();
};

$(document).ready(function() {
    $dictionary.init();
});