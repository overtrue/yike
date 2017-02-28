<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Yike Dashboard</title>
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/element-ui/1.2.1/theme-default/index.css"> --}}
        <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-default/index.css">
        <link rel="stylesheet" type="text/css" href="{{ vendor('material-design-icons/material-icons.css') }}">
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
