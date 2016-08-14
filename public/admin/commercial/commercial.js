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

$commercial.initTags = function() {
    var tag = $('#tag');
    tag.change(function() {
        $commercial.addTag(tag.val());
    });
    tag.keydown(function(e) {
        if (e.keyCode == 13 || e.keyCode == 9 ) {
            $commercial.addTag(tag.val());
            return false;
        }
    });
    if (!$.isEmptyObject($commercial.tags)) {
        for (var i in $commercial.tags) {
            $commercial.addTag($commercial.tags[i].tag);
        }
    }
};

$commercial.creditAutoComplete = function(html) {
    //var input = $('#'+type+'-input');
    var input = html.find('.name'),
        hiddenInput = html.find('.name-hidden');
    var onSelect = function (e,ui) {
        if (ui.item) {
            input.val(ui.item.label);
            hiddenInput.val(ui.item.id);
        } else {
            input.val('');
            hiddenInput.val('');
        }
        //return false;
    };
    input.autocomplete({
        minLength : 1,
        source : function(request, response) {
            var searchVal = request.term;
            if (searchVal.substr(0, 1) != '@' || searchVal.length < 3) {
                return;
            }
            searchVal = searchVal.substr(1);
            var url = html.find('.type').val();
            var skipIds = [];
            /*$('.'+type+'-input').each(function() {
                skipIds.push($(this).val());
            });*/
            input.loading();
            $.ajax({
                type: 'post',
                url: '/admpanel/'+url,
                dataType: 'json',
                data: {
                    search : {
                        title : searchVal,
                        skip_ids: skipIds
                    },
                    _token : $main.token
                },
                success: function(result) {
                    response($.map(result.data, function(item) {
                        item.label = '@'+item.title;
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

$commercial.addCreditPerson = function(personsBox, index) {
    var personIndex = $commercial.personIndex,
        html;
    html =  '<div class="clearfix">'+
                 '<div class="col-sm-3 no-padding">'+
                    '<select name="credits['+index+'][persons]['+personIndex+'][type]" class="type form-control">'+
                         '<option value="creative">'+$trans.get('admin.base.label.creative')+'</option>'+
                         '<option value="brand">'+$trans.get('admin.base.label.brand')+'</option>'+
                         '<option value="agency">'+$trans.get('admin.base.label.agency')+'</option>'+
                    '</select>'+
                    '<div id="form-error-credits_'+index+'_persons_'+personIndex+'_type" class="form-error"></div>'+
                 '</div>'+
                 '<div class="col-sm-5 no-padding">' +
                     '<input type="text" name="credits['+index+'][persons]['+personIndex+'][name]" class="name form-control" value="" placeholder="'+$trans.get('admin.base.label.name')+'">'+
                     '<input type="hidden" name="credits['+index+'][persons]['+personIndex+'][type_id]" class="name-hidden">'+
                     '<div id="form-error-credits_'+index+'_persons_'+personIndex+'_name" class="form-error"></div>'+
                     '<div id="form-error-credits_'+index+'_persons_'+personIndex+'_type_id" class="form-error"></div>'+
                 '</div>'+
                 '<div class="col-sm-1 no-padding separator">'+
                     '<input type="text" name="credits['+index+'][persons]['+personIndex+'][separator]" class="form-control" value=",">'+
                     '<div id="form-error-credits_'+index+'_persons_'+personIndex+'_separator" class="form-error"></div>'+
                 '</div>'+
                     '<div class="col-sm-1 no-padding">'+
                     '<a href="#" class="btn btn-default remove"><i class="fa fa-remove"></i></a>'+
                 '</div>'+
            '</div>';
    html = $(html);
    $('.remove', html).on('click', function() {
        html.remove();
        return false;
    });
    $commercial.creditAutoComplete(html);
    personsBox.append(html);
    $commercial.personIndex++;
};

$commercial.addCredit = function() {
    var index = $commercial.creditIndex,
        personIndex = $commercial.personIndex,
        html;
    html =  '<div class="clearfix">'+
                '<div class="col-sm-3 no-padding">'+
                    '<input type="text" name="credits['+index+'][position]" class="form-control" value="" placeholder="'+$trans.get('admin.base.label.position')+'">'+
                    '<div id="form-error-credits_'+index+'_position" class="form-error"></div>'+
                '</div>'+
                '<div class="col-sm-1 no-padding sort-order">'+
                    '<input type="text" name="credits['+index+'][sort_order]" class="form-control" value="" placeholder="'+$trans.get('admin.base.label.sort')+'">'+
                    '<div id="form-error-credits_'+index+'_sort_order" class="form-error"></div>'+
                '</div>'+
                '<div class="col-sm-7 no-padding persons">'+
                    '<div class="clearfix">'+
                        '<div class="col-sm-3 no-padding">'+
                            '<select name="credits['+index+'][persons]['+personIndex+'][type]" class="type form-control">'+
                                '<option value="creative">'+$trans.get('admin.base.label.creative')+'</option>'+
                                '<option value="brand">'+$trans.get('admin.base.label.brand')+'</option>'+
                                '<option value="agency">'+$trans.get('admin.base.label.agency')+'</option>'+
                            '</select>'+
                            '<div id="form-error-credits_'+index+'_persons_'+personIndex+'_type" class="form-error"></div>'+
                        '</div>'+
                        '<div class="col-sm-5 no-padding">' +
                            '<input type="text" name="credits['+index+'][persons]['+personIndex+'][name]" class="name form-control" value="" placeholder="'+$trans.get('admin.base.label.name')+'">'+
                            '<input type="hidden" name="credits['+index+'][persons]['+personIndex+'][type_id]" class="name-hidden">'+
                            '<div id="form-error-credits_'+index+'_persons_'+personIndex+'_name" class="form-error"></div>'+
                            '<div id="form-error-credits_'+index+'_persons_'+personIndex+'_type_id" class="form-error"></div>'+
                        '</div>'+
                        '<div class="col-sm-1 no-padding separator">'+
                            '<input type="text" name="credits['+index+'][persons]['+personIndex+'][separator]" class="form-control" value=",">'+
                            '<div id="form-error-credits_'+index+'_persons_'+personIndex+'_separator" class="form-error"></div>'+
                        '</div>'+
                        '<div class="col-sm-1 no-padding">'+
                            '<a href="#" class="btn btn-default add-person"><i class="fa fa-plus"></i></a>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<div class="col-sm-1 no-padding last">'+
                    '<a href="#" class="btn btn-default remove"><i class="fa fa-remove"></i></a>'+
                '</div>'+
            '</div>';
    html = $(html);
    $('.remove', html).on('click', function() {
        html.remove();
        return false;
    });
    $commercial.creditAutoComplete(html);
    $('.add-person', html).on('click', function() {
        $commercial.addCreditPerson($('.persons', html), index);
        return false;
    });
    $('#credits').append(html);
    $commercial.creditIndex++;
    $commercial.personIndex++;
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
