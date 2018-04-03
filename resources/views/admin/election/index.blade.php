@extends('partials.app')
@section('extra_style')
    <!--customize styling for student resource-->
    <link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="breadcrumbs">
        <h1>Elections</h1>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">Dashboard</a></li>
            <li class="active">Election</li>
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
                @include('partials.notifications')
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <!-- BEGIN Portlet PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-green-sharp">
                                    <i class="icon-speech font-green-sharp"></i>
                                    <span class="caption-subject bold uppercase"> Election List</span>
                                    <span class="caption-helper">weekly stats...</span>
                                </div>
                                <div class="actions">
                                    <a href="javascript:;" data-toggle="modal" data-target="#new-election" class="btn btn-circle btn-default btn-sm"><i class="fa fa-plus"></i> Add </a>
                                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                @if(count($userElections) < 1)
                                    <div class="alert alert-danger">
                                        <em>No Election Found.</em>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <table class="table table-striped table-hover" id="sample_2">
                                                <thead>
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>NAME</th>
                                                        <th>DESCRIPTION</th>
                                                        <th>STATUS</th>
                                                        <th>START DATE</th>
                                                        <th>END DATE</th>
                                                        <th>TYPE</th>
                                                        <th>ACTIONS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php($index=0)
                                                    @php($count=1)
                                                    @foreach($userElections as $election)
                                                        <tr>
                                                            <td>{{ $count }}</td>
                                                            <td>{{$election['name']}}</td>
                                                            <td>{{$election['description']}}</td>
                                                            <td><span class="badge badge-{{$election->status->class}}"> {{$election->status->name}}</span></td>
                                                            <td>{{ $election['start_date'] }}</td>
                                                            <td>{{ $election['end_date'] }}</td>
                                                            <td>{{ $election->types->name }}</td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-xs btn-default dropdown-toggle" type="button" id="button" data-toggle="dropdown" aria-expanded="false"> Actions<i class="fa fa-angle-down"></i></button>
                                                                    <ul class="dropdown-menu pull-left" role="menu">
                                                                        <li><a href="{{ URL::route('Election.ViewOne',$election['slug']) }}"><i class="icon-note"></i> Manage Election </a></li>
                                                                        <li><a href="#"><i class="icon-trash"></i> Delete </a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @php($count++)
                                                    @php($index++)
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra_script')
    <script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script>
        var INSERT = "{{ URL::route('Election.New') }}";
        var URL_CHECK = "{{ URL::route('ElectionAjax') }}";
        var TOKEN = "{{csrf_token()}}";
    </script>
    <script src="{{ asset('js/pages/election.js') }}"></script>
@endsection
@section('after_script')
    <script src="{{ asset('assets/pages/scripts/table-datatables-managed.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
@endsection
@section('modals')
    @include('admin.election.modals._new_election')
@endsection