// tableform for chile  autoadd , style file icon  
var AWA_FormChild = function(config) {
    var select_id = config.select_id || 'content-child';
    this.graph = config.graph || [];
    var self = this;
    // index row inputs
    this.id_index = 0;
    //id html table qui containrer input
    this.content_child = $("tbody[id=" + select_id + "]");
    //row html row qui containrer input
    this.inputs_child = this.content_child.find("tr");
    // inpule files
    this.$file = this.inputs_child.find("input[type='file']");
    this.id_file = this.$file.attr("id");
    this.name_file = this.$file.attr("name");
    // change name input file for php 
    this.$file.attr("name", this.name_file + this.id_index);
    this.add_button = $("#add_row");
    ///*************************///
    //events
    // delete row inputs 
    this.content_child.on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('td').parent('tr').remove();
        self.updateGraph();
    });
    // set data graph
    this.content_child.on("change", "input", function(e) {
        e.preventDefault();
        self.updateGraph();
    });
    // add row inputs 
    this.add_button.click(function(e) {
        e.preventDefault();
        self.id_index++;
        var new_row = self.inputs_child.clone();
        // vide data default(clone)
        new_row.find("label span").text("");
        new_row.find("input,textarea").val("");
        // agument id
        new_row.find("input,textarea,select").each(function() {
            var $input = $(this);
            var id = $input.attr("id");
            $input.attr("id", id + self.id_index);
        })
        // set event style file
        new_row.find("input[type='file']")
                .each(function() {
                    var $fileRow = $(this);
                    var label = $fileRow.prev();
                    //id and name file id pour lable 
                    var id_local = self.id_file + self.id_index;
                    $fileRow.attr("id", id_local);
                    label.attr("for", id_local);
                    //and name pour php
                    $fileRow.attr("name", self.name_file + self.id_index);
                    // set theme pour lable
                    $fileRow.change(function(e)
                    {
                        label.find('span').html("");
                        var len = this.files.length;
                        if (len != 0) {
                            label.find('span').html(len);
                        }
                    }
                    );

                })
        /// add row to table_form
        $(self.content_child).append(new_row); //add input box
    });

}
AWA_FormChild.prototype = {
    updateGraph: function() {
        // return json
        var row = [];
        this.content_child.find(".inputs-child").each(function(index) {
            var ob = {};
            ob.label = $(this).find("[type=date]").val();
            ob.dataset = $(this).find("[type=number]").val();
            row.push(ob)

        })

        for (var i = 0; i < this.graph.length; i++) {
            this.graph[i].set_Data("row", row);
        }




    }

}
