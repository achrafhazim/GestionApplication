"use strict";
var affiche = document.getElementById("affiche");

$("select")
        .change(
                function() {
                    var name = this.name;
                    var charge = "";
                    $("select option:selected")
                            .each(
                                    function() {
                                        var text = $(this).data("infocontent")
                                                .split("£££");

                                        text.pop();
                                        var info = "<div class='panel panel-primary'>  <div class='panel-heading'>"
                                                + name.replace("$", " ")
                                                .toUpperCase()
                                                + "</div><div class='panel-body'   <p>";
                                        for (var i = 0; i < text.length; i++) {
                                            var data = text[i].split("$$$");
                                            var label = data[0].replace("$",
                                                    " ").toUpperCase();
                                            var content = data[1];
                                            info += "<strong> " + label
                                                    + "     :</strong>   "
                                                    + content + "<br>";
                                        }
                                        charge = charge
                                                + info
                                                + "<hr></p></div> <div class='panel-footer'>  </div> </div>";
                                    });

                    $(affiche).html(charge);
                }).trigger("change");
