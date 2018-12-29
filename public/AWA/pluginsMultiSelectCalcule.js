(function() {
    //plugins multiSelect =>> setdata input auto 
// class plugins Multiselect 
    var pluginsMultiSelectCalcule = function(config) {
        /// dat get multiselect
        this.preffixDATA = config.preffixDATA;

        // DOM
        /// bon facture 
        this.$montant_HT = $("#" + config.preffixDOM + "_montant_HT");
        this.$montant_TVA = $("#" + config.preffixDOM + "_montant_TVA");
        this.$montant_TTC = $("#" + config.preffixDOM + "_montant_TTC");

        // achat vente
        this.$factures_TTC = $("#" + config.preffixDOM + "_montant_factures_TTC");
        this.$avoirs_TTC = $("#" + config.preffixDOM + "_montant_avoirs_TTC");

    };
    pluginsMultiSelectCalcule.prototype = {
        parseDOM: function() {
            ///////////////////////////////////////////////
            // val
            this.val_montant_HT = parseFloat((this.$montant_HT.val()) * 1);
            this.val_montant_TVA = parseFloat((this.$montant_TVA.val()) * 1);
            this.val_montant_TTC = parseFloat((this.$montant_TTC.val()) * 1);


            this.val_factures_TTC = parseFloat((this.$factures_TTC.val()) * 1);
            this.val_avoirs_TTC = parseFloat((this.$avoirs_TTC.val()) * 1);

        },
        parseData: function() {
            var preffix = this.preffixDATA
            var data = this.data;
            ///////////////////////////////////////////////
            // data html

            this.ht = parseFloat(data[preffix + "montant_ht"]) * 1;     /// bone|| facture
            this.tva = parseFloat(data[preffix + "montant_tva"]) * 1;
            this.ttc = parseFloat(data[preffix + "montant_ttc"]) * 1;

            this.estime_ht = parseFloat(data[preffix + "montant_estime_ht"]) * 1; // commande


            this.ttc_avoirs = parseFloat(data[preffix + "montant_avoirs_ttc"]) * 1; /// payemment achat
        },
        calcule: function(op, data) {
            this.data = data;
            this.op = op;

            this.parseDOM();
            this.parseData();


            // traitement
            if (this.isNumber(this.val_montant_HT)) {
                if (this.isNumber(this.estime_ht)) {
                    this.calculeCommande();
                } else if (this.isNumber(this.ht)) {
                    this.calculeBoneFacture();
                }
            } else if (this.isNumber(this.val_factures_TTC)) {
                this.calculeReglement();
            }
        },
        calculeCommande: function() {
            this.$montant_HT.val(this.op(this.val_montant_HT, this.estime_ht));
            this.$montant_HT.addClass("input-lg ").keyup();
        },
        calculeBoneFacture: function() {
            this.$montant_HT.val(this.op(this.val_montant_HT, this.ht));
            this.$montant_TVA.val(this.op(this.val_montant_TVA, this.tva));
            this.$montant_TTC.val(this.op(this.val_montant_TTC, this.ttc));

        },
        calculeReglement: function() {
            if (this.isNumber(this.ttc)) {
                this.$factures_TTC.val(this.op(this.val_factures_TTC, this.ttc));
                this.$factures_TTC.keyup();
            } else if (this.isNumber(this.ttc_avoirs)) {
                this.$avoirs_TTC.val(this.op(this.val_avoirs_TTC, this.ttc_avoirs));
                this.$avoirs_TTC.keyup();
            }
        },
        isNumber: function(n) {
            return Number(n) === n;
        }


    };
    window.pluginsMultiSelectCalcule=pluginsMultiSelectCalcule;

})()
