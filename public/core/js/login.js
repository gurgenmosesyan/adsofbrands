var $login = {};

$login.removeErrors = function() {
    $('.form-error', $login.form).text('');
    $('.form-group', $login.form).removeClass('has-error');
};

$login.showErrors = function(errors) {
    for (var i in errors) {
        $('#form-error-'+i.replace(/\./g, '_')).text(errors[i][0]).closest('.form-group').addClass('has-error');
    }
};

$login.init = function() {
    $login.form = $('#login-form');
    $login.form.submit(function() {
        if ($('button', $login.form).prop('disabled')) {
            return false;
        }
        $('button', $login.form).prop('disabled', true);
        $.ajax({
            type: 'post',
            url: $login.form.attr('action'),
            data: $login.form.serializeArray(),
            dataType: 'json',
            success: function(result) {
                $login.removeErrors();
                if (result.status == 'OK') {
                    document.location.href = result.data.path;
                } else {
                    $login.showErrors(result.errors);
                }
                $('button', $login.form).prop('disabled', false);
            }
        });
        return false;
    });
};

$(document).ready(function() {
    $login.init();
});
