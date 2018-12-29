

!function ($) {

  "use strict";


  /* MULTISELECT CLASS DEFINITION
   * ====================== */

  var MultiSelect = function (element, options) {

    this.$element = $(element);
    this.options = options;


    this.$container = $('<div/>', {'class': "ms-container"});
    this.$selectableContainer = $('<div/>', {'class': 'ms-selectable'});
    this.$selectionContainer = $('<div/>', {'class': 'ms-selection'});
    this.$selectableUl = $('<table/>', {'class': "ms-list table table-bordered table-hover", 'tabindex': '-1'});
    this.$selectionUl = $('<table/>', {'class': "ms-list table table-bordered table-hover", 'tabindex': '-1'});

    this.$selectabletbody = $('<tbody/>', {'class': "center"});
    this.$selectiontbody = $('<tbody/>', {'class': "success"});


    this.scrollTo = 0;
    this.elemsSelector = 'li:visible:not(.ms-optgroup-label,.ms-optgroup-container,.' + options.disabledClass + ')';
  };

  MultiSelect.prototype = {
    constructor: MultiSelect,

    'init': function () {
      var that = this;

      var ms = this.$element; // element Select html


      if (ms.next('.ms-container').length === 0) { // si il y a class ms-container dans fichier html
        ms.css({position: 'absolute', left: '-9999px'}); // cache element select 
        ms.attr('id', ms.attr('id') ? ms.attr('id') : Math.ceil(Math.random() * 1000) + 'multiselect'); // insert id element select si n a pas
        this.$container.attr('id', 'ms-' + ms.attr('id')); // copier 'id' de element select plus text ms- sur class container
        this.$container.addClass(that.options.cssClass); // ajouter class css de att options

        var thead = ms.children('option:eq(0)').text().split("£££");

        thead.pop();

        var th = '';
        for (var i = 0; i < thead.length; i++) {
          var datathead = thead[i].split("$$$");
          th += "<th>" + datathead[0] + "</th>";

        }

        this.$selectionUl.append('<thead><tr>' + th + '</tr></thead>');
        this.$selectableUl.append('<thead><tr>' + th + '</tr></thead>');



        ms.find('option').each(function () {

          that.generateLisFromOption(this);// daba bdina

        });
        this.$selectiontbody.find('tr').each(function () {
          $(this).addClass('active');
        });
        this.$selectionUl.append(this.$selectiontbody);
        this.$selectableUl.append(this.$selectabletbody);







        if (this.options.selectableHeader) {
          this.$selectableContainer.append(this.options.selectableHeader);
        }
        this.$selectableContainer.append(this.$selectableUl);

        if (this.options.selectableFooter) {
          this.$selectableContainer.append(this.options.selectableFooter);
        }

        if (this.options.selectionHeader) {
          this.$selectionContainer.append(this.options.selectionHeader);
        }
        this.$selectionContainer.append(this.$selectionUl);

        if (this.options.selectionFooter) {
          this.$selectionContainer.append(this.options.selectionFooter);
        }

        this.$container.append(this.$selectableContainer);
        this.$container.append(this.$selectionContainer);

        ms.after(this.$container);

        this.activeMouse(this.$selectableUl);
        this.activeKeyboard(this.$selectableUl);

        var action = this.options.dblClick ? 'dblclick' : 'click';

        this.$selectableUl.on(action, '.ms-elem-selectable', function () {
          that.select($(this).data('ms-value'));
        });
        this.$selectionUl.on(action, '.ms-elem-selection', function () {
          that.deselect($(this).data('ms-value'));
        });

        this.activeMouse(this.$selectionUl);
        this.activeKeyboard(this.$selectionUl);

        ms.on('focus', function () {
          that.$selectableUl.focus();
        });
      }

      var selectedValues = ms.find('option:selected').map(function () {
        return $(this).val();
      }).get();
      that.select(selectedValues, 'init');

      if (typeof that.options.afterInit === 'function') {
        that.options.afterInit.call(this, this.$container);
      }
    },

    'generateLisFromOption': function (option) {

      var that = this;
      var ms = this.$element; // element Select html
      var attributes = "";

      var $option = $(option);// element option dans element select

      for (var i = 0; i < option.attributes.length; i++) { // select attr de element select
        var attr = option.attributes[i];
        if (attr.name !== 'value' && attr.name !== 'disabled') {
          attributes += attr.name + '="' + attr.value + '" ';
        }
      }


      // escapeHTML => function dans OBJECT to converte
      var text = $option.text().split("£££");
      text.pop();
      var td = '';
      for (var i = 0; i < text.length; i++) {
        var data = text[i].split("$$$");

        td += "<td>" + data[1] + "</td>";

      }
      var tbody = "", ftbody = "";


      var selectableLi = $(tbody + '<tr ' + attributes + '>' + td + '</tr>' + ftbody);
      var selectedLi = selectableLi.clone();

      var value = $option.val(); // value de select 

      var elementId = this.sanitize(value); // Convert to 32bit integer


      selectableLi  // charge data
              .data('ms-value', value)
              .addClass('ms-elem-selectable')
              .attr('id', elementId + '-selectable');

      selectedLi // charge data
              .data('ms-value', value)
              .addClass('ms-elem-selection')
              .attr('id', elementId + '-selection')
              .hide();

      if ($option.prop('disabled') || ms.prop('disabled')) { // s il y a  attr disabled
        selectedLi.addClass(this.options.disabledClass);
        selectableLi.addClass(this.options.disabledClass);
      }



      var index = this.$selectabletbody.children().length;

      selectableLi.insertAt(index, this.$selectabletbody); //insert to ul
      selectedLi.insertAt(index, this.$selectiontbody);  //insert to ul

    },

    'addOption': function (options) {
      var that = this;

      if (options.value !== undefined && options.value !== null) {
        options = [options];
      }
      $.each(options, function (index, option) {
        if (option.value !== undefined && option.value !== null &&
                that.$element.find("option[value='" + option.value + "']").length === 0) {
          var $option = $('<option value="' + option.value + '">' + option.text + '</option>'),
                  index = parseInt((typeof option.index === 'undefined' ? that.$element.children().length : option.index)),
                  $container = option.nested == undefined ? that.$element : $("optgroup[label='" + option.nested + "']")

          $option.insertAt(index, $container);
          that.generateLisFromOption($option.get(0), index, option.nested);
        }
      })
    },

    'escapeHTML': function (text) { // pour converte ><& to &lt &gt

      return $("<div>").text(text).html();
    },

    'activeKeyboard': function ($list) {
      var that = this;

      $list.on('focus', function () {
        $(this).addClass('ms-focus');
      })
              .on('blur', function () {
                $(this).removeClass('ms-focus');
              })
              .on('keydown', function (e) {
                switch (e.which) {
                  case 40:
                  case 38:
                    e.preventDefault();
                    e.stopPropagation();
                    that.moveHighlight($(this), (e.which === 38) ? -1 : 1);
                    return;
                  case 37:
                  case 39:
                    e.preventDefault();
                    e.stopPropagation();
                    that.switchList($list);
                    return;
                  case 9:
                    if (that.$element.is('[tabindex]')) {
                      e.preventDefault();
                      var tabindex = parseInt(that.$element.attr('tabindex'), 10);
                      tabindex = (e.shiftKey) ? tabindex - 1 : tabindex + 1;
                      $('[tabindex="' + (tabindex) + '"]').focus();
                      return;
                    } else {
                      if (e.shiftKey) {
                        that.$element.trigger('focus');
                      }
                    }
                }
                if ($.inArray(e.which, that.options.keySelect) > -1) {
                  e.preventDefault();
                  e.stopPropagation();
                  that.selectHighlighted($list);
                  return;
                }
              });
    },

    'moveHighlight': function ($list, direction) {
      var $elems = $list.find(this.elemsSelector),
              $currElem = $elems.filter('.ms-hover'),
              $nextElem = null,
              elemHeight = $elems.first().outerHeight(),
              containerHeight = $list.height(),
              containerSelector = '#' + this.$container.prop('id');

      $elems.removeClass('ms-hover');
      if (direction === 1) { // DOWN

        $nextElem = $currElem.nextAll(this.elemsSelector).first();
        if ($nextElem.length === 0) {
          var $optgroupUl = $currElem.parent();

          if ($optgroupUl.hasClass('ms-optgroup')) {
            var $optgroupLi = $optgroupUl.parent(),
                    $nextOptgroupLi = $optgroupLi.next(':visible');

            if ($nextOptgroupLi.length > 0) {
              $nextElem = $nextOptgroupLi.find(this.elemsSelector).first();
            } else {
              $nextElem = $elems.first();
            }
          } else {
            $nextElem = $elems.first();
          }
        }
      } else if (direction === -1) { // UP

        $nextElem = $currElem.prevAll(this.elemsSelector).first();
        if ($nextElem.length === 0) {
          var $optgroupUl = $currElem.parent();

          if ($optgroupUl.hasClass('ms-optgroup')) {
            var $optgroupLi = $optgroupUl.parent(),
                    $prevOptgroupLi = $optgroupLi.prev(':visible');

            if ($prevOptgroupLi.length > 0) {
              $nextElem = $prevOptgroupLi.find(this.elemsSelector).last();
            } else {
              $nextElem = $elems.last();
            }
          } else {
            $nextElem = $elems.last();
          }
        }
      }
      if ($nextElem.length > 0) {
        $nextElem.addClass('ms-hover');
        var scrollTo = $list.scrollTop() + $nextElem.position().top -
                containerHeight / 2 + elemHeight / 2;

        $list.scrollTop(scrollTo);
      }
    },

    'selectHighlighted': function ($list) {
      var $elems = $list.find(this.elemsSelector),
              $highlightedElem = $elems.filter('.ms-hover').first();

      if ($highlightedElem.length > 0) {
        if ($list.parent().hasClass('ms-selectable')) {
          this.select($highlightedElem.data('ms-value'));
        } else {
          this.deselect($highlightedElem.data('ms-value'));
        }
        $elems.removeClass('ms-hover');
      }
    },

    'switchList': function ($list) {
      $list.blur();
      this.$container.find(this.elemsSelector).removeClass('ms-hover');
      if ($list.parent().hasClass('ms-selectable')) {
        this.$selectionUl.focus();
      } else {
        this.$selectableUl.focus();
      }
    },

    'activeMouse': function ($list) {
      var that = this;

      this.$container.on('mouseenter', that.elemsSelector, function () {
        $(this).parents('.ms-container').find(that.elemsSelector).removeClass('ms-hover');
        $(this).addClass('ms-hover');
      });

      this.$container.on('mouseleave', that.elemsSelector, function () {
        $(this).parents('.ms-container').find(that.elemsSelector).removeClass('ms-hover');
        ;
      });
    },

    'refresh': function () {
      this.destroy();
      this.$element.multiSelect(this.options);
    },

    'destroy': function () {
      $("#ms-" + this.$element.attr("id")).remove();
      this.$element.css('position', '').css('left', '')
      this.$element.removeData('multiselect');
    },

    'select': function (value, method) {
      if (typeof value === 'string') {
        value = [value];
      }

      var that = this,
              ms = this.$element,
              msIds = $.map(value, function (val) {
                return(that.sanitize(val));
              }),
              selectables = this.$selectableUl.find('#' + msIds.join('-selectable, #') + '-selectable').filter(':not(.' + that.options.disabledClass + ')'),
              selections = this.$selectionUl.find('#' + msIds.join('-selection, #') + '-selection').filter(':not(.' + that.options.disabledClass + ')'),
              options = ms.find('option:not(:disabled)').filter(function () {
        return($.inArray(this.value, value) > -1);
      });

      if (method === 'init') {
        selectables = this.$selectableUl.find('#' + msIds.join('-selectable, #') + '-selectable'),
                selections = this.$selectionUl.find('#' + msIds.join('-selection, #') + '-selection');
      }

      if (selectables.length > 0) {
        selectables.addClass('ms-selected').hide();
        selections.addClass('ms-selected').show();

        options.prop('selected', true);

        that.$container.find(that.elemsSelector).removeClass('ms-hover');

        var selectableOptgroups = that.$selectableUl.children('.ms-optgroup-container');
        if (selectableOptgroups.length > 0) {
          selectableOptgroups.each(function () {
            var selectablesLi = $(this).find('.ms-elem-selectable');
            if (selectablesLi.length === selectablesLi.filter('.ms-selected').length) {
              $(this).find('.ms-optgroup-label').hide();
            }
          });

          var selectionOptgroups = that.$selectionUl.children('.ms-optgroup-container');
          selectionOptgroups.each(function () {
            var selectionsLi = $(this).find('.ms-elem-selection');
            if (selectionsLi.filter('.ms-selected').length > 0) {
              $(this).find('.ms-optgroup-label').show();
            }
          });
        } else {
          if (that.options.keepOrder && method !== 'init') {
            var selectionLiLast = that.$selectionUl.find('.ms-selected');
            if ((selectionLiLast.length > 1) && (selectionLiLast.last().get(0) != selections.get(0))) {
              selections.insertAfter(selectionLiLast.last());
            }
          }
        }
        if (method !== 'init') {
          ms.trigger('change');
          if (typeof that.options.afterSelect === 'function') {
            that.options.afterSelect.call(this, value, options);
          }
        }
      }
    },

    'deselect': function (value) {
      if (typeof value === 'string') {
        value = [value];
      }

      var that = this,
              ms = this.$element,
              msIds = $.map(value, function (val) {
                return(that.sanitize(val));
              }),
              selectables = this.$selectableUl.find('#' + msIds.join('-selectable, #') + '-selectable'),
              selections = this.$selectionUl.find('#' + msIds.join('-selection, #') + '-selection').filter('.ms-selected').filter(':not(.' + that.options.disabledClass + ')'),
              options = ms.find('option').filter(function () {
        return($.inArray(this.value, value) > -1);
      });

      if (selections.length > 0) {
        selectables.removeClass('ms-selected').show();
        selections.removeClass('ms-selected').hide();
        options.prop('selected', false);

        that.$container.find(that.elemsSelector).removeClass('ms-hover');

        var selectableOptgroups = that.$selectableUl.children('.ms-optgroup-container');
        if (selectableOptgroups.length > 0) {
          selectableOptgroups.each(function () {
            var selectablesLi = $(this).find('.ms-elem-selectable');
            if (selectablesLi.filter(':not(.ms-selected)').length > 0) {
              $(this).find('.ms-optgroup-label').show();
            }
          });

          var selectionOptgroups = that.$selectionUl.children('.ms-optgroup-container');
          selectionOptgroups.each(function () {
            var selectionsLi = $(this).find('.ms-elem-selection');
            if (selectionsLi.filter('.ms-selected').length === 0) {
              $(this).find('.ms-optgroup-label').hide();
            }
          });
        }
        ms.trigger('change');
        if (typeof that.options.afterDeselect === 'function') {
          that.options.afterDeselect.call(this, value, options);
        }
      }
    },

    'select_all': function () {
      var ms = this.$element,
              values = ms.val();

      ms.find('option:not(":disabled")').prop('selected', true);
      this.$selectableUl.find('.ms-elem-selectable').filter(':not(.' + this.options.disabledClass + ')').addClass('ms-selected').hide();
      this.$selectionUl.find('.ms-optgroup-label').show();
      this.$selectableUl.find('.ms-optgroup-label').hide();
      this.$selectionUl.find('.ms-elem-selection').filter(':not(.' + this.options.disabledClass + ')').addClass('ms-selected').show();
      this.$selectionUl.focus();
      ms.trigger('change');
      if (typeof this.options.afterSelect === 'function') {
        var selectedValues = $.grep(ms.val(), function (item) {
          return $.inArray(item, values) < 0;
        });
        this.options.afterSelect.call(this, selectedValues);
      }
    },

    'deselect_all': function () {
      var ms = this.$element,
              values = ms.val();

      ms.find('option').prop('selected', false);
      this.$selectableUl.find('.ms-elem-selectable').removeClass('ms-selected').show();
      this.$selectionUl.find('.ms-optgroup-label').hide();
      this.$selectableUl.find('.ms-optgroup-label').show();
      this.$selectionUl.find('.ms-elem-selection').removeClass('ms-selected').hide();
      this.$selectableUl.focus();
      ms.trigger('change');
      if (typeof this.options.afterDeselect === 'function') {
        this.options.afterDeselect.call(this, values);
      }
    },

    'sanitize': function (value) {
      var hash = 0;
      var i;
      var character;

      if (value.length == 0)
        return hash;
      var ls = 0;
      for (i = 0, ls = value.length; i < ls; i++) {
        character = value.charCodeAt(i);
        hash = ((hash << 5) - hash) + character;
        hash |= 0; // Convert to 32bit integer
      }
      return hash;
    }
  };

  /* MULTISELECT PLUGIN DEFINITION
   * ======================= */


  $.fn.multiSelect = function () {
    var args = arguments;

    var OBJECTMultiSelect;

    return this.each(function () {
      var $this = $(this);

      if (!$this.data('object_multiselect')) {
        if (typeof args[0] === 'object') {
          var option = args[0];
        } else {
          var option = {};
        }
        var options = $.extend(
                {},
                $.fn.multiSelect.defaults,
                $this.data(),
                option
                );

        OBJECTMultiSelect = new MultiSelect(this, options);

        $this.data('object_multiselect', OBJECTMultiSelect);
      } else {

        OBJECTMultiSelect = $this.data('object_multiselect');

      }



      if (typeof args[0] === 'string') {
        OBJECTMultiSelect[args[0]](args[1]);
      } else {
        OBJECTMultiSelect.init();
      }
    });
  };

  $.fn.multiSelect.defaults = {
    keySelect: [32],
    selectableOptgroup: false,
    disabledClass: 'disabled',
    dblClick: false,
    keepOrder: false,
    cssClass: ''
  };

  $.fn.multiSelect.Constructor = MultiSelect;



  /* insertAt PLUGIN DEFINITION
   * ======================= */
  $.fn.insertAt = function (index, $parent) {
    return this.each(function () {
      if (index === 0) {
        $parent.prepend(this);
      } else {
        //dom darori
        $parent.children().eq(index - 1).after(this);
      }
    });
  };


var $table = $('table.scroll'),
    $bodyCells = $table.find('tbody tr:first').children(),
    colWidth;

// Adjust the width of thead cells when window resizes
$(window).resize(function() {
    // Get the tbody columns width array
    colWidth = $bodyCells.map(function() {
        return $(this).width();
    }).get();
    
    // Set the width of thead columns
    $table.find('thead tr').children().each(function(i, v) {
        $(v).width(colWidth[i]);
    });    
}).resize(); // Trigger resize handler






}(window.jQuery);

