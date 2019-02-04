<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Getting started with JSON Form</title>
        <link href="/Framework/Bootstrap3/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h1>Getting started with JSON Form</h1>
        <div class="col-md-4">
            <form>

            </form>

        </div>

        <div id="res" class="alert"></div>
        <script src="/Framework/Jquery/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="/Framework/underscore.js"></script>
        <script type="text/javascript" src="/Framework/opt/jsv.js"></script>
        <script type="text/javascript" src="/Framework/opt/jquery.ui.core.js"></script>
        <script type="text/javascript" src="/Framework/opt/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="/Framework/opt/jquery.ui.mouse.js"></script>
        <script type="text/javascript" src="/Framework/opt/jquery.ui.sortable.js"></script>


        <script type="text/javascript" src="/Framework/jsonform/jsonform.js"></script>
        <script type="text/javascript">
            $('form').jsonForm(
                    {

                        "schema": {
                            "color": {
                                "title": "Color",
                                "type": "string",
                                "enum": [
                                    "blue",
                                    "spicy",
                                    "gray",
                                    "earth",
                                    "vegetal"
                                ],
                                "default": "gray",
                                "required": true
                            },
                            "backgroundimage": {
                                "title": "Background image for TV version",
                                "type": "object"
                            },
                            "tabs": {
                                "title": "Tabs titles",
                                "type": "array",
                                "items": {
                                    "title": "Short tab title (max. 15 characters)",
                                    "type": "string",
                                    "maxLength": 15
                                }
                            },
                            "tabicons": {
                                "title": "Tabs icons",
                                "maxLength": 8,
                                "type": "array",
                                "items": {
                                    "title": "Tab icon",
                                    "type": "string",
                                    "enum": [
                                        "contact",
                                        "event",
                                        "map",
                                        "news",
                                        "photo",
                                        "product",
                                        "sound",
                                        "status",
                                        "video"
                                    ]
                                }
                            }
                        },
                        "form": [
                            {
                                "type": "fieldset",
                                "legend": "Styles",
                                "items": [
                                    "color",
                                    {
                                        "key": "backgroundimage",
                                        "type": "file-hosted-public"
                                    }

                                ]
                            },
                            {
                                "type": "fieldset",
                                "legend": "Tabs",
                                "items": [
                                    {
                                        "type": "tabarray",
                                        "items": [
                                            {
                                                "type": "section",
                                                "legend": "{{value}}",
                                                "items": [
                                                    {
                                                        "key": "tabicons[]",
                                                        "type": "imageselect",
                                                        "imageWidth": 32,
                                                        "imageHeight": 42,
                                                        "imageButtonClass": "btn-inverse",
                                                        "imagePrefix": "app/images/tv-",
                                                        "imageSuffix": ".png",
                                                        "imageSelectorTitle": "Based on tab data source"
                                                    },
                                                    {
                                                        "key": "tabs[]",
                                                        "valueInLegend": true,
                                                        "value": "{{values.datasources.main[]}}"
                                                    }
                                                ]
                                            }
                                        ]
                                    }
                                ]
                            }
                        ]
                    }

            
            );
        </script>
    </body>
</html>