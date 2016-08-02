$(document).ready(function() {

    $('.date').datepicker({
        todayHighlight: true,
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('changeDate', function(e) {
        var _d = e.date.getDate(),
            d = _d > 9 ? _d : '0'+_d,
            _m = e.date.getMonth()+1,
            m = _m > 9 ? _m : '0'+_m,
            formatted = e.date.getFullYear() + '-' + m + '-' + d;
        $(this).next().val(formatted);
    }).change(function(e) {
        if (!$(this).val()) {
            $(this).next().val('');
        }
    });

});
