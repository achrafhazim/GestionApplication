"use strict";
(function() {

    $("form").submit(function(e) {
        e.preventDefault();
        var formdata = chargeFormData();
        $("#refresh").removeClass("hidden")
        $("form").addClass("hidden")
        // send formdata par ajax
        $('#ModalProgress').modal('show');
        ajaxSendData(formdata);
    });
    function gestion_erreur(elment) {

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
                        + elment.name + " </strong>",
            });
            throw "erreur input vide import";
        }
        return true;
    }
    /**
     * charge form ajax
     */
    function chargeFormData() {
        // new form ajax
        var formdata = new FormData();
        $(
                "input:not([type='submit'],[type='reset'],[type='checkbox'],[type='button'],[type='file']) ,textarea,select:not([multiple])")
                .each(function() {
                    gestion_erreur(this);
                    formdata.append(this.name, $(this).val());
                });
        $("select[multiple]").each(function() {
            gestion_erreur(this);
            var name = this.name;
            $($(this).val()).each(function() {
                formdata.append(name, this);
            })

        });
        $("input[type='file']").each(function() {
            gestion_erreur(this);
            var name = this.name;
            $(this.files).each(function() {
                formdata.append(name, this);
            })
        });
        $("input[type='checkbox']").each(function(key, val) {
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
     * send data par ajax
     */
    function ajaxSendData(formdata) {

        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "#");
        ajax.send(formdata);
    }

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

)()