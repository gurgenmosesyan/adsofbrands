var $slider = $.extend(true, {}, $main);

$slider.initSearchPage = function() {
    $slider.listColumns = [
        {data: 'id'},
        {data: 'facility_title'},
        {data: 'sort_order'}
    ];
    $slider.order = [[2, "asc"]];
    $slider.initSearch();
};

$slider.initEditPage = function() {
    $slider.initForm();
};

$slider.init();
