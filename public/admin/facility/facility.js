var $facility = $.extend(true, {}, $main);
$facility.listPath = '/admpanel/facility';
$facility.imgIndex = 0;

$facility.initSearchPage = function() {
    $facility.listColumns = [
        {data: 'id'},
        {data: 'title'},
        {data: 'sort_order'}
    ];
    $facility.order = [[2, "asc"]];
    $facility.initSearch();
};

$facility.initUploaderForm = function() {
    var html =  '<div id="iframe-img-uploader" style="display: none">'+
                    '<form target="iframe-uploader" action="/admpanel/core/image/upload" method="post" enctype="multipart/form-data">'+
                        '<input type="file" name="image" />'+
                        '<input type="text" name="module" value="facility.images.image" />'+
                        '<input type="hidden" name="_token" value="'+ $main.token +'" />'+
                    '</form>'+
                    '<iframe src="#" id="iframe-uploader" name="iframe-uploader" style="display: none;"></iframe>'+
                '</div>';
    html = $(html);
    $('input[type="file"]', html).change(function() {
        $('form', html).submit();
    });
    $('form', html).submit(function() {
        $('iframe', html).load(function() {
            var result = $.parseJSON($(this.contentDocument).find('body').html());
            var errorObj = $('#form-error-images');
            var groupObj = $('#image-group');
            errorObj.text('');
            groupObj.removeClass('has-error');

            if (result.status == 'OK') {
                $facility.addImage(result.data.img_path, result.data.id);
            } else {
                errorObj.text(result.data.error);
                groupObj.addClass('has-error');
            }
        });
    });
    $('body').append(html);
    $('input[type="file"]', html).trigger('click');
};

$facility.addImage = function(imgPath, imgVal, id) {
    var idStr = id ? '<input type="hidden" name="images['+ $facility.imgIndex +'][id]" value="'+ id +'" />' : '';
    var html =  '<div class="img-thumbnail img-block">'+
                    '<div class="img-item">'+
                        '<img class="uploaded-image" src="'+ imgPath +'" />'+
                    '</div>'+
                        '<input type="hidden" name="images['+ $facility.imgIndex +'][image]" value="'+ imgVal +'" />'+
                        idStr+
                    '<div class="img-tools text-center">'+
                        '<a href="#" class="btn btn-xs btn-danger delete-img"><i class="fa fa-remove"></i></a>'+
                    '</div>'+
                '</div>';
    html = $(html);
    $facility.initImageTools(html);
    $('#images-block').append(html);
    $facility.imgIndex++;
};

$facility.initImageTools = function(html) {
    $('.delete-img', html).on('click', function() {
        html.remove();
        return false;
    });
};

$facility.generateImages = function() {
    if (!$.isEmptyObject($facility.images)) {
        for (var i in $facility.images) {
            var imgPath = '/images/facility/'+$facility.images[i].image;
            $facility.addImage(imgPath, 'same', $facility.images[i].id);
        }
    }
};

$facility.initImageUpload = function() {
    $('#upload-image').on('click', function() {
        $('#iframe-img-uploader').remove();
        $facility.initUploaderForm();
        return false;
    });

    $facility.generateImages();
};

$facility.initEditPage = function() {

    $facility.initForm();

    $facility.initImageUpload();

    CKEDITOR.config.height = 120;
};

$facility.init();
