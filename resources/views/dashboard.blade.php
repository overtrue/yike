<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Yike Dashboard</title>
        <link href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <style>
            body {
                background-color: #EAF0F3;
            }
            [v-cloak] {
                display: none;
            }
        </style>
    </head>
    <body>
        <div id="app" v-cloak></div>
    </body>
    <script src="{{ asset('js/admin.js') }}"></script>
</html>
