var $text = $.extend(true, {}, $main);
$text.listPath = '/admpanel/offer/text';

$text.initEditPage = function() {

    $text.initForm();

    CKEDITOR.config.height = 120;
};

$text.init();
