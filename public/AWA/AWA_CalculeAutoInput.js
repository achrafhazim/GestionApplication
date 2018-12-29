(function() {
    // calcul tva avoir ttc HT ... input auto
    var AWA_CalculeAutoInput = function(config) {

        var preffix = config.preffix || "id_html";
        this.graph = config.graph || [];


        if (($("#" + preffix + "_Reglement_TTC").val()) !== undefined) {
            this.factures_TTC = $("#" + preffix + "_montant_factures_TTC");
            this.avoirs_TTC = $("#" + preffix + "_montant_avoirs_TTC");
            this.paye_TTC = $("#" + preffix + "_Reglement_TTC");

            this.event_calcule_reglement();
        } else {
            if (($("#" + preffix + "_montant_HT").val()) !== undefined) {
                this.HT = $("#" + preffix + "_montant_HT");
                this.TVA = $("#" + preffix + "_montant_TVA");
                this.TTC = $("#" + preffix + "_montant_TTC");
                this.event_calcule_simple();
            } else if (($("#" + preffix + "_montant_avoirs_HT").val()) !== undefined) {
                this.HT = $("#" + preffix + "_montant_avoirs_HT");
                this.TVA = $("#" + preffix + "_montant_avoirs_TVA");
                this.TTC = $("#" + preffix + "l_montant_avoirs_TTC");
                this.event_calcule_simple();
            }

        }
    }
    AWA_CalculeAutoInput.prototype = {

        stylepaye_TTC: function(paye_TTC) {

            paye_TTC.prop('readonly', true);
            if (paye_TTC.val() < 0.00) {
                paye_TTC.css('background-color', 'red')
                        .css('color', '#000')
                        .addClass("input-lg ");
            } else if (paye_TTC.val() > 0.00) {
                paye_TTC.css('background-color', '#00ff80')
                        .css('color', '#000')
                        .addClass("input-lg ");
            } else {
                paye_TTC.css('background-color', '#ffffff')
                        .css('color', '000')
                        .removeClass("input-lg ");
            }

        },

        change: function(input, value) {

            for (var i = 0; i < this.graph.length; i++) {
                this.graph[i].data_init(value, " Reste de Reglement TTC");
            }
        },

        calcule_paye_TTC: function(value_avoir_TTC, value_factures_TTC) {
            if (isNaN(value_avoir_TTC)) {
                this.paye_TTC.val(value_factures_TTC);
            } else {
                this.paye_TTC.val(this.moins(value_factures_TTC, value_avoir_TTC));
            }

            this.change("paye_TTC", this.paye_TTC.val());
            this.stylepaye_TTC(this.paye_TTC);
        },
        calcule_ht: function(HT) {

            var valueHT = ($(HT).val()) * 1;
            var valueTVA = (valueHT * 0.2);
            var valueTTC = this.plus(valueTVA, valueHT);
            this.TVA.val(valueTVA.toFixed(2));
            this.TTC.val(valueTTC);
        },
        calcule_tva: function(TVA) {
            var valueHT = (this.HT.val()) * 1;
            var valueTVA = ($(TVA).val()) * 1;
            var valueTTC = this.plus(valueTVA, valueHT);
            this.TTC.val(valueTTC);
        },
        calcule_ttc: function(TTC) {
            var valueTTC = ($(TTC).val()) * 1;
            var valueHT = (valueTTC / 1.2);
            var valueTVA = this.moins(valueTTC, valueHT);
            this.TVA.val(valueTVA);
            this.HT.val(valueHT.toFixed(2));
        },

        event_calcule_simple: function() {
            var self = this;
            this.HT.keyup(function() {
                self.calcule_ht(this);
            }).keyup();
            this.TVA.keyup(function() {
                self.calcule_tva(this);
            }).keyup();
            this.TTC.keyup(function() {
                self.calcule_ttc(this);
            }).keyup();
        },
        event_calcule_reglement: function() {
            var self = this;
            this.factures_TTC.keyup(function() {
                var value_factures_TTC = ($(this).val()) * 1;
                var value_avoir_TTC = (self.avoirs_TTC.val()) * 1;
                self.calcule_paye_TTC(value_avoir_TTC, value_factures_TTC);

            }).keyup();
            this.avoirs_TTC.keyup(function() {
                var value_factures_TTC = (self.factures_TTC.val()) * 1;
                var value_avoir_TTC = ($(this).val()) * 1;

                self.calcule_paye_TTC(value_avoir_TTC, value_factures_TTC);

            }).keyup();
        },
        plus: function(a, b) {
            return ((a + b).toFixed(2));
        },
        moins: function(a, b) {
            return ((a - b).toFixed(2));
        }

    }

    window.AWA_CalculeAutoInput = AWA_CalculeAutoInput;

})()