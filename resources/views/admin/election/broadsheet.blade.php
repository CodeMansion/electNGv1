@extends('partials.app')
@section('extra_style')
    <link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/pages/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .content .block-content label {
            margin-right: 10px;
            font-size: 15px;
        }
    </style>
    {!! Charts::assets() !!}
@endsection
@section('content')
<?php $settings = \App\Preference::first(); ?>
<div class="breadcrumbs">
        <h1>{{$election['name']}} </h1>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Election</a></li>
            <li class="active">{{$election['name']}}</li>
        </ol>
    </div>
    <!-- BEGIN SIDEBAR CONTENT LAYOUT -->
    <div class="page-content-container">
        <div class="page-content-row">
            <!-- BEGIN PAGE SIDEBAR -->
            <div class="page-sidebar">
                <nav class="navbar" role="navigation">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <ul class="nav navbar-nav margin-bottom-35">
                        <li><a href="#"><i class="icon-home"></i> Home </a></li>
                        <li><a href="{{ URL::route('view.reports', $election['slug']) }}"><i class="icon-note "></i> View Reports </a></li>
                        <li><a href="{{URL::route('Users.View')}}"><i class="icon-flag"></i> Win Metrics </a></li>
                        <li class="active"><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Broadsheet </a></li>
                        <li><a href="{{ URL::route('view.activity',$election['slug']) }}"><i class="icon-bell"></i> Activity Logs </a></li>
                        <li><a href="{{ URL::route('PasscodeView',$election['slug']) }}"><i class="icon-user"></i> Passcodes</a></li>
                        <li><a href="{{URL::route('ward.index')}}"><i class="icon-directions"></i> Party Agents</a></li>
                        <li><a href="{{ URL::route('SubmittedResult',$election['slug']) }}"><i class="icon-bell"></i> View Result </a></li>
                    </ul>
                </nav>
            </div>
            <!-- END PAGE SIDEBAR -->
            <div class="page-content-col">
                @include('partials.notifications')
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <!-- BEGIN Portlet PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-green-sharp">
                                    <i class="icon-speech font-green-sharp"></i>
                                    <span class="caption-subject bold uppercase"> {{$election['name']}} - RESULT BOARDSHEET</span>
                                    <span class="caption-helper">Display infographics of realtime result ...</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div id="loader" style="display:none;margin-top:10px;">
                                    <center><img src="{{asset('images/loading.gif')}}"> Refreshing ...</center>
                                </div>
                                <div id="displayChart">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra_script')
    <script src="{{ asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <!-- <script src="{{ asset('assets/global/plugins/echarts/echarts.js') }}" type="text/javascript"></script> -->
    <script>
        var STATS = "{{ URL::route('Election.Stats') }}";
        var MILISEC = "{{ $setting['page_refresh_interval'] }}"
        var SLUG = "{{ $election['slug'] }}";
        var TOKEN = "{{ csrf_token() }}";
    </script>
@endsection
@section('after_script')
    <script src="{{ asset('js/pages/broadsheet.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
@endsection
@section('modals')
@endsection
