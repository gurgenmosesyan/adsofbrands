var $banner = $.extend(true, {}, $main);
$banner.listPath = '/admpanel/banner';

$banner.initSearchPage = function() {
    $banner.listColumns = [
        {data: 'key'},
        {data: 'type'}
    ];
    if ($main.showAdminInfo) {
        $banner.listColumns.push(
            {
                data: 'created_by',
                sortable: false
            },
            {
                data: 'updated_by',
                sortable: false
            }
        );
    }
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
