
$("#blabla").append($(`  <div class="row clearfix" style="margin:5px">
<div class="col-md-12 table-responsive" style="font-size: 11px;     overflow-x: visible;">
    <div class="panel panel-default box shadow-4dp" style="    padding: 0px;">
        
        
        <div class="panel-heading">
            <i class=" glyphicon glyphicon-usd"></i>blalblablalblablalbla<div class="pull-right">
                <div class="btn-group">
                    <button class="btn btn-default  " id="btnpanelperentstatistiqe" type="button">
                        <span class="glyphicon glyphicon-floppy-saved" style="    color: #337ab7;"></span>
                    </button>
                </div>
            </div>
        </div>



        <div class="row clearfix" style="margin:5px">
            <div class="col-md-12 table-responsive" style="font-size: 11px;     overflow-x: visible;">

                <table class="table  table-hover table-sortable table-sm ">
                    <thead>
                        <tr>
                            <th class="text-center">
                                factures achats
                                <span aria-hidden="true" class="glyphicon glyphicon-pencil"></span>
                            </th>


                            <th class="text-center" style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;"></th>
                        </tr>
                    </thead>
                    <tbody id="content-child">
                        <tr class="inputs-child">


                            <td>
                                <input class="form-control input-sm" data-set_null="NO" id="id_html_date_negociation_child1" name="date_negociation_child[]" placeholder="date negociation child" step="any" type="date">
                            </td>

                            <td>
                                <button class="delete btn btn-xs glyphicon glyphicon-trash row-remove" style="font-size: 16px ;    background-color: #f1a1c2;"></button>
                            </td>
                        </tr>

                    </tbody>
                </table>


            </div>
        </div>
        <a class="btn btn-default pull-right" id="add_row">Add Row</a>
    </div>
</div>
</div>   `));




(function () {
    var formJs = $("#formJs");
    var namecontroller = formJs.data("namecontroller");
    var namemodule = formJs.data("namemodule");

    $.get("/api/" + namecontroller + "?schema=all", function (schemas) {
        


        var form = create_form(schemas.html);
        create_listSelect(schemas.table_CHILDREN);

        formJs.append(form);

        form.submit(function (e) {
            e.preventDefault();
            // send formdata par ajax
            var formdata = chargeFormData();
            //cache form html
            formJs.addClass("hidden");
            // afiche stayle loade data
            $("#refresh").removeClass("hidden");
            $('#ModalProgress').modal('show');
            ajaxSendData(formdata);
        });



    });
    /// create form html
    function create_form(schemas) {
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
        for (let i = 0, max = schemas.length; i < max; i++) {
            form.append(creetinput(schemas[i]));
        }
        form.append(btnForm());
        return form;
    }
    /// create list select
    function create_listSelect(table_CHILDREN) {

        var table = $("#DataTableJs");
        var divtable = $("#divTableJs");
       

        for (let index = 0; index < table_CHILDREN.length; index++) {
            let divRowTable=$("<div/>",{class:"row" 
            ,style:"width:50% ;    margin-top: 10px; margin-left: 5px; "});
            let tb = table.clone();
            let T_child=table_CHILDREN[index];
            
            tb.attr("id", T_child);
            divRowTable.append(tb);
            divtable.append(divRowTable);

            // set data par ajax
            let data=get_data_ajax('/api/'+T_child, init_param());
            $("#"+T_child).DataTable(data);
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
                        param.scrollX=true;

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
     * @returns {undefined}
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
})()