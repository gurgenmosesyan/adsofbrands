var $account = {};

$account.resetErrors = function(form) {
    form.find('.form-box').removeClass('has-error');
    form.find('.form-error').text('');
};

$account.showErrors = function(errors) {
    for (var i in errors) {
        $('#form-error-'+i.replace(/\./g, '_')).text(errors[i][0]).closest('.form-box').addClass('has-error');
    }
};

$account.sendForm = function(form, callback) {
    if (form.hasClass('sending')) {
        return false;
    }
    form.addClass('sending');
    $.ajax({
        type: 'post',
        url: form.attr('action'),
        data: form.serializeArray(),
        dataType: 'json',
        success: function(result) {
            $account.resetErrors(form);
            if (result.status == 'OK') {
                callback(result.data);
            } else {
                $account.showErrors(result.errors);
            }
            form.removeClass('sending');
        }
    });
};

$account.init = function() {
    $('#register-form').submit(function() {
        var form = $(this);
        $account.sendForm(form, function(data) {
            alert(data.text);
            form.find('input:text, input:password').val('');
        });
        return false;
    });
    $('#login-form').submit(function() {
        $account.sendForm($(this), function(data) {
            document.location.href = data.link;
        });
        return false;
    });
    $('#forgot-form').submit(function() {
        $account.sendForm($(this), function(data) {
            alert(data.text);
            form.find('input:text').val('');
        });
        return false;
    });
    $('#reset-form').submit(function() {
        $account.sendForm($(this), function(data) {
            alert(data.text);
            document.location.href = data.link;
        });
        return false;
    });
};

$(document).ready(function() {
    $account.init();
});
