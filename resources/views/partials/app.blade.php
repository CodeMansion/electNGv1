<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="author" content="">
        <meta name="description" content="" />
        <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png" />

        <title>ElectNG&trade; | Dashboard </title>
        
        <link href="{{ asset('css/codebase.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('js/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
        @yield('extra_style')
    </head>
    <body>
        <div id="page-container" class="sidebar-o sidebar-mini sidebar-inverse side-scroll side-scroll page-header-fixed page-header-inverse">
            <!-- top menu content -->
            <!--  -->
            <!-- side menu content -->
            @include('partials.side-nav')
            <!-- header content -->
            @include('partials.header')

            <!-- main page contents -->
            @yield('content')

            <!-- footer content -->
            @include('partials.footer')

            <!--modals inclusion -->
            @yield('modals')
        </div>

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
        <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

        <!---notification messages---->
        <script src="{{ asset('js/notify.min.js') }}"></script>
        @if(\Session::has('error'))
            <!-- notification script -->
            <script type="text/javascript">
                $.notify('{!! \Session::get('error') !!}', "error");
            </script>
        @endif
        @if(\Session::has('success'))
            <!-- notification script -->
            <script type="text/javascript">
                $.notify('{!! \Session::get('success') !!}', "success");
            </script>
        @endif
        @if(\Session::has('info'))
            <!-- notification script -->
            <script type="text/javascript">
                $.notify('{!! \Session::get('info') !!}', "info");
            </script>
        @endif
        @if(\Session::has('warning'))
            <!-- notification script -->
            <script type="text/javascript">
                $.notify('{!! \Session::get('warning') !!}', "warning");
            </script>
        @endif

        <script>
            $(document).ready(function(){
                $("#close-notify").on("click", function(){
                    $("#close").hide();
                });
            });
        </script>

        <!-- extra javascript plugins included here -->
        @yield('extra_script')
    </body>
</html>
    