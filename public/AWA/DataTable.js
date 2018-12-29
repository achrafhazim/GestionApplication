"use strict";
/**
 * voir table par json
 */
function DataTable_awa(id, btn_show_php, routes, urlAjax) {

    var table = $(id);
    var btn_php = parse_btn_show_php(btn_show_php);
    var param = init_param(btn_php);

    if (urlAjax !== undefined) {
        param = set_data_ajax(urlAjax, param);
    }
    table.DataTable(param);

    setEvent_dataTable(table);



    // //////////////////////////////////////////////////////////////////////
    function init_param(btn_show_php) {
        var param = {
            buttons: [btn_show_php],
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
    function parse_btn_show_php(btn_show_php) {
        var btn = btn_show_php.split(" ");
        var btn_parse = [];

        for (var i = 0; i < btn.length; i++) {
            if (btn[i] == "pdfHtml5") {
                btn_parse.push({
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    titleAttr: 'PDF'
                });

            } else if (btn[i] == "excelHtml5") {
                btn_parse.push({
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Excel'
                });

            } else if (btn[i] == "copyHtml5") {
                btn_parse.push({
                    extend: 'copyHtml5',
                    text: '<i class="fa fa-files-o"></i>',
                    titleAttr: 'Copy'
                });

            } else if (btn[i] == "print") {
                btn_parse.push({
                    extend: 'print',
                    text: '<i class="glyphicon glyphicon-print"></i>',
                    titleAttr: 'print'
                });

            } else if (btn[i] == "colvis") {
                btn_parse.push({
                    extend: 'colvis',
                    text: '<i class="glyphicon glyphicon-indent-left  "></i>',
                    titleAttr: 'select'
                });

            } else if (btn[i] == "control") {
                btn_parse.push({
                    text: '<spam class="glyphicon glyphicon-plus" style="color:#337ab7"></spam>',
                    titleAttr: 'ajouter',
                    action: function() {
                        

                        var url = generateUri("0", routes).urlajouter;
                        window.open(url, "_self")

                    }

                });


                btn_parse.push({
                    text: '<spam id="btn_remove_group_select" class="glyphicon glyphicon-trash" style="color:red"></spam>',
                    titleAttr: 'supp select',
                    action: function() {

                        // get data select
                        var data_select = table.DataTable().rows({
                            selected: true
                        }).data().toArray();
                        // get id row select
                        var id = [];
                        var id_sup = [];
                        for (var j = 0; j < data_select.length; j++) {
                            var id_row = data_select[j][1];
                            id.push(id_row);

                            var urlsupprimer = (generateUri(id_row, routes).urlsupprimer);
                            id_sup.push(urlsupprimer);
                        }
                        var urlmessage = (generateUri(id.toString(), routes).urlmessage);
                        traitement_sup(urlmessage, id_sup, table);

                    }
                });

            } else {
                btn_parse.push(btn[i]);
            }
           
        }


 
        return btn_parse;
    }

    function set_data_ajax(urlAjax, param) {

        $
                .ajax({
                    type: "GET",
                    url: urlAjax,
                    async: false,
                })
                .done(
                        function(datajson) {

                            var titles = datajson["titles"];
                            var columns = [];
                            for (var i = 0; i < titles.length; i++) {
                                columns.push({
                                    title: (titles[i].title).replace(/\$/g, " ").replace(/\_/g, " ")
                                });
                            }



                            var data = datajson["dataSet"];

                            columns
                                    .push({
                                        title: '<i class="glyphicon glyphicon-edit  " style="color:#3665B0;display: block;margin: auto;width: 15px;"></i>'
                                    });
                            columns
                                    .unshift({
                                        title: '<span class="glyphicon glyphicon-check" aria-hidden="true" style="    display: block;margin: auto;width: 15px;"></span>'
                                    });

                            for (var i = 0; i < data.length; i++) {
                                var id_row = data[i][0];
                                var urlobject = generateUri(id_row, routes);
                                var input_control = generateControleInput(urlobject);
                                data[i].push(input_control); // input control
                                // sup modi voir
                                data[i].unshift(" "); // add checkbox
                            }

                            param.columns = columns;
                            param.data = data;

                        });
        return param;
    }
    function setEvent_dataTable(table) {

        table.DataTable().on("select", function(e) {
            var count = table.DataTable().rows({
                selected: true
            }).count();
            $("#btn_remove_group_select").text(count);
        })
        table.DataTable().on("deselect", function(e) {
            var count = table.DataTable().rows({
                selected: true
            }).count();
            $("#btn_remove_group_select").text(count);
        })
        table.on("click", ".supprimer", function(e) {
            e.preventDefault();
            var elem = $(this);
            var urlsup = elem.data("urlsup");
            var urlmessage = elem.data("urlmessage");
            var row = elem.parents("tr");
            if (row.hasClass("child")) {
                row = elem.parents("tr").prev();
            }
            traitement_sup(urlmessage, urlsup, table, row);
        })

    }

    function ajax_sup(urlsup, table, row) {

        if (Array.isArray(urlsup)) {

            var datacontentmessage = "";// message get par php
            var flag = false;
            for (var g = 0; g < urlsup.length; g++) {
                (function(urlsup) {
                    $
                            .ajax({
                                type: "GET",
                                url: urlsup,
                                async: false,
                            })
                            .done(
                                    function(result) {
                                        datacontentmessage += '<div  class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>   '
                                                + result + ' </div>' + "<br>"

                                    })
                            .fail(
                                    function(result) {
                                        flag = true;
                                        var txt = result.responseText;

                                        datacontentmessage += '<div  class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>   '
                                                + txt + '</div>' + "<br>"
                                    });

                })(urlsup[g])
            }

            $.confirm({
                icon: 'glyphicon glyphicon-ok',
                title: 'message!',
                content: '<div>' + datacontentmessage + '</div>',
                buttons: {
                    cancel: {
                        text: 'ok',
                        btnClass: 'btn-blue',
                        keys: ['enter', 'shift'],
                        action: function() {
                            if (flag) {
                                location.reload();
                            } else {
                                table.DataTable().rows({
                                    selected: true
                                }).remove().draw(false);
                                $("#btn_remove_group_select").text("");
                            }

                        }
                    }
                }
            });
        } else {
            $.get(urlsup).done(function(data) {
                $.alert({
                    icon: 'glyphicon glyphicon-ok',
                    closeIcon: true,
                    type: 'green',
                    title: 'message!',
                    content: data,
                });
                table.DataTable().row(row).remove().draw(false);
            }).fail(function(data) {
                $.alert({
                    icon: 'glyphicon glyphicon-warning-sign',
                    closeIcon: true,
                    type: 'red',
                    title: 'message!',
                    content: data.responseText
                });
            });
        }

    }
    function traitement_sup(urlmessage, urlsup, table, row) {
        $.get(urlmessage).done(function(data) {
            $.confirm({
                closeIcon: true,
                backgroundDismiss: false,
                backgroundDismissAnimation: 'glow',
                columnClass: 'col-md-12',
                icon: 'fa fa-spinner fa-spin',
                title: ' Faut-il vraiment supprimer les donnees!',
                content: data,
                type: 'red',
                typeAnimated: true,
                buttons: {
                    confirm: function() {
                        ajax_sup(urlsup, table, row);
                    },
                    cancel: function() {
                    }
                }
            });
        });
    }

    function generateUri(id, routes) {
        var urlarray = routes.replace(/0/g, id).split("~");
        var urlobject = {};
        for (var i = 0; i < urlarray.length; i++) {
            var url = urlarray[i].split("|");
            urlobject[url[0]] = url[1];
        }
        return urlobject;
    }
    function generateControleInput(urlobject) {
        var $message = urlobject["urlmessage"];
        var $supprimer = urlobject["urlsupprimer"];
        var $modifier = urlobject["urlmodifier"];
        var $voir = urlobject["urlvoir"];
        return '<spam style="display: block;margin: auto;   width: max-content;">'
                + '<button class="btn btn-danger   supprimer" data-urlmessage="'
                + $message
                + '"   data-urlsup="'
                + $supprimer
                + '" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'
                + '<a class="btn btn-success  modifier"    href="'
                + $modifier
                + '" ><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>'
                + '<a class="btn btn-primary  voir"    href="'
                + $voir
                + '" ><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>'
                + '</spam>'
    }

}