(function () {

    var showform = $("#showform");
    var namecontroller = showform.data("namecontroller");
    var namemodule = showform.data("namemodule");


    $.get("/api/" + namecontroller + "?schema=all", function (schemas) {

        create_form(schemas);
        showform.find("form").submit(function (e) {
            e.preventDefault();
            send();
        });

    });

    function create_form(schemas) {
        create_form_simple(schemas.html);
        create_multiSelect_table(schemas.table_CHILDREN);
        create_form_dynamique_table(schemas.html_relation_CHILDREN);
        ///style box show
        function styleviewbox(data, id, Class) {
            let viewbox = $("#divmodule").clone();
            viewbox.attr("id", "div" + id);
            viewbox.removeClass("hidden");
            viewbox.addClass(Class);

            viewbox.find(".showdata").append(data);
            return viewbox;
        }
        /// create form html
        function create_form_simple(schemashtml) {


            function label_form(schema) {

                if (schema.type !== "hidden") {
                    let label = $("<label>",
                        {
                            for: schema.name,
                            class: "col-sm-3 control-label",
                            style: "text-align: left",

                        }
                    ).append(schema.name.replace(new RegExp('[$]', 'g'), " ") + " ");
                    if (schema.isnull === "NO") {
                        var spam = $("<span/>", { class: "glyphicon glyphicon-pencil", 'aria-hidden': "true" });
                        label.append(spam);
                    }
                    return label;

                } else {
                    return " ";
                }



            }
            function select_form(schema) {
                var select =
                    $("<select>",
                        {

                            "data-live-search": "true",
                            name: schema.name,
                            class: " "
                        }
                    )
                    ;

                $.get("/api/" + schema.name, function (data) {

                    let titles = data.titles;
                    let dataSet = data.dataSet;
                    for (let i = 0, max = dataSet.length; i < max; i++) {
                        let textoption = dataSet[i][1];
                        let valueoption = dataSet[i][0];
                        select.append($("<option>", { text: textoption, value: valueoption }));
                    }

                    select.selectpicker();

                });
                return select;
            }
            function textarea_form(schema) {
                return $("<textarea>",
                    {
                        name: schema.name,

                        "autocomplete": "text"
                    }
                );
            }
            function file_form(schema) {

                return $("<input>",
                    {
                        type: schema.type,
                        name: schema.name + "[]",

                        class: ""
                    }
                ).attr("multiple", true);
            }
            function input_form(schema) {

                return $("<input>",
                    {
                        type: schema.type,
                        name: schema.name,

                        class: "",
                    }
                );
            }

            function creetinput(schema) {


                // input

                let input;
                if (schema.type === "select") {
                    input = select_form(schema);

                } else if (schema.type === "textarea") {
                    input = textarea_form(schema);

                } else if (schema.type === "file") {
                    input = file_form(schema);

                } else {
                    input = input_form(schema);

                }

                input.attr("data-set_null", schema.isnull);
                input.addClass("form-control input-sm");

                input.attr("placeholder", schema.name);
                input.attr("value", schema.default);
                input.attr("id", "id_html_" + schema.name);


                var divFormGroup = $("<div/>", { class: "form-group" });


                // label
                divFormGroup.append(label_form(schema));

                var divinput = $("<div/>", { class: "col-sm-9" });
                divinput.append(input);

                return divFormGroup.append(divinput);


            }



            function btnForm() {
                var div = $("<div>", { class: "col-sm-12" });

                var labeljoutdata = $("<label>",
                    {
                        class: " control-label", style: "text-align: left", for: "ajoutdata"
                    }).append("  AJOUTER  ");
                div.append(labeljoutdata);

                var btnajoutdata = $("<input>",
                    {
                        type: "submit",
                        name: "ajoutdata",
                        class: "btn btn-success btn-lg"
                    });
                div.append(btnajoutdata);

                var labelreset = $("<label>",
                    {
                        class: " control-label",
                        style: "text-align: left", for: "reset"
                    }).append("  VIDE  ");
                div.append(labelreset);

                var btnreset = $("<input>",
                    {
                        type: "reset",
                        name: "reset",
                        class: "btn btn-success btn-lg"
                    });
                div.append(btnreset);

                return div;
            }
            var form = $("<form/>", { class: 'form-horizontal' });
            for (let i = 0, max = schemashtml.length; i < max; i++) {
                form.append(creetinput(schemashtml[i]));
            }
            form.append(btnForm());
            let formbox = styleviewbox(form, "formhtmlview","col-md-6");
            showform.append(formbox);




        }
        /// create list select
        function create_multiSelect_table(table_CHILDREN) {


            for (let index = 0; index < table_CHILDREN.length; index++) {
                let item = table_CHILDREN[index];
                let id = "div" + item.replace(new RegExp('[\$_]', 'g'), '');
                let table = $("<table/>", { class: "DataTableJs table table-striped table-bordered dt-responsive nowrap " });
                let viewbox = styleviewbox(table, id,"col-md-6");
                showform.append(viewbox);
                // set data par ajax
                let data = get_data_ajax('/api/' + item, init_param());
                $("#div" + id).find("table")
                    .attr("id", "table" + id)
                    .DataTable(data);


            }


            function get_data_ajax(urlAjax, param) {

                $
                    .ajax({
                        type: "GET",
                        url: urlAjax,
                        async: false,
                    })
                    .done(
                        function (datajson) {

                            var titles = datajson["titles"];
                            var columns = [];
                            for (var i = 0; i < titles.length; i++) {
                                columns.push({
                                    title: (titles[i].title).replace(/\$/g, " ").replace(/\_/g, " ")
                                });
                            }



                            var data = datajson["dataSet"];


                            columns
                                .unshift({
                                    title: '<span class="glyphicon glyphicon-check" aria-hidden="true" style="    display: block;margin: auto;width: 15px;"></span>'
                                });

                            for (var i = 0; i < data.length; i++) {
                                var id_row = data[i][0];

                                // sup modi voir
                                data[i].unshift(" "); // add checkbox
                            }

                            param.columns = columns;
                            param.data = data;
                            param.scrollX = true;

                        });
                return param;
            }

            function init_param() {
                var param = {
                    buttons: ["pageLength", "colvis"],
                    columnDefs: [{
                        orderable: false,
                        className: 'select-checkbox',
                        targets: 0
                    }],
                    select: {
                        style: 'multi',
                        // style: 'os',
                        selector: 'td:first-child'
                    },
                    order: [[1, 'asc']],
                    lengthMenu: [
                        [10, 25, 50, -1],
                        ['10 éléments', '25 éléments', '50 éléments',
                            'Tous éléments']], //dataTables.buttons line 1321   //min lin 27
                    dom: 'Bfrtip',
                    lengthChange: false,
                    language: {

                        processing: "Traitement en cours...",
                        search: "Rechercher&nbsp;:",
                        lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
                        info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                        infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                        infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                        infoPostFix: "",
                        loadingRecords: "Chargement en cours...",
                        zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
                        emptyTable: "Aucune donnée disponible dans le tableau",
                        paginate: {
                            first: "Premier",
                            previous: "Pr&eacute;c&eacute;dent",
                            next: "Suivant",
                            last: "Dernier"
                        },
                        aria: {
                            sortAscending: ": activer pour trier la colonne par ordre croissant",
                            sortDescending: ": activer pour trier la colonne par ordre décroissant"
                        },
                        buttons: {
                            colvis: "select les champs"
                        },
                        select: {
                            rows: {
                                _: "rak %d rows",
                                0: "Click a row to hna it",
                                1: "rir 1 row selected"
                            }
                        }
                    }
                };
                return param;
            }

        }
        /// create list form table
        function create_form_dynamique_table(html_relation_CHILDREN) {





            // tableform for chile  autoadd , style file icon  
            var AWA_FormChild = function (config) {
                var select_elem = config.select_elem || 'content-child';
                this.graph = config.graph || [];

                var self = this;
                // index row inputs
                this.id_index = 0;
                //id html table qui containrer input
                this.content_child = $(select_elem + "  tbody");

                //row html row qui containrer input
                this.inputs_child = this.content_child.find("tr");
                // inpule files
                this.$file = this.inputs_child.find("input[type='file']");
                this.id_file = this.$file.attr("id");
                this.name_file = this.$file.attr("name");
                // change name input file for php 
                this.$file.attr("name", this.name_file + this.id_index);
                this.add_button = $(select_elem + "  .add_row");

                ///*************************///
                //events
                // delete row inputs 
                this.content_child.on("click", ".delete", function (e) {
                    e.preventDefault();
                    $(this).parent('td').parent('tr').remove();
                    self.updateGraph();
                });
                // set data graph
                this.content_child.on("change", "input", function (e) {
                    e.preventDefault();
                    self.updateGraph();
                });
                // add row inputs 
                this.add_button.click(function (e) {
                    e.preventDefault();
                    self.id_index++;
                    var new_row = self.inputs_child.clone();
                    // vide data default(clone)
                    new_row.find("label span").text("");
                    new_row.find("input,textarea").val("");
                    // agument id
                    new_row.find("input,textarea,select").each(function () {
                        var $input = $(this);
                        var id = $input.attr("id");
                        $input.attr("id", id + self.id_index);
                    })
                    // set event style file
                    new_row.find("input[type='file']")
                        .each(function () {
                            var $fileRow = $(this);
                            var label = $fileRow.prev();
                            //id and name file id pour lable 
                            var id_local = self.id_file + self.id_index;
                            $fileRow.attr("id", id_local);
                            label.attr("for", id_local);
                            //and name pour php
                            $fileRow.attr("name", self.name_file + self.id_index);
                            // set theme pour lable
                            $fileRow.change(function (e) {
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
                updateGraph: function () {
                    // return json
                    var row = [];
                    this.content_child.find(".inputs-child").each(function (index) {
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























            for (var relation_CHILDREN in html_relation_CHILDREN) {

                let schemas = html_relation_CHILDREN[relation_CHILDREN];

                if (schemas.length > 2) {





                    let id = "div" + relation_CHILDREN.replace(new RegExp('[\$_]', 'g'), '');




                    let table = $(`<table  class="table  table-hover table-sortable table-sm ">
                     <thead>
                    <tr>
                        <th class="text-center" style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;"></th>
                    </tr>
                    </thead>
                    <tbody >
                    <tr class="inputs-child">
                     <td>
                            <button class="delete btn btn-xs glyphicon glyphicon-trash row-remove" style="font-size: 16px ;    background-color: #f1a1c2;"></button>
                        </td>
                    </tr>
                    </tbody>

                    </table>
                    <a class="btn btn-default pull-right add_row" >Add Row</a>
                    `);


                    let viewbox = styleviewbox(table, id,"col-md-12");
                    showform.append(viewbox);

                    $("#div" + id).find(".showdata").append(table)




                    for (let index = 0; index < schemas.length; index++) {

                        const schema = schemas[index];
                        let title = label_form(schema);

                        $("#div" + id).find(".showdata")
                            .find("table>thead>tr")
                            .append($("<th/>", { class: "text-center" })
                                .append(title));


                        let input = creetinput(schema);
                        $("#div" + id).find(".showdata")
                            .find("table>tbody>tr")
                            .append($("<td/>", { class: "text-center" })
                                .append(input));

                    }
                    // $("#divformtable").append(divformtableitem);
                    new AWA_FormChild({
                        select_elem: "#div" + id,
                        graph: []
                    });
                }



            }







            function label_form(schema) {

                if (schema.type !== "hidden") {
                    let label = $("<label>",
                        {
                            for: schema.name,
                            class: "col-sm-3 control-label",
                            style: "text-align: left",

                        }
                    ).append(schema.name.replace(new RegExp('[$]', 'g'), " ") + " ");
                    if (schema.isnull === "NO") {
                        var spam = $("<span/>", { class: "glyphicon glyphicon-pencil", 'aria-hidden': "true" });
                        label.append(spam);
                    }
                    return label;

                } else {
                    return " ";
                }



            }
            function hidden_form(schema) {
                var select =
                    $("<select>",
                        {

                            "data-live-search": "true",
                            name: schema.name,
                            class: " "
                        }
                    )
                    ;

                let url = schema.name.replace(new RegExp('id_', 'g'), '');


                $.get("/api/" + url, function (data) {

                    let titles = data.titles;
                    let dataSet = data.dataSet;
                    for (let i = 0, max = dataSet.length; i < max; i++) {
                        let textoption = dataSet[i][1];
                        let valueoption = dataSet[i][0];
                        select.append($("<option>", { text: textoption, value: valueoption }));
                    }

                    select.selectpicker();

                });
                return select;
            }
            function select_form(schema) {
                var select =
                    $("<select>",
                        {

                            "data-live-search": "true",
                            name: schema.name,
                            class: " "
                        }
                    )
                    ;

                $.get("/api/" + schema.name, function (data) {

                    let titles = data.titles;
                    let dataSet = data.dataSet;
                    for (let i = 0, max = dataSet.length; i < max; i++) {
                        let textoption = dataSet[i][1];
                        let valueoption = dataSet[i][0];
                        select.append($("<option>", { text: textoption, value: valueoption }));
                    }

                    select.selectpicker();

                });
                return select;
            }
            function textarea_form(schema) {
                return $("<textarea>",
                    {
                        name: schema.name,

                        "autocomplete": "text"
                    }
                );
            }
            function file_form(schema) {

                return $("<input>",
                    {
                        type: schema.type,
                        name: schema.name + "[]",

                        class: ""
                    }
                ).attr("multiple", true);
            }
            function input_form(schema) {

                return $("<input>",
                    {
                        type: schema.type,
                        name: schema.name,

                        class: "",
                    }
                );
            }

            function creetinput(schema) {


                // input

                let input;
                if (schema.type === "hidden") {
                    input = hidden_form(schema);

                }
                else if (schema.type === "select") {
                    input = select_form(schema);

                } else if (schema.type === "textarea") {
                    input = textarea_form(schema);

                } else if (schema.type === "file") {
                    input = file_form(schema);

                } else {
                    input = input_form(schema);

                }

                input.attr("data-set_null", schema.isnull);
                input.addClass("form-control input-sm");

                input.attr("placeholder", schema.name);
                input.attr("value", schema.default);
                input.attr("id", "id_html_" + schema.name);


                var divFormGroup = $("<div/>", { class: "form-group" });




                return divFormGroup.append(input);


            }

        }

    }
    function send() {
        // send formdata par ajax
        var formdata = chargeFormData();

        //cache form html
        showform.addClass("hidden");
        // affiche style loade data
        $("#refresh").removeClass("hidden");
        $('#ModalProgress').modal('show');

        ajaxSendData(formdata);
        /**
        * charge form ajax
        */
        function chargeFormData() {
            var gestion_erreur = function (elment) {

                var not_hidden = elment.type != "hidden";
                var not_null = $(elment).data("set_null") == "NO";
                var is_null = $(elment).val() == "";

                if (not_null && is_null && not_hidden) {
                    $(elment).focus();
                    $.alert({
                        icon: 'glyphicon glyphicon-ok',
                        closeIcon: true,
                        type: 'red',
                        title: 'message!',
                        content: "SVP veuillez remplir le champ ==> <strong>"
                            + elment.name.replace(new RegExp('[$]', 'g'), " ") + " </strong>",
                    });
                    throw "erreur input vide import";
                }
                return true;
            }
            // new form ajax
            var formdata = new FormData();

            $(
                "input:not([type='submit'],[type='reset'],[type='checkbox'],[type='button'],[type='file']) ,textarea,select:not([multiple])")
                .each(function () {
                    gestion_erreur(this);
                    formdata.append(this.name, $(this).val());
                });
            $("select[multiple]").each(function () {
                gestion_erreur(this);
                var name = this.name;
                $($(this).val()).each(function () {
                    formdata.append(name, this);
                })

            });
            $("input[type='file']").each(function () {
                gestion_erreur(this);
                var name = this.name;
                $(this.files).each(function () {
                    formdata.append(name, this);
                })
            });
            $("input[type='checkbox']").each(function (key, val) {
                gestion_erreur(this);
                if ($(this).is(":checked")) {
                    formdata.append($(val).attr('name'), 1);
                } else {
                    formdata.append($(val).attr('name'), 0);
                }
            });
            return formdata;
        }
        /**
         * 
         * @param {type} formdata
         
         */
        function ajaxSendData(formdata) {

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);



            ajax.open("POST", "/" + namemodule + "/" + namecontroller + "/ajouter/0");
            ajax.setRequestHeader("cache-control", "no-cache");

            ajax.send(formdata);

            // / call par ajaxSendData
            function precisionRound(number, precision) {
                var factor = Math.pow(10, precision);
                return Math.round(number * factor) / factor;
            }
            function progressHandler(event) {
                var percent = (event.loaded / event.total) * 100;
                $("#progressBar").css("width", Math.round(percent) + "%");
                $("#etat").html("<h3>" + Math.round(percent) + "%</h3>");
                var load = precisionRound(event.loaded * 0.000001, 2);
                var total = precisionRound(event.total * 0.000001, 2);
                $("#messageprogressBar").html(
                    "envoyer " + load + " MB en " + total + " MB");
            }
            function completeHandler(event) {
                $('#ModalProgress').modal('hide');
                $("#status").html(event.target.responseText);
            }
            function errorHandler(event) {

                $("#messageprogressBar").html("Upload Failed");

            }
            function abortHandler(event) {
                $("#messageprogressBar").html("Upload Aborted");
            }
        }

    }
})()