(function() {
    "use strict";
    $.widget( "ui.searchSelectBox", $.ui.autocomplete, {
        options: {
            delay : 0,
//            searchKey : '',
            containerTemplate :	'<div class="ui-search-select-box" >'
            +'<input class="ui-search-select" type="text" value="" />'
            +'<i class="fa fa-remove icon-remove ui-search-select-remove-btn"></i>'
            +'<input class="ui-search-select-val" type="hidden" value="" />'
            +'</div>',
            select: function( event, ui ) {
                var self = $(this).data('searchSelectBox');
                $('.ui-search-select-val', self.container).val(ui.item.id);
                $('.ui-search-select', self.container).val(ui.item.label);
                self._refresh();
                self._trigger( "onChange", event, ui);
                return false;
            },
            change : function( event, ui ) {
                var self = $(this).data('searchSelectBox');
                if (ui.item) {
                    $('.ui-search-select-val', self.container).val(ui.item.id);
                    $('.ui-search-select', self.container).val(ui.item.label);
                } else {
                    $('.ui-search-select-val', self.container).val('');
                    $('.ui-search-select', self.container).val('');
                }
                self._refresh();
                self._trigger( "onChange", event, ui);
                return false;
            }
        },

        _create : function(){
            var self = this;
            self._setup();
            this._super();
        },

        _setup : function(){
            this._createContainer();
            this._initRemoveAction();
            this._refresh();
        },

        _createContainer : function(){
            var self = this,
                elementValue = self.element.data('value') || '';
            self.element.data('searchSelectBox', this);
            self.container = $(self.options.containerTemplate);
            self.container.insertAfter(self.element);
            self.element.addClass('ui-search-select');
            $(".ui-search-select", self.container).replaceWith(self.element);
            $(".ui-search-select-val", self.container)
                .attr('name', $(self.element).attr('name'))
                .val(elementValue);
            $(self.element).removeAttr('name');
        },

        _initRemoveAction : function() {
            var self = this;
            $('.ui-search-select-remove-btn', self.container).click(function(){
                $(".ui-search-select-val", self.container).val('');
                $(".ui-search-select", self.container).val('');
                self._refresh();
            });
        },

        _refresh:function(){
            var self = this;
            if ($(".ui-search-select-val", self.container).val()==='') {
                $(".ui-search-select-remove-btn", self.container).hide();
            } else {
                $(".ui-search-select-remove-btn", self.container).show();
            }
        },

        setValue : function(value, label){
            $('.ui-search-select-val', this.container).val(value);
            $('.ui-search-select', this.container).val(label);
            this._refresh();
        }
    });
})();