var $banner = $.extend(true, {}, $main);
$banner.listPath = '/admpanel/banner';

$banner.initSearchPage = function() {
    $banner.listColumns = [
        {data: 'key'},
        {data: 'type'}
    ];
    $banner.actions = {
        "data": null,
        "render": function(data) {
            return '<div class="text-center"><a href="'+ $banner.listPath +'/edit/'+data.id+'"><i class="fa fa-pencil"></i></a></div>';
        },
        "orderable": false
    };
    $banner.initSearch();
};

$banner.initType = function() {
    var image = $('#image'),
        embed = $('#embed');
    $('#type').change(function() {
        image.addClass('dn');
        embed.addClass('dn');
        if ($(this).val() == 'image') {
            image.removeClass('dn');
        } else if ($(this).val() == 'embed') {
            embed.removeClass('dn');
        }
    }).change();
};

$banner.initEditPage = function() {

    $banner.initForm();

    $banner.initType();
};

$banner.init();
