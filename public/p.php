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
                            "name": {
                                "title": "Name",
                                "description": "Nickname allowed",
                                "type": "string"
                            },
                            "gender": {
                                "title": "Gender",
                                "description": "Your gender",
                                "type": "string",
                                "enum": [
                                    "male",
                                    "female",
                                    "alien"
                                ]
                            }
                        },
                        "form": [
                            {
                                "key": "name"
                            },
                            {
                                "type": "submit",
                                "title": "Submit"
                            }
                        ]
                    }


            );
        </script>
    </body>
</html>