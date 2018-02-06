<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Election Result and Collation Management System | ElectNG</title>

    <!-- Styles -->
    <link href="{{ asset('webfont/css/materialdesignicons.min.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/materialize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/application.css') }}" rel="stylesheet">
    <!--Page Styles -->
    @yield('page_styles')
</head>
<body class="body">
    <div class="top-header z-depth-5">
        <div class="container">
        <div class="">
            <nav class="transparent z-depth-0">
                <div class="nav-wrapper black-text">
                    <div class="nav-wrapper">
                        <a href="#!" class="brand-logo"><i class="material-icons">cloud</i>Elect-NG</a>
                        <ul id="nav-mobile" class="right hide-on-med-and-down">
                            <li><a href="javascript:;">Documentation</a></li>
                            <li><a href="javascript:;">Pricing</a></li>
                            <li><a href="javascript:;">Demo</a></li>
                            <li><a href="javascript:;">Contact</a></li>
                            <li><a href="{{url('login')}}">Sign in</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            </div>
        </div>
    </div>
   <!-- Page Layout here -->
    
    @yield('content')

   <!-- Scripts -->
   <script src="{{ asset('js/materialize/jquery-3.3.1.js') }}"></script>
   <script src="{{ asset('js/materialize/materialize.js') }}"></script>
   @yield('page_scripts')
   <script type="text/javascript">
       $(document).ready(function(){
           $('.modal').modal();
           //SIDENAV
           $(".button-collapse").sideNav();
           $('.tooltipped').tooltip({delay: 50});
       });
   </script>

   <!--Notification memssages-->
   @if($errors->has('email') || $errors->has('password'))
       <!-- notification script -->
       <script type="text/javascript">
           Materialize.toast('{{ $errors->first('email') }} {{ $errors->first('password') }}', 4000, 'red');
       </script>
   @endif
   @if(\Session::has('error'))
       <!-- notification script -->
       <script type="text/javascript">
           Materialize.toast('{!! \Session::get('error') !!}', 4000, 'red');
       </script>
   @endif
   @if(\Session::has('success'))
       <!-- notification script -->
       <script type="text/javascript">
           Materialize.toast('{!! \Session::get('success') !!}', 4000, 'green');
       </script>
   @endif
   @if(\Session::has('info'))
       <!-- notification script -->
       <script type="text/javascript">
           Materialize.toast('{!! \Session::get('info') !!}', 4000, 'blue');
       </script>
   @endif
   @if(\Session::has('warning'))
       <!-- notification script -->
       <script type="text/javascript">
           Materialize.toast('{!! \Session::get('warning') !!}', 4000, 'yellow');
       </script>
   @endif

</body>
</html>
