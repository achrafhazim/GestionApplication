<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        /**
         *
         * http://localhost/api/bons$achats?schema=html
         * 
         * http://localhost/api/bons$achats?schema=f_key   ===>get name FOREIGN_KEY
         *  si is
         *     [raison$sociale]
         *      http://localhost/api/raison$sociale ===>select charge
         * 
         * http://localhost/api/bons$achats?schema=c_table  ==>get name table child
         *   si is
         *     [
          "articles",
          "commandes"
          ]
         *        http://localhost/api/articles?schema=f_key   ===>get name FOREIGN_KEY
         *        []
         *        http://localhost/api/r_bons$achats_articles?schema=html
         *        si complex
         *          http://localhost/api/articles ===>select charge  
         *        
         *       
         *      
         *        http://localhost/api/commandes?schema=f_key   ===>get name FOREIGN_KEY
         *        [raison$sociale]
         *        http://localhost/api/r_bons$achats_commandes?schema=html
         *        si simple
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         */
        ?>
        <div id="test"></div> 
        <script src="/Framework/Jquery/jquery.min.js" type="text/javascript"></script>

        <script>
            
            function creetinput(schema) {
                let _name = schema.name;
                let _type = schema.type;
                let _isnull = schema.isnull;
                let _default = schema.default;
                var div = $("<div/>");
                div.append(
                        $("<label>",
                                {
                                    for : _name,
                                    
                                    style: 'width:30%'}
                        )
                        ).append(_name);
                
                
                if (_type === "select") {
                    
                    var select =
                            $("<select>",
                                    {
                                        name: _name,
                                        placeholder: _default,
                                        value: _name,
                                        style: 'width:30%'}
                            )
                            ;
                    
                    $.get("api/clients", function(data) {
                        let titles = data.titles;
                        let dataSet = data.dataSet;
                        for (let i = 0, max = dataSet.length; i < max; i++) {
                            let textoption=dataSet[i][1];
                            select.append($("<option>", {text: textoption, value: textoption}));
                        }
                        
                    });
                    div.append(select);
                    
                    
                } else if (_type === "textarea") {
                    div.append(
                            $("<textarea>",
                                    {
                                        name: _name,
                                        placeholder: _default,
                                        value: _name,
                                        style: 'width:30%'}
                            )
                            );
                } else {
                    div.append(
                            $("<input>",
                                    {type: _type,
                                        name: _name,
                                        placeholder: _default,
                                        value: _name,
                                        style: 'width:30%'}
                            )
                            );
                }
                
                
                
                return div;
                
            }
            
            var jqxhr = $.get("api/bons$achats?schema=html", function(schemas) {
                
                var form = $("<form/>",
                        {action: '#', method: 'POST'}
                );
                
                for (let i = 0, max = schemas.length; i < max; i++) {
                    form.append(creetinput(schemas[i]));
                }
                
                
//                form.append(
//                        $("<select>",
//                                {type: 'select',
//                                    placeholder: 'Keywords',
//                                    name: 'keyword[]',
//                                    style: 'width:65%'}
//                        )
//                        .append($("<option>", {text: 'ok', value: "jj"}))
//                        .append($("<option>", {text: 'ok'}))
//                        .append($("<option>", {text: 'ok'}))
//                        );
                
                
                
                $("#test").append(form);
            })
                    ;
            
            
            
            
            
            
            
        </script>
    </body>
</html>
