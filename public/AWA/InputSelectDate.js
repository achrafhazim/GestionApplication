"use strict";
// block option date inculd moment() fram work

        /// pour set date in option select dans InputSelectDate
        
        var personnalise = $("#InputOptionDate_show_per");
        var CeMois = $("#InputOptionDate_Ce_mois_ci");
        var moisDernier = $("#InputOptionDate_mois_dernier");
        var derniers3Mois = $("#InputOptionDate_3_derniers_mois");
        var derniers6Mois = $("#InputOptionDate_6_derniers_mois");
        var cetteAnnee = $("#InputOptionDate_cette_annee");
        var anneeDerniere = $("#InputOptionDate_l_annee_derniere");


        var $date = moment();
        var $anne = $date.get("year");
        var $mois = $date.get('month');
        ;

        personnalise.data("dateselectstart", "");
        personnalise.data("dateselectfin", "");

        CeMois.data("dateselectstart", $date.format("01/MM/YYYY"));
        CeMois.data("dateselectfin", moment([$anne, 0, 31]).month($mois).format("DD/MM/YYYY"));

        moisDernier.data("dateselectstart", moment().subtract(1, 'month').format("01/MM/YYYY"));
        moisDernier.data("dateselectfin", $date.format("DD/MM/YYYY"));


        var der3m = moment().subtract(3, 'month').format("01/MM/YYYY");
        derniers3Mois.data("dateselectstart", der3m);
        derniers3Mois.data("dateselectfin", moment(der3m, "DD/MM/YYYY").add(3, 'month').subtract(1, 'days').format("DD/MM/YYYY"));


        var der6m = moment().subtract(6, 'month').format("01/MM/YYYY");
        derniers6Mois.data("dateselectstart", der6m);
        derniers6Mois.data("dateselectfin", moment(der6m, "DD/MM/YYYY").add(6, 'month').subtract(1, 'days').format("DD/MM/YYYY"));

        cetteAnnee.data("dateselectstart", moment().format("01/01/YYYY"));
        cetteAnnee.data("dateselectfin", moment().format("31/12/YYYY"));

        anneeDerniere.data("dateselectstart", moment().subtract(1, 'year').format("01/01/YYYY"));
        anneeDerniere.data("dateselectfin", moment().subtract(1, 'year').format("31/12/YYYY"));




        /// pour charge inpute startinputDate et fininputDate par select input
        var InputSelectDate = document.getElementById("InputSelectDate");

        var groupInputDateStartFin = document.getElementById("groupInputDateStartFin");
        var startinput = document.getElementById("startinputDate");
        var fininput = document.getElementById("fininputDate");



        /// pour dateRange ===>Personnalis

        $(groupInputDateStartFin).dateRangePicker(
                {
                  separator: ' - ',
                  getValue: function ()
                  {
                    if ($(startinput).val() && $(fininput).val())
                      return $(startinput).val() + ' to ' + $(fininput).val();
                    else
                      return '';
                  },
                  setValue: function (s, s1, s2)
                  {
                    $(startinput).val(s1);
                    $(fininput).val(s2);
                  }
                  ,

                  language: 'fr',
                  startOfWeek: 'monday',

                  format: 'DD/MM/YYYY ',
                  autoClose: false

                }
        );



        $(InputSelectDate)
                .change(function () {
                  var start = "";
                  var fin = "";


                  $("#InputSelectDate option:selected").each(function () {

                    start = $(this).data("dateselectstart");
                    fin = $(this).data("dateselectfin");

                  });


                  $(startinput).val(start);
                  $(fininput).val(fin);

                })
                .trigger("change");


