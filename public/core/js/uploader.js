$uploader = {};
$uploader.index = 1;
//$uploader.cropData = {};

$uploader.initForm = function(imgObj) {
    var html =  '<div id="iframe-img-uploader-block" style="display: none">'+
                    '<form target="iframe-uploader-'+ $uploader.index +'" action="/admpanel/core/image/upload" method="post" enctype="multipart/form-data">'+
                        '<input type="file" name="image" />'+
                        '<input type="text" name="module" value="'+ imgObj.data('module') +'" />'+
                        '<input type="hidden" name="_token" value="'+ $main.token +'" />'+
                    '</form>'+
                    '<iframe src="#" id="iframe-uploader-'+ $uploader.index +'" name="iframe-uploader-'+ $uploader.index +'" style="display: none;"></iframe>'+
                '</div>';

    html = $(html);
    $('input[type="file"]', html).change(function() {
        $('form', html).submit();
    });

    $('form', html).submit(function() {

        $('iframe', html).load(function(){

            var result = $.parseJSON($(this.contentDocument).find('body').html());

            $('.form-error', imgObj).text('');
            imgObj.parents('.form-group').removeClass('has-error');

            if (result.status == 'OK') {
                $('.img-uploader-id', imgObj).val(result.data.id);
                $('.img-uploader-image', imgObj).attr('src', result.data.img_path);
                //$('.uploader-crop-btn', imgObj).removeClass('dn');
            } else {
                $('.form-error', imgObj).text(result.data.error);
                imgObj.parents('.form-group').addClass('has-error');
            }
        });
    });

    $('body').append(html);
    $('input[type="file"]', html).trigger('click');
};

/*$uploader.initCropper = function(imgObj) {

    var aspectRatio = '',
        minCropBoxWidth = 0,
        minCropBoxHeight = 0;

    if ($cropper[imgObj.data('image_key')]) {
        var options = $cropper[imgObj.data('image_key')];
        aspectRatio = options.ratio ? options.ratio : '';
        minCropBoxWidth = options.min_width ? options.min_width : 0;
        minCropBoxHeight = options.min_height ? options.min_height : 0;
    }

    $('.img-uploader-image', imgObj).cropper({
        aspectRatio: aspectRatio,
        minCropBoxWidth: minCropBoxWidth,
        minCropBoxHeight: minCropBoxHeight,
        zoomable: false,
        toggleDragModeOnDblclick: false,
        crop: function(data) {
            $uploader.cropData = data;
        }
    });

    $('.crop-rotate-left', imgObj).removeClass('dn').unbind().click(function() {
        $('.img-uploader-image', imgObj).cropper('rotate', -90);
        return false;
    });
    $('.crop-rotate-right', imgObj).removeClass('dn').unbind().click(function() {
        $('.img-uploader-image', imgObj).cropper('rotate', 90);
        return false;
    });
    $('.crop-save-btn', imgObj).removeClass('dn').unbind().click(function() {
        $uploader.saveCropImage(imageObj.attr('src'));
        return false;
    });
    $('.crop-cancel-btn', imgObj).removeClass('dn').unbind().click(function() {
        $('.img-uploader-image', imgObj).cropper('destroy');
        $(this).addClass('dn');
        $('.crop-save-btn, .crop-rotate-left, .crop-rotate-right', imgObj).addClass('dn');
        $('.uploader-crop-btn', imgObj).removeClass('dn');
        return false;
    });
};*/

$uploader.init = function() {
    $('.uploader-upload-btn').on('click', function() {
        $('#iframe-img-uploader-block').remove();
        $uploader.initForm($(this).parents('.img-uploader-box'));
        return false;
    });

    $('.uploader-remove-btn').on('click', function() {
        $('#iframe-img-uploader-block').remove();
        var imgObj = $(this).parents('.img-uploader-box');
        $('.img-uploader-id', imgObj).val('');
        $('.img-uploader-image', imgObj).attr('src', '/core/images/img-default.png');
        /*if ($('.uploader-crop-btn').length > 0) {
            $('.img-uploader-image', imgObj).cropper('destroy');
            $('.uploader-crop-btn, .crop-save-btn, .crop-rotate-left, .crop-rotate-right, .crop-cancel-btn', imgObj).addClass('dn');
        }*/
        return false;
    });

    /*$('.uploader-crop-btn').on('click', function() {
        $(this).addClass('dn');
        $uploader.initCropper($(this).parents('.img-uploader-box'));
        return false;
    });*/
};

$(document).ready(function() {
    $uploader.init();
});