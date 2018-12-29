"use strict";



$("input[type='file']").each(function(index) {
    var $input = $(this);
    $($input).css({
        "width": "0.1px",
        "height": "0.1px",
        "opacity": "0",
        "overflow": "hidden",
        "position": "absolute",
        "z-index": "-1"
    })
    var id_file = $input.attr("id");
    $('  <label for="' + id_file + '"  ><span class="glyphicon glyphicon-paperclip btn btn-xs " style="font-size: 16px ;    background-color: #dcecfb;" ></span></label>')
            .insertBefore($input);
    
    var label = $input.prev();
    $input.change(function(e)

    {
        label.find('span').html("");
        var len = this.files.length;
        if (len != 0) {
            label.find('span').html(len);
        }
    }
    );

})




