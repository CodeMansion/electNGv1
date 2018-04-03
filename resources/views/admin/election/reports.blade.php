@extends('partials.app')
@section('extra_style')
    <link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
@endsection
@section('content')
<div class="breadcrumbs">
        <h1>Election Disputes</h1>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">Dashboard</a></li>
            <li class="active">Election Disputes</li>
        </ol>
    </div>
    <!-- BEGIN SIDEBAR CONTENT LAYOUT -->
    <div class="page-content-container">
        <div class="page-content-row">
            <!-- BEGIN PAGE SIDEBAR -->
            <div class="page-sidebar">
                <nav class="navbar" role="navigation">
                    <ul class="nav navbar-nav margin-bottom-35">
                        <li><a href="#"><i class="icon-home"></i> Home </a></li>
                        <li class="active"><a href="{{ URL::route('view.reports', $election['slug']) }}"><i class="icon-note "></i> View Disputes </a></li>
                        <li><a href="{{URL::route('Users.View')}}"><i class="icon-flag"></i> Win Metrics </a></li>
                        <li><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Broadsheet </a></li>
                        <li><a href="{{ URL::route('view.activity',$election['slug']) }}"><i class="icon-bell"></i> Activity Logs </a></li>
                        <li><a href="{{ URL::route('PasscodeView',$election['slug']) }}"><i class="icon-user"></i> Passcodes</a></li>
                        <li><a href="{{URL::route('ward.index')}}"><i class="icon-directions"></i> Party Agents</a></li>
                        <li><a href="{{ URL::route('SubmittedResult',$election['slug']) }}"><i class="icon-bell"></i> Result Report</a></li>
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
                                    <span class="caption-subject bold uppercase">Election Reports</span>
                                    <span class="caption-helper">Showing list of latest submitted reports ...</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                @if(count($reports) < 1)
                                    <div class="alert alert-danger">
                                        <em>No reports found</em>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <table class="table table-striped table-hover" id="sample_2">
                                                <thead>
                                                    <tr style="background-color: #2C3E50;color:white;">
                                                        <th>S/N</th>
                                                        <th>STATE</th>
                                                        <th>TTILE</th>
                                                        <th>REPORT</th>
                                                        <th>STATUS</th>
                                                        <th>TIME</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php($count=1)
                                                    @foreach($reports as $report)
                                                        <tr>
                                                            <td>{{$count}}</td>
                                                            <td>{{state($report->state_id)}}</td>
                                                            <td>{{$report->title}}</td>
                                                            <td>{{$report->comment}}</td>
                                                            <td>
                                                                @if($report->status == 1)
                                                                    <span class="badge badge-success">Unused</span>
                                                                @elseif($report->status == 2)
                                                                    <span class="badge badge-danger">Used</span>
                                                                @endif
                                                            </td>
                                                            <td>{{$report->created_at->diffForHumans()}}</td>
                                                            <td>
                                                                <button class="btn btn-sm btn-secondary create-hover" data-href="#viewReport" type="button"><i class="fa fa-eye"></i> View Details</button>
                                                            </td>
                                                        </tr>
                                                        @php($count++)
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
@endsection
@section('after_script')
    <script src="{{ asset('assets/pages/scripts/table-datatables-managed.min.js') }}" type="text/javascript"></script>
@endsection