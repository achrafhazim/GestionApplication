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
        <div id="test"></div> 
        <script src="/Framework/Jquery/jquery.min.js" type="text/javascript"></script>
        <script>


            var form = $("<form/>",
                    {action: '#', method: 'POST'}
            );
            form.append(
                    $("<select>",
                            {type: 'select',
                                placeholder: 'Keywords',
                                name: 'keyword[]',
                                style: 'width:65%'}
                    ).append($("<option>", {text: 'ok', value: "jj"}))
                    .append($("<option>", {text: 'ok'}))
                    .append($("<option>", {text: 'ok'}))
                    );

            form.append(
                    $("<input>",
                            {type: 'submit',
                                value: 'Search',
                                style: 'width:30%'}
                    )
                    );

            $("#test").append(form)


        </script>
    </body>
</html>
