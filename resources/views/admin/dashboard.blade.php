@extends('partials.app')

@section('extra_style')
    <style>
        table img {
            height: 200px;
            width: 200px;
            border-radius: 20px;
        }

        table a {
            opacity: 0.5;
        }

        table a:hover {
            opacity: 1;
            transition: 0.2s;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumbs">
        <h1>Election Overview</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li class="active">Dashboard</li>
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
                        <li class="active"><a href="index.html"><i class="icon-home"></i> Home </a></li>
                        <li><a href="#"><i class="icon-note "></i> Reports </a></li>
                        <li><a href="{{URL::route('Users.View')}}"><i class="icon-user"></i> User </a></li>
                        <li><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Elections </a></li>
                        <li><a href="#"><i class="icon-bell"></i> Activity Logs </a></li>
                        <li><a href="{{URL::route('State.View')}}"><i class="icon-flag"></i> States & LGAs</a></li>
                        <li><a href="{{URL::route('ward.index')}}"><i class="icon-directions"></i> Polling Units</a></li>
                        <li><a href="{{URL::route('PP.View')}}"><i class="icon-users"></i> Political Parties </a></li>
                        <li><a href="{{URL::route('preference.uploadView')}}"><i class="icon-cloud-upload"></i> Bulk Upload </a></li>
                        <li><a href="{{URL::route('preference.index')}}"><i class="icon-bell"></i> icon-settings </a></li>
                    </ul>
                </nav>
            </div>
            <!-- END PAGE SIDEBAR -->
            <div class="page-content-col">
            <table style="padding: 5px;" class="table">
            <tr>
                <td>
                    <center>
                        <a href="{{URL::route('Election.View')}}">
                            <img src="{{ asset('images/election.png') }}" class="img-thumbnail  img-circle">
                            <h3>Elections</h3>
                        </a>
                    </center>
                </td>
                <td>
                    <center>
                        <a href="{{URL::route('Users.View')}}"><img src="{{ asset('images/users.png') }}" class="img-thumbnail img-circle">
                        <h3>Users</h3></a>
                    </center>
                </td>
                <td>
                    <center>
                        <a href=""><img src="{{ asset('images/reports.png') }}" class="img-thumbnail img-circle">
                        <h3>Reports</h3></a>
                    </center>
                </td>
                <td>
                    <center>
                        <a href="{{URL::route('preference.uploadView')}}"><img src="{{ asset('images/bulk-upload.png') }}" class="img-thumbnail img-circle">
                        <h3>Bulk Upload</h3></a>
                    </center>
                </td>
            </tr>
            <tr>
                <td>
                    <center>
                        <a href="{{URL::route('PP.View')}}"><img src="{{ asset('images/party.png') }}" class="img-thumbnail  img-circle">
                        <h3>Political Parties</h3></a>
                    </center>
                </td>
                <td>
                    <center>
                        <a href="{{URL::route('State.View')}}"> <img src="{{ asset('images/state.png') }}" class="img-thumbnail img-circle">
                        <h3>States & LGAs</h3></a>
                    </center>
                </td>
                <td>
                    <center>
                        <a href="{{URL::route('ward.index')}}"><img src="{{ asset('images/polling-unit.jpg') }}" class="img-thumbnail img-circle">
                        <h3>Wards & Polling Units</h3></a>
                    </center>
                </td>
                <td>
                    <center>
                        <a href="{{URL::route('preference.index')}}"><img src="{{ asset('images/preferences.png') }}" class="img-thumbnail img-circle">
                        <h3>Preferences</h3></a>
                    </center>
                </td>
            </tr>
        </table>
            </div>
    <!-- <div class="container">
        <div class="row">
            <div class="col-12">
                @include('partials.notifications')
            </div>
            <div class="col-12 col-xl-12" style="margin-top: 5px;">
                <div class="block block-content">
                    <img class="img-avatar pull-right" src="{{ asset('images/logo.png') }}" alt="">
                    <h3 style="margin-bottom:5px;"><i class="fa fa-dashboard"></i> Welcome to ElectNG!</h3>
                    <p style="font-size:16px;">
                        We've put together some quick links to get you started right away.. 
                        <strong><i class="si si-question create-hover" data-toggle="tooltip" title="Click on the quick link on the top menu to get started."></i></strong>
                    </p>
                    <p>
                        | <a href="{{URL::route('Election.View')}}"><i class="si si-magnifier-add"></i> View Elections</a> |
                        <a href="{{URL::route('Dashboard')}}"><i class="si si-book-open"></i> View Polling Stations</a> | 
                        <a href="{{URL::route('Dashboard')}}"><i class="si si-users"></i> View Users</a> | 
                        <a href="{{URL::route('Dashboard')}}"><i class="si si-settings"></i> Preferences</a> | 
                    </p>
                </div>
            </div>
        </div><br/>
        
        
    </div>END Page Content -->
@endsection
@section('extra_script')
    <script src="{{ asset('js/plugins/slick/slick.min.js') }}"></script>
@endsection