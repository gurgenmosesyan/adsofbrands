var $about = $.extend(true, {}, $main);
$about.listPath = '/admpanel/about';

$about.initEditPage = function() {

    $about.initForm();

    CKEDITOR.config.height = 120;
};

$about.init();
