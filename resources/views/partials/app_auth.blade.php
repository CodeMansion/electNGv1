<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="author" content="">
        <meta name="description" content="" />
        
        <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png" />

        <title>ElectNG&trade; | Login Page </title>
        <link href="{{ asset('css/codebase.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/login-custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

        @yield('extra_style')
    </head>
    <body>
        @yield('login_content')
    </body>

    <!-- Codebase Core JS -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollLock.min.js') }}"></script>
    <script src="{{ asset('js/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('js/jquery.countTo.min.js') }}"></script>
    <script src="{{ asset('js/js.cookie.min.js') }}"></script>
    <script src="{{ asset('js/codebase.js') }}"></script>

    <script src="{{ asset('js/loadingoverlay.min.js') }}"></script>
</html>