var $commercial = $.extend(true, {}, $main);
$commercial.listPath = '/admpanel/commercial';
$commercial.creditIndex = 0;
$commercial.personIndex = 0;
$commercial.advertisingIndex = 0;

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
    var input = html.find('.name'),
        hiddenInput = html.find('.name-hidden');
    var onSelect = function (e,ui) {
        if (ui.item) {
            hiddenInput.val(ui.item.id);
        } else {
            hiddenInput.val('');
            if (input.val().substr(0, 1) == '@') {
                input.val('');
            }
        }
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
            html.closest('.persons').find('.clearfix').each(function() {
                var self = $(this);
                if ($('.type', self).val() == html.find('.type').val() && $('.name', self).val().substr(0, 1) == '@') {
                    skipIds.push($('.name-hidden', self).val());
                }
            });
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

$commercial.addCreditPerson = function(personsBox, index, addBtn, obj) {
    var personIndex = $commercial.personIndex,
        html,
        btnHtml,
        type = '',
        name = '',
        typeId = '',
        separator = ',';
    if (obj) {
        type = obj.type;
        name = obj.name;
        typeId= obj.type_id;
        separator = obj.separator;
    }
    if (addBtn) {
        btnHtml = '<a href="#" class="btn btn-default add-person"><i class="fa fa-plus"></i></a>';
    } else {
        btnHtml = '<a href="#" class="btn btn-default remove-person"><i class="fa fa-remove"></i></a>';
    }
    html =  '<div class="clearfix">'+
                '<div class="col-sm-3 no-padding">'+
                    '<select name="credits['+index+'][persons]['+personIndex+'][type]" class="type form-control">'+
                        '<option value="creative"'+ (type == 'creative' ? ' selected="selected"' : '') +'>'+$trans.get('admin.base.label.creative')+'</option>'+
                        '<option value="brand"'+ (type == 'brand' ? ' selected="selected"' : '') +'>'+$trans.get('admin.base.label.brand')+'</option>'+
                        '<option value="agency"'+ (type == 'agency' ? ' selected="selected"' : '') +'>'+$trans.get('admin.base.label.agency')+'</option>'+
                    '</select>'+
                    '<div id="form-error-credits_'+index+'_persons_'+personIndex+'_type" class="form-error"></div>'+
                '</div>'+
                '<div class="col-sm-5 no-padding">' +
                    '<input type="text" name="credits['+index+'][persons]['+personIndex+'][name]" class="name form-control" value="'+name+'" placeholder="'+$trans.get('admin.base.label.name')+'">'+
                    '<input type="hidden" name="credits['+index+'][persons]['+personIndex+'][type_id]" class="name-hidden" value="'+typeId+'">'+
                    '<div id="form-error-credits_'+index+'_persons_'+personIndex+'_name" class="form-error"></div>'+
                    '<div id="form-error-credits_'+index+'_persons_'+personIndex+'_type_id" class="form-error"></div>'+
                '</div>'+
                '<div class="col-sm-1 no-padding separator">'+
                    '<input type="text" name="credits['+index+'][persons]['+personIndex+'][separator]" class="form-control" value="'+separator+'">'+
                    '<div id="form-error-credits_'+index+'_persons_'+personIndex+'_separator" class="form-error"></div>'+
                '</div>'+
                    '<div class="col-sm-1 no-padding">'+
                    btnHtml+
                '</div>'+
            '</div>';
    html = $(html);
    $('.remove-person', html).on('click', function() {
        html.remove();
        return false;
    });
    $commercial.creditAutoComplete(html);
    personsBox.append(html);
    $commercial.personIndex++;
};

$commercial.addCredit = function(obj) {
    var index = $commercial.creditIndex,
        html,
        position = '',
        sortOrder = '',
        type = '';
    if (obj) {
        position = obj.position;
        sortOrder = obj.sort_order;
        type = obj.type;
    }
    html =  '<div class="clearfix">'+
                '<div class="col-sm-3 no-padding">'+
                    '<input type="text" name="credits['+index+'][position]" class="form-control" value="'+position+'" placeholder="'+$trans.get('admin.base.label.position')+'">'+
                    '<div id="form-error-credits_'+index+'_position" class="form-error"></div>'+
                '</div>'+
                '<div class="col-sm-1 no-padding sort-order">'+
                    '<input type="text" name="credits['+index+'][sort_order]" class="form-control" value="'+sortOrder+'" placeholder="'+$trans.get('admin.base.label.sort')+'">'+
                    '<div id="form-error-credits_'+index+'_sort_order" class="form-error"></div>'+
                '</div>'+
                '<div class="col-sm-7 no-padding persons">'+
                '</div>'+
                '<div class="col-sm-1 no-padding last">'+
                    '<a href="#" class="btn btn-default remove-credit"><i class="fa fa-remove"></i></a>'+
                '</div>'+
            '</div>';
    html = $(html);
    if (obj) {
        var j = 0,
            addBtn;
        for (var i in obj.persons) {
            addBtn = j == 0 ? true : false;
            $commercial.addCreditPerson($('.persons', html), index, addBtn, obj.persons[i]);
            j++;
        }
    } else {
        $commercial.addCreditPerson($('.persons', html), index, true);
    }
    $('.remove-credit', html).on('click', function() {
        html.remove();
        return false;
    });
    $('.add-person', html).on('click', function() {
        $commercial.addCreditPerson($('.persons', html), index);
        return false;
    });
    $('#credits').append(html);
    $commercial.creditIndex++;
};

$commercial.initCredits = function() {
    $('#add-credit').on('click', function() {
        $commercial.addCredit();
        return false;
    });
    for (var i in $commercial.credits) {
        $commercial.addCredit($commercial.credits[i]);
    }
};

$commercial.addAdvertising = function(obj) {
    var index = $commercial.advertisingIndex,
        advBox = $('#adv-info'),
        html,
        name = '',
        link = '';
    if (obj) {
        name = obj.name;
        link = obj.link;
    }
    html =  '<div class="row" style="margin-bottom: 10px;">'+
                '<div class="col-sm-4">'+
                    '<input type="text" name="advertisings['+index+'][name]" class="form-control" value="'+name+'" placeholder="'+$trans.get('admin.base.label.name')+'">'+
                    '<div id="form-error-advertisings_'+index+'_name" class="form-error"></div>'+
                '</div>'+
                '<div class="col-sm-4">'+
                    '<input type="text" name="advertisings['+index+'][link]" class="form-control" value="'+link+'" placeholder="'+$trans.get('admin.base.label.link')+'">'+
                    '<div id="form-error-advertisings_'+index+'_link" class="form-error"></div>'+
                '</div>'+
                '<div class="col-sm-1">'+
                    '<a href="#" class="btn btn-default remove"><i class="fa fa-remove"></i></a>'+
                '</div>'+
            '</div>';
    html = $(html);
    $('.remove', html).on('click', function() {
        html.remove();
        if (advBox.find('.row').length == 0) {
            $('#advertisings').addClass('dn');
        }
        return false;
    });
    advBox.append(html);
    $commercial.advertisingIndex++;
    $('#advertisings').removeClass('dn');
};

$commercial.initAdvertising = function() {
    $('#add-advertising').on('click', function() {
        $commercial.addAdvertising();
        return false;
    });
    for (var i in $commercial.advertisings) {
        $commercial.addAdvertising($commercial.advertisings[i]);
    }
};

$commercial.generateTypeHtml = function(title, id, type) {
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

$commercial.initTypeAutoComplete = function(type) {
    var input = $('#'+type+'-input');
    var onSelect = function (e,ui) {
        if (ui.item) {
            $commercial.generateTypeHtml(ui.item.label, ui.item.id, type);
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

$commercial.generateTypes = function(data, type) {
    if (!$.isEmptyObject(data)) {
        for (var i in data) {
            $commercial.generateTypeHtml(data[i].title, data[i].id, type);
        }
    }
};

$commercial.initEditPage = function() {

    $commercial.initForm();

    $('.title').change(function() {
        $commercial.makeAlias($(this).val(), $('.alias'));
    });

    $commercial.initType();

    $commercial.initTypeAutoComplete('brand');
    $commercial.generateTypes($commercial.brands, 'brand');

    $commercial.initTypeAutoComplete('agency');
    $commercial.generateTypes($commercial.agencies, 'agency');

    $commercial.initTags();

    $commercial.initAdvertising();

    $commercial.initCredits();
};

$commercial.init();
