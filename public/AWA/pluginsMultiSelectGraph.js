
(function() {

//*******************************************************//
//plugins multiSelect =>> graph
// class plugins Multiselect 
    var pluginsMultiSelectGraph = function(config) {
        this.preffixDATA = config.preffixDATA;
        this.graph = config.graph || [];
        this.label = config.label;
        this.dataset = config.dataset;
    }
    pluginsMultiSelectGraph.prototype = {
        show: function(element) {
            //  console.log(element.find('option:selected'));
            var data = element.find('option:selected');
            var row = [];
            for (var i = 0; i < data.length; i++) {
                var ob = {};
                ob.label = $(data[i]).data(this.preffixDATA + this.label);
                ob.dataset = $(data[i]).data(this.preffixDATA + this.dataset);
                if (ob.label && ob.dataset) {
                    row.push(ob);
                }
            }

            for (var i = 0; i < this.graph.length; i++) {
                this.graph[i].set_Data(element.attr('id'), row);
            }


        }

    };
    window.pluginsMultiSelectGraph = pluginsMultiSelectGraph;

})()
