var $commercial = $.extend(true, {}, $main);
$commercial.listPath = '/admpanel/commercial';
$commercial.creditIndex = 0;
$commercial.personIndex = 0;

$commercial.initSearchPage = function() {
    $commercial.listColumns = [
        {data: 'id'},
        {data: 'title'}
    ];
    $commercial.initSearch();
};

$commercial.makeAlias = function(title, aliasObj) {
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

$commercial.initType = function() {
    var videoBlock = $('#video-block'),
        printBlock = $('#print-block');
    $('#type-select').change(function() {
        if ($(this).val() == 'video') {
            printBlock.addClass('dn');
            videoBlock.removeClass('dn');
        } else if ($(this).val() == 'print') {
            videoBlock.addClass('dn');
            printBlock.removeClass('dn');
        } else {
            videoBlock.addClass('dn');
            printBlock.addClass('dn');
        }
    }).change();
};

$commercial.addTag = function(tag) {
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

$commercial.initTags = function() {
    var tag = $('#tag');
    tag.change(function() {
        if (tag.val()) {
            $commercial.addTag(tag.val());
        }
    });
    if (!$.isEmptyObject($commercial.tags)) {
        for (var i in $commercial.tags) {
            $commercial.addTag($commercial.tags[i].tag);
        }
    }
};

$commercial.addCredit = function() {
    var index = $commercial.creditIndex,
        personIndex = $commercial.personIndex,
        html;
    html =  '<div class="row">'+
                '<div class="col-sm-4">'+
                    '<input type="text" name="credits['+index+'][position]" class="form-control" value="" placeholder="'+$trans.get('admin.base.label.position')+'">'+
                '</div>'+
                '<div class="col-sm-2">'+
                    '<input type="text" name="credits['+index+'][sort_order]" class="form-control" value="">'+
                '</div>'+
                '<div class="col-sm-3">'+
                    '<select name="credits['+index+'][type]" class="form-control">'+
                        '<option value="creative">'+$trans.get('admin.base.label.creative')+'</option>'+
                        '<option value="brand">'+$trans.get('admin.base.label.brand')+'</option>'+
                        '<option value="agency">'+$trans.get('admin.base.label.agency')+'</option>'+
                    '</select>'+
                '</div>'+
                '<div class="col-sm-4">' +
                    '<input type="text" name="credits['+index+'][persons]['+personIndex+'][name]">'+
                    '<input type="hidden" name="credits['+index+'][persons]['+personIndex+'][name]">'+
                '</div>'+
            '</div>';
    html = $(html);
};

$commercial.initCredits = function() {
    $('#add-credit').on('click', function() {
        $commercial.addCredit();
        return false;
    });
};

$commercial.initEditPage = function() {

    $commercial.initForm();

    $('.title').change(function() {
        $commercial.makeAlias($(this).val(), $('.alias'));
    });

    $commercial.initType();

    $commercial.initTags();

    $commercial.initCredits();
};

$commercial.init();
