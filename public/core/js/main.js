'use strict';

var $main = {};

$main.initSearch = function() {
    var self = this;
    var listColumns = self.listColumns;
    var actions = self.actions || {
        "data": null,
        "render": function(data) {
            return '<div class="text-center"><a href="'+ self.getEditPath() +'/'+data.id+'"><i class="fa fa-pencil"></i></a>'+
                '<a class="action-remove" href="#"><i class="fa fa-trash"></i></a></div>';
        },
        "orderable": false
    };
    listColumns.push(actions);
    var order = self.order || [[0, "desc"]];
    $main.table = $('#data-table').DataTable({
        "autoWidth": false,
        "processing": true,
        "oLanguage": {
            "sProcessing": $trans.get('admin.base.label.loading')
        },
        "serverSide": true,
        "ajax": {
            "url": self.getListPath(),
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
        "columns": listColumns,
        "order": order
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
};

$main.deleteObj = function(id) {
    var self = this;
    $.ajax({
        method: 'post',
        url: self.getDeletePath()+'/'+id,
        data: {_token: $main.token},
        dataType: 'json',
        success: function(result) {
            $main.confirmModal.modal('hide');
            if (result.status == 'OK') {
                $main.table.ajax.reload();
            } else {
                alert('Error delete');
            }
        }
    });
};

$main.getListPath = function() {
    return this.listPath;
};

$main.getEditPath = function() {
    return this.editPath || this.listPath+'/edit';
};

$main.getDeletePath = function() {
    return this.deletePath || this.listPath+'/delete';
};

$main.getConfirmModal = function() {
    return $('<div id="delete-confirm" class="modal fade" tabindex="-1" role="dialog">'+
               '<div class="modal-dialog">'+
                   '<div class="modal-content">'+
                       '<div class="modal-header">'+
                           '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                           '<h4 class="modal-title">'+ $trans.get('admin.base.label.delete') +'</h4>'+
                       '</div>'+
                       '<div class="modal-body">'+$trans.get('admin.delete.modal.text')+
                       '</div>'+
                       '<div class="modal-footer">'+
                           '<button type="button" class="btn btn-default" data-dismiss="modal">'+ $trans.get('admin.base.label.close') +'</button>'+
                           '<button type="button" class="btn btn-primary delete">'+ $trans.get('admin.base.label.delete') +'</button>'+
                       '</div>'+
                   '</div>'+
               '</div>'+
           '</div>');
};

$main.removeErrors = function() {
    var form = $main.form;
    $('.form-error', form).text('');
    $('.form-group', form).removeClass('has-error');
};

$main.showErrors = function(errors) {
    for (var i in errors) {
        $('#form-error-'+i.replace(/\./g, '_')).text(errors[i][0]).closest('.form-group').addClass('has-error');
    }
    $('html, body').animate({
        scrollTop: $('.form-group.has-error:first').offset().top-10
    }, 500);
};

$main.save = function() {
    var self = this,
        form = $main.form;
    if ($('.nav-btn', form).prop('disabled')) {
        return false;
    }
    $('.nav-btn', form).prop('disabled', true);
    $main.winStatus($trans.get('admin.base.label.loading'));
    if (typeof CKEDITOR != 'undefined') {
        $('textarea.ckeditor').each(function() {
            var self = $(this);
            self.val(CKEDITOR.instances[self.attr('name')].getData());
        });
    }
    $.ajax({
        method: 'post',
        url: form.attr('action'),
        data: form.serializeArray(),
        dataType: 'json',
        success: function(result) {
            $main.removeErrors();
            if (result.status == 'OK') {
                $main.winStatus($trans.get('admin.base.label.saved'), true);
                document.location.href = self.getListPath();
            } else {
                $main.winStatus($trans.get('admin.base.label.invalid_data'), true, 'invalid');
                $main.showErrors(result.errors);
            }
            $('.nav-btn', form).prop('disabled', false);
        },
        error: function (xhr) {
            if (xhr.status === 401) {
                document.location.href = xhr.responseJSON.path;
            }
        }
    });
};

$main.initForm = function() {
    var self = this;
    $main.form = $('#edit-form');
    $main.form.submit(function() {
        self.save();
        return false;
    });

    $('.minimal-checkbox').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
};

$main.winStatus = function(text, autoClose, invalid) {
    var classStr = invalid ? 'invalid' : '';
    var winStatusBox = $('#win-status');
    winStatusBox.text(text).removeClass('invalid').addClass(classStr).show();
    if (autoClose) {
        setTimeout(function() {
            winStatusBox.hide();
        }, 500);
    }
};

$main.init = function() {
    var self = this;
    $(document).ready(function() {
        if ($('#data-table').length > 0) {
            self.initSearchPage();
        } else {
            self.initEditPage();
        }
    });
};

var $trans = function() {
    return $trans.get.apply(arguments);
};
$trans.transMap = null;

$trans.get = function (key, paramData) {
    try {
        if ($trans.transMap  == null) {
            var locSettings = $locSettings || {};
            $trans.transMap = locSettings.trans || {};
        }
        if (typeof $trans.transMap[key] != "undefined") {
            key = $trans.transMap[key];
            if (paramData) {
                for (var i in paramData) {
                    if (paramData.hasOwnProperty(i)) {
                        key = key.replace("{"+i+"}",paramData[i]);
                    }
                }
            }
            return key;
        }
    }
    catch(e){}
    return key;
};