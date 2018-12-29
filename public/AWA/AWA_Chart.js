//les class
//graphique style show
var AWA_Chart = function(config) {
    var canva = document.getElementById(config.ElementById);
    if (!canva) {
        throw new Error('ereur select  id element canva ')
    }
    var type = config.type || 'pie';
    var title = config.title || ' ';
    var options = config.options || {
        responsive: true,
        title: {
            display: true,
            text: title
        }
    };

    var self = this;
    this.GRAPHIQUE = new Chart(canva,
            {
                // The type of chart we want to create
                type: type,
                // The data for our dataset
                data: {
                    labels: [" "],
                    datasets: [{
                            data: [0],

                            backgroundColor: self.chart_Color_theme.chartBackgroundColor,
                            borderColor: self.chart_Color_theme.chartBorderColor,
                            borderWidth: 1,
                        }]
                },
                // Configuration options go here
                options: options
            });
    this.data_init(" Reste de Reglement TTC", 0)

}
AWA_Chart.prototype = {
    init: {label: "", dataset: 0},
    plugins: {},
    row: [],
    chart_Color_theme: {
        chartBackgroundColor: [
            
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255,99,132,0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(255,99,132,0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)',
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
        ],
        chartBorderColor: [
            
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
        ]

    },

    calcule_Reste_Reglement: function() {

        //comteur 1 pars==> 0 init
        var values_set = this.GRAPHIQUE.data.datasets[0].data;
        var somme = 0;
        for (var i = 1; i < values_set.length; i++) {
            somme = somme + Number(values_set[i]);
        }

        var value_init = Number(this.init.dataset);
        this.GRAPHIQUE.data.datasets[0].data[0] = (value_init - somme);
    },
    addData: function(label, data) {
        this.GRAPHIQUE.data.labels.push(label);
        //dataset pluseieur element avec un sel lable
        this.GRAPHIQUE.data.datasets.forEach((dataset) => {
            dataset.data.push(data);
        });
        this.GRAPHIQUE.update();
    },
    removeAllData: function() {
        this.GRAPHIQUE.data.labels = [];
        this.GRAPHIQUE.data.datasets.forEach((dataset) => {
            dataset.data = [];
        });
        this.row = [];
        this.row[0] = this.init;
        this.GRAPHIQUE.update();
    },
    set_Data: function(plugin, data) {
        this.plugins[plugin] = data;
        this.update();
    },
    update: function() {
        this.removeAllData();
        /// merge les plugin ==>row
        for (var plugin in this.plugins) {
            this.row = this.row.concat(this.plugins[plugin]);
        }

        // set row
        for (var i = 0; i < this.row.length; i++) {
            var label = this.row[i].label;
            var dataset = this.row[i].dataset;
            // set dat graph
            this.addData(label, dataset);

        }



        this.calcule_Reste_Reglement();

        this.GRAPHIQUE.update();


    },
    data_init: function(dataset, label) {
        this.removeAllData();
        if (dataset && label) {
            this.init.label = label;
            this.init.dataset = dataset;
        }
        this.row[0] = this.init;
        this.update();

    }

}