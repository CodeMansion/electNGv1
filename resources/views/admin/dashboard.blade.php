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
        <h1>Dashboard</h1>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </div>
    <!-- BEGIN SIDEBAR CONTENT LAYOUT -->
    <div class="page-content-container">
        <div class="page-content-row">
            <!-- BEGIN PAGE SIDEBAR -->
            <div class="page-sidebar">
                <nav class="navbar" role="navigation">
                    <ul class="nav navbar-nav margin-bottom-35">
                        @if(\Auth::user()->isAn('admin'))
                            <li class="active"><a href="{{ URL::route('Dashboard') }}"><i class="icon-home"></i> Home </a></li>
                            <li><a href="#"><i class="icon-note "></i> Reports </a></li>
                            <li><a href="{{URL::route('Users.View')}}"><i class="icon-user"></i> Manage Users </a></li>
                            <li><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Elections </a></li>
                            <li><a href="{{URL::route('polling.index')}}"><i class="icon-directions"></i> Polling Stations</a></li>
                            <li><a href="{{URL::route('PP.View')}}"><i class="icon-users"></i> Political Parties </a></li>
                            <li><a href="{{URL::route('preference.uploadView')}}"><i class="icon-cloud-upload"></i> Bulk Upload </a></li>
                            <li><a href="{{URL::route('preference.index')}}"><i class="icon-bell"></i> System Settings </a></li>
                        @endif
                        @if(\Auth::user()->isAn('moderator'))
                            <li class="active"><a href="{{ URL::route('Dashboard') }}"><i class="icon-home"></i> Home </a></li>
                            <li><a href="#"><i class="icon-note "></i> Reports </a></li>
                            <li><a href="{{URL::route('Users.View')}}"><i class="icon-user"></i> Manage Users </a></li>
                            <li><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Elections </a></li>
                            <li><a href="{{URL::route('polling.index')}}"><i class="icon-directions"></i> Polling Stations</a></li>
                            <li><a href="{{URL::route('PP.View')}}"><i class="icon-users"></i> Political Parties </a></li>
                            <li><a href="{{URL::route('preference.uploadView')}}"><i class="icon-cloud-upload"></i> Bulk Upload </a></li>
                        @endif
                        @if(\Auth::user()->isAn('agent'))
                            <li class="active"><a href="{{ URL::route('Dashboard') }}"><i class="icon-home"></i> Home </a></li>
                            <li><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Elections </a></li>
                            <li><a href="#"><i class="icon-directions"></i> My Profile</a></li>
                            <li><a href="#"><i class="icon-directions"></i> Change Password</a></li>
                        @endif
                        @if(\Auth::user()->isAn('contestant'))
                        <li class="active"><a href="index.html"><i class="icon-home"></i> Home </a></li>
                            <li><a href="#"><i class="icon-note "></i> Reports </a></li>
                            <li><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Elections </a></li>
                            <li><a href="{{URL::route('polling.index')}}"><i class="icon-directions"></i> Polling Stations</a></li>
                            <li><a href="{{URL::route('PP.View')}}"><i class="icon-users"></i> Political Parties </a></li>
                        @endif
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
                                <h3>States</h3></a>
                            </center>
                        </td>
                        <td>
                            <center>
                                <a href="{{URL::route('polling.index')}}"><img src="{{ asset('images/polling-unit.jpg') }}" class="img-thumbnail img-circle">
                                <h3>Polling Stations</h3></a>
                            </center>
                        </td>
                        <td>
                            <center>
                                <a href="{{URL::route('preference.index')}}"><img src="{{ asset('images/preferences.png') }}" class="img-thumbnail img-circle">
                                <h3>System Settings</h3></a>
                            </center>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('extra_script')
@endsection