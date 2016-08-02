var $vacancy = $.extend(true, {}, $main);
$vacancy.listPath = '/admpanel/vacancy';

$vacancy.initSearchPage = function() {
    $vacancy.listColumns = [
        {data: 'id'},
        {data: 'title'},
        {data: 'function'}
    ];
    $vacancy.initSearch();
};

$vacancy.initEditPage = function() {

    $vacancy.initForm();

    $('#asap').on('ifChanged', function() {
        if ($(this).prop('checked')) {
            $('#start-date input:text').attr('disabled', 'disabled').val('');
        } else {
            $('#start-date input:text').attr('disabled', false);
        }
    }).trigger('ifChanged');
};

$vacancy.init();
