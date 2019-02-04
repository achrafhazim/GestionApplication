<html>
    <head>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
        <link rel='stylesheet' href='https://unpkg.com/formiojs@latest/dist/formio.full.min.css'>
        <script src='https://unpkg.com/formiojs@latest/dist/formio.full.min.js'></script>
        <script type='text/javascript'>
            window.onload = function () {
                Formio.createForm(document.getElementById('formio'), {
                    "display": "form",
                    "components": [
                        {
                            "label": "Number",
                            "mask": false,
                            "tableView": true,
                            "alwaysEnabled": false,
                            "type": "number",
                            "input": true,
                            "key": "number2"
                        },
                        {
                            "label": "Select Boxes",
                            "optionsLabelPosition": "right",
                            "values": [
                                {
                                    "label": "",
                                    "value": "",
                                    "shortcut": ""
                                }
                            ],
                            "mask": false,
                            "tableView": true,
                            "alwaysEnabled": false,
                            "type": "selectboxes",
                            "input": true,
                            "key": "selectBoxes2",
                            "defaultValue": {
                                "": false
                            },
                            "validate": {
                                "customMessage": "",
                                "json": ""
                            },
                            "conditional": {
                                "show": "",
                                "when": "",
                                "json": ""
                            },
                            "inputType": "checkbox",
                            "encrypted": false,
                            "properties": {},
                            "customConditional": ""
                        },
                        {
                            "label": "Select",
                            "mask": false,
                            "tableView": true,
                            "alwaysEnabled": false,
                            "type": "select",
                            "input": true,
                            "key": "select2",
                            "defaultValue": "",
                            "validate": {
                                "customMessage": "",
                                "json": ""
                            },
                            "conditional": {
                                "show": "",
                                "when": "",
                                "json": ""
                            },
                            "data": {
                                "values": [
                                    {
                                        "label": "1",
                                        "value": "1"
                                    },
                                    {
                                        "label": "2",
                                        "value": "2"
                                    }
                                ]
                            },
                            "encrypted": false,
                            "valueProperty": "value",
                            "properties": {},
                            "customConditional": ""
                        },
                        {
                            "type": "button",
                            "label": "Submit",
                            "key": "submit",
                            "disableOnInvalid": true,
                            "theme": "primary",
                            "input": true,
                            "tableView": true
                        }
                    ]
                  
                });
            };
        </script>
    </head>
    <body>
        <div id='formio'></div>
    </body>
</html>