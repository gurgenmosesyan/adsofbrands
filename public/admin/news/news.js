var $news = $.extend(true, {}, $main);
$news.listPath = '/admpanel/news';
$news.imgIndex = 0;

$news.initSearchPage = function() {
    $news.listColumns = [
        {data: 'id'},
        {data: 'title'},
        {data: 'description'},
        {data: 'show_status'},
        {
            data: 'preview',
            sortable: false
        }
    ];
    if ($main.showAdminInfo) {
        $news.listColumns.push(
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
    $news.initSearch();
};

$news.makeAlias = function(title, aliasObj) {
    if ($.trim(aliasObj.val()) != '' || $.trim(title) == '') {
        return;
    }
    aliasObj.loading();
    $.ajax ({
        type : 'post',
        url	: '/admpanel/core/makeAlias',
        data : {
            title  : title,
            _token : $main.token
        },
        dataType : 'json',
        success	 : function (result) {
            aliasObj.removeLoading();
            if ($.trim(aliasObj.val()) != '') {
                return;
            }
            if (result.status == 'OK') {
                aliasObj.val(result.data);
            }
        }
    });
};

$news.generateTypeHtml = function(title, id, type) {
    var dataName = type == 'agency' ? 'agencies' : type+'s';
    var html =  '<div class="clearfix" style="margin-bottom: 2px;">'+
                    '<div class="col-sm-5" style="padding: 4px 7px;background: #eceaea;">'+
                        title+
                        '<input type="hidden" class="'+type+'-input" name="'+dataName+'[]['+type+'_id]" value="'+ id +'" />'+
                    '</div>'+
                    '<div class="col-sm-1 text-right" style="padding: 4px 7px;background: #eceaea;">'+
                        '<a href="#" class="remove"><i class="fa fa-remove"></i></a>'+
                    '</div>'+
                '</div>';
    html = $(html);
    $('.remove', html).click(function() {
        html.remove();
        return false;
    });
    $('#'+type+'-block').append(html);
};

$news.initTypeAutoComplete = function(type) {
    var input = $('#'+type+'-input');
    var onSelect = function (e,ui) {
        if (ui.item) {
            $news.generateTypeHtml(ui.item.label, ui.item.id, type);
        }
        input.val('');
        return false;
    };
    input.autocomplete({
        minLength : 1,
        source : function(request, response) {
            var skipIds = [];
            $('.'+type+'-input').each(function() {
                skipIds.push($(this).val());
            });
            input.loading();
            $.ajax({
                type: 'post',
                url: '/admpanel/'+type,
                dataType: 'json',
                data: {
                    search : {
                        title : request.term,
                        skip_ids: skipIds
                    },
                    _token : $main.token
                },
                success: function(result) {
                    response($.map(result.data, function(item) {
                        item.label = item.title;
                        return item;
                    }));
                    input.removeLoading();
                }
            });
        },
        select : onSelect,
        change : onSelect
    });
};

$news.generateTypes = function(data, type) {
    if (!$.isEmptyObject(data)) {
        for (var i in data) {
            $news.generateTypeHtml(data[i].title, data[i].id, type);
        }
    }
};

$news.addTag = function(tag) {
    if (!tag) {
        return;
    }
    var html =  '<div class="tag">'+
                    '#' + tag+
                    ' <a href="#" class="remove"><i class="fa fa-remove"></i></a>'+
                    '<input type="hidden" name="tags[][tag]" value="'+ tag +'">'+
                '</div>';
    html = $(html);
    $('.remove', html).on('click', function() {
        html.remove();
        return false;
    });
    $('#tags').append(html);
    $('#tag').val('');
};

$news.initTags = function() {
    var tag = $('#tag');
    tag.change(function() {
        $news.addTag(tag.val());
    });
    tag.keydown(function(e) {
        if (e.keyCode == 13 || e.keyCode == 9 ) {
            $news.addTag(tag.val());
            return false;
        }
    });
    if (!$.isEmptyObject($news.tags)) {
        for (var i in $news.tags) {
            $news.addTag($news.tags[i].tag);
        }
    }
};

$news.initFormUploaderForm = function(imgObj) {
    var html =  '<div id="iframe-img-uploader-block" style="display: none">'+
                    '<form target="iframe-uploader-'+ $news.imgIndex +'" action="/admpanel/core/image/upload" method="post" enctype="multipart/form-data">'+
                        '<input type="file" name="image" />'+
                        '<input type="text" name="module" value="'+ imgObj.data('module') +'" />'+
                        '<input type="hidden" name="_token" value="'+ $main.token +'" />'+
                    '</form>'+
                    '<iframe src="#" id="iframe-uploader-'+ $news.imgIndex +'" name="iframe-uploader-'+ $news.imgIndex +'" style="display: none;"></iframe>'+
                '</div>';
    html = $(html);
    $('input[type="file"]', html).change(function() {
        $('form', html).submit();
    });
    $('form', html).submit(function() {
        $('iframe', html).load(function() {
            var result = $.parseJSON($(this.contentDocument).find('body').html());
            $('.form-error', imgObj).text('');
            imgObj.parents('.form-group').removeClass('has-error');
            if (result.status == 'OK') {
                $('.img-uploader-id', imgObj).val(result.data.id);
                $('.img-uploader-image', imgObj).attr('src', result.data.img_path);
            } else {
                $('.form-error', imgObj).text(result.data.error).addClass('form-error-text').show();
                imgObj.parents('.form-group').addClass('has-error');
            }
        });
    });
    $('body').append(html);
    $('input[type="file"]', html).trigger('click');
};

$news.initImageButtons = function(html) {
    $('.uploader-upload-btn', html).on('click', function() {
        $('#iframe-img-uploader-block').remove();
        $news.initFormUploaderForm($(this).parents('.img-uploader-box'));
        return false;
    });

    $('.uploader-remove-btn', html).on('click', function() {
        $('#iframe-img-uploader-block').remove();
        var imgObj = $(this).parents('.img-uploader-box');
        $('.img-uploader-id', imgObj).val('');
        $('.img-uploader-image', imgObj).attr('src', '/core/images/img-default.png');
        return false;
    });
};
$news.addImage = function(obj) {
    var imgVal = '',
        imgId = '',
        imgSrc = '/core/images/img-default.png';
    if (obj) {
        imgVal = 'same';
        imgId = obj.id;
        imgSrc = '/images/news/'+obj.image;
    }
    var html =  '<div data-module="news.images.images" data-image_key="images" class="img-uploader-box" style="margin-bottom:10px;">'+
                    '<div class="img-thumbnail image-container">'+
                        '<img src="'+ imgSrc +'" class="img-uploader-image img-agent-photo" style="max-height:120px;" />'+
                    '</div>'+
                    '<div class="img-uploader-tools">'+
                        '<a href="#" class="btn btn-default btn-xs uploader-upload-btn">'+ $trans.get('core.img.uploader.upload_btn') +'</a> '+
                        '<a href="#" class="btn btn-default btn-xs uploader-remove-btn">'+ $trans.get('core.img.uploader.remove_btn') +'</a>'+
                    '<div class="img-uploader-help">'+ $news.imgHelpText +'</div>'+
                    '</div>'+
                        '<input type="hidden" name="images['+ $news.imgIndex +'][image]" class="img-uploader-id" value="'+ imgVal +'" />'+
                        '<input type="hidden" name="images['+ $news.imgIndex +'][id]" value="'+ imgId +'" />'+
                    '<div class="form-error form-error-text" id="form-error-images_'+ $news.imgIndex +'"></div>'+
                '</div>';
    html = $(html);
    $news.initImageButtons(html);
    $('#images-block').append(html);
    $news.imgIndex++;
};

$news.initAlbum = function() {
    $('#add-image').on('click', function() {
        $news.addImage();
        return false;
    });

    if (!$.isEmptyObject($news.images)) {
        for (var i in $news.images) {
            $news.addImage($news.images[i]);
        }
    }
};

$news.initEditPage = function() {

    $news.initForm();

    $('.title').change(function() {
        $news.makeAlias($(this).val(), $('.alias'));
    });

    $news.initTypeAutoComplete('brand');
    $news.generateTypes($news.brands, 'brand');

    $news.initTypeAutoComplete('agency');
    $news.generateTypes($news.agencies, 'agency');

    $news.initTypeAutoComplete('creative');
    $news.generateTypes($news.creatives, 'creative');

    $news.initTags();

    $news.initAlbum();

    //CKEDITOR.config.height = 120;
};

$news.init();
