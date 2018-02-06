<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="author" content="">
        <meta name="description" content="" />
        
        <link rel="shortcut icon" href="{{ asset('images/elect-ng-logo.png') }}" type="image/png" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <title>Elect-NG&trade; | Login Page </title>
        
        <link href="{{ asset('webfont/css/materialdesignicons.min.css') }}" media="all" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/materialize.css') }}" rel="stylesheet">
        <link href="{{ asset('css/login.css') }}" rel="stylesheet">

        @yield('extra_style')
    </head>
    <body class="body">
        @yield('login_content')
    </body>

    <!-- Codebase Core JS -->
    <script src="{{ asset('js/materialize/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('js/materialize/materialize.js') }}"></script>
    <script>
        $(document).ready(function() {
            Materialize.updateTextFields();
        });
    </script>
</html>