
function label_form(schema) {

    if (schema.type !== "hidden") {
        let label = $("<label>",
                {
                    for : schema.name,
                    class: "col-sm-3 control-label",
                    style: "text-align: left",

                }
        ).append(schema.name.replace("$", " ") + ' ');
        if (schema.isnull === "NO") {
            var spam = $("<span/>", {class: "glyphicon glyphicon-pencil", 'aria-hidden': "true"});
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
                        name: schema.name,
                        placeholder: schema.default,
                        value: schema.name,
                        "data-live-search": "true",
                        class: "btn-group  form-control input-sm"}
            )
            ;

    $.get("/api/" + schema.name, function(data) {

        let titles = data.titles;
        let dataSet = data.dataSet;
        for (let i = 0, max = dataSet.length; i < max; i++) {
            let textoption = dataSet[i][1];
            let valueoption = dataSet[i][0];
            select.append($("<option>", {text: textoption, value: valueoption}));
        }

        select.selectpicker();

    });
    return select;
}
function textarea_form(schema) {
    return   $("<textarea>",
            {
                name: schema.name,
                placeholder: schema.default,
                value: schema.name,
                class: "form-control input-sm"}
    );
}
function input_form(schema) {

    return   $("<input>",
            {type: schema.type,
                name: schema.name,
                placeholder: schema.default,
                value: schema.default,
                class: "form-control input-sm",
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

    } else {
        input = input_form(schema);

    }
 //   if (schema.isnull === "NO") {
     input.attr("data-set_null",schema.isnull);
   // }

    var divFormGroup = $("<div/>", {class: "form-group"});
// label
    divFormGroup.append(label_form(schema));

    var divinput = $("<div/>", {class: "col-sm-9"});
    divinput.append(input);

    return divFormGroup.append(divinput);


}

var jqxhr = $.get("/api/articles?schema=html", function(schemas) {

    var form = $("<form/>",
            {action: '/articles/ajouter/0',
                method: 'POST',
                class: 'form-horizontal',
                enctype: "multipart/form-data"}
    );

    for (let i = 0, max = schemas.length; i < max; i++) {
        form.append(creetinput(schemas[i]));
    }

    var btn = $("<input>", {type: "submit",
        name: "ajoutdata",
        class: "btn btn-success btn-lg"});
    form.append(btn);
    
    form.submit(function (e) {
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
     * send data par ajax
     */
    function ajaxSendData(formdata) {

        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);

        ajax.open("POST", "http://localhost/Produit/articles/ajouter/0");
        ajax.setRequestHeader("cache-control", "no-cache");

        ajax.send(formdata);
        //  restfull
//        var result = {};
//        for (var entry of formdata.entries())
//        {
//            result[entry[0]] = entry[1];
//        }
//        ///set json string
//        var json = JSON.stringify(result);
//        console.log(json);
//        ajax.send(json);






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
    };
    
    
    
    
    $("#test").append(form);
})
        ;












