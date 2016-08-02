var $homepage = $.extend(true, {}, $main);
$homepage.listPath = '/admpanel/homepage';

$homepage.initEditPage = function() {

    $homepage.initForm();

    CKEDITOR.config.height = 120;
};

$homepage.init();
