(function() {
// config multselect init
    var AWA_ConfigMultiSelect = function(plugins) {
        this.afterInit = function() {
            var self = this;
            var $selectableSearch = self.$selectableUl.prev(); // input sherch <input  type='search'  class='search-input .....
            var $selectionSearch = self.$selectionUl.prev();
            var selectableSearchString = '#' + self.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)'; // select par id (id Math.random())
            var selectionSearchString = '#' + self.$container.attr('id') + ' .ms-elem-selection.ms-selected';
            this.qs1 = $selectableSearch.quicksearch(selectableSearchString).on('keydown', function(e) {
                if (e.which === 40) {
                    self.$selectableUl.focus();
                    return false;
                }
            });
            this.qs2 = $selectionSearch.quicksearch(selectionSearchString).on('keydown', function(e) {
                if (e.which == 40) {
                    self.$selectionUl.focus();
                    return false;
                }
            });
            this.Calcule = plugins.Calcule;
            this.Graph = plugins.Graph;
            this.Graph && this.Graph.show(this.$element);
        };
        this.afterSelect = function(values, item) {
            this.qs1.cache();
            this.qs2.cache();
            this.Graph && this.Graph.show(this.$element);
            this.Calcule.calcule(function(a, b) {
                return ((a + b).toFixed(2));
            }, item.data());



        };
        this.afterDeselect = function(values, item) {
            this.qs1.cache();
            this.qs2.cache();
            this.Graph && this.Graph.show(this.$element);
            this.Calcule.calcule(function(a, b) {
                return ((a - b).toFixed(2));
            }, item.data());


        }


    }
    AWA_ConfigMultiSelect.prototype = {
        //selectableFooter: "<div class='searchable'>Selectable footer</div>",
        //selectionFooter: "<div class='searchable'>Selection footer</div>",
        "selectableHeader": "<input  type='search'  class='search-input img-thumbnail bg-info' autocomplete='off' placeholder='Rechercher'>",
        "selectionHeader": "<input type='search'   class='search-input img-thumbnail bg-info' autocomplete='off' placeholder='Rechercher'>",
        "dblClick": true,
        "cssClass": 'classjs_set_by_js_config'

    }

    window.AWA_ConfigMultiSelect = AWA_ConfigMultiSelect;
})()




//    $('#select-all').click(function() {
//        $('#public-methods').multiSelect('select_all');
//        return false;
//    });
//    $('#deselect-all').click(function() {
//        $('#public-methods').multiSelect('deselect_all');
//        return false;
//    });
//    $('#select-100').click(function() {
//        $('#public-methods').multiSelect('select', ['elem_3', 'elem_1', 'elem_2']);
//        return false;
//    });
//    $('#deselect-100').click(function() {
//        $('#public-methods').multiSelect('deselect', ['elem_3', 'elem_1', 'elem_2']);
//        return false;
//    });
//    $('#refresh').on('click', function() {
//        $('#public-methods').multiSelect('refresh');
//        return false;
//    });
//    $('#add-option').on('click', function() {
//        $('.searchable').multiSelect('addOption', {value: 42, text: 'test 42', index: 0});
//        return false;
//
//
//    });


//    $.each($(".ms-container"), function() {
//        var lisetItem = $(this).find("tbody>tr");
//        if (lisetItem[0] != undefined) {
//            if (lisetItem[0].innerText == "") {
//                $(this).hide();
//                $(this).parent().css("background-color", "#000");
//            }
// }
//    });

