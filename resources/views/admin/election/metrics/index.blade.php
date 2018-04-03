@extends('partials.app')
@section('extra_style')
    <link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <style>
        .hover-btn:hover {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
<div class="breadcrumbs">
        <h1>Win Metrics Report</h1>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="{{ URL::route('Election.ViewOne',$election['slug']) }}">Dashboard</a></li>
            <li class="active">Win Metrics Reports</li>
        </ol>
    </div>
    <!-- BEGIN SIDEBAR CONTENT LAYOUT -->
    <div class="page-content-container">
        <div class="page-content-row">
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
                                    <span class="caption-subject bold uppercase">Star Party Win Metric Analysis</span>
                                    <span class="caption-helper">Showing on-going election submitted result report in each polling stations</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                @if(count($votes) < 1)
                                    <div class="alert alert-danger">
                                        <em>No submitted result found yet</em>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="tabbable-custom nav-justified">
                                                <ul class="nav nav-tabs nav-justified">
                                                    <li class="active">
                                                        <a href="#state" data-toggle="tab"> State Level
                                                            <span class="icon-bar-chart pull-right hover-btn" id="toggle-state-chart"></span>
                                                            <span class="icon-list pull-right hover-btn" id="toggle-state-table"></span>
                                                        </a> 
                                                    </li>
                                                    <li><a href="#lga" data-toggle="tab"> 
                                                            Local Govt Level 
                                                            <span class="icon-bar-chart pull-right hover-btn" id="toggle-lga-chart"></span>
                                                            <span class="icon-list pull-right hover-btn" id="toggle-lga-table"></span>
                                                        </a>
                                                    </li>
                                                    <li><a href="#ward" data-toggle="tab"> 
                                                            Ward Level 
                                                            <span class="icon-bar-chart pull-right hover-btn" id="toggle-ward-chart"></span>
                                                            <span class="icon-list pull-right hover-btn" id="toggle-ward-table"></span>
                                                        </a>
                                                    </li>
                                                    <li><a href="#polling_station" data-toggle="tab"> 
                                                            Polling Station Level 
                                                            <span class="icon-bar-chart pull-right hover-btn" id="toggle-station-chart"></span>
                                                            <span class="icon-list pull-right hover-btn" id="toggle-station-table"></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    @include('admin.election.metrics.partials._state_level')
                                                    @include('admin.election.metrics.partials._lga_level')
                                                    @include('admin.election.metrics.partials._ward_level')
                                                    @include('admin.election.metrics.partials._polling_station')
                                                </div>
                                            </div>
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
    <script src="{{ asset('js/pages/result.js') }}" type="text/javascript"></script>
@endsection
@section('after_script')
    <script src="{{ asset('assets/pages/scripts/table-datatables-managed.min.js') }}" type="text/javascript"></script>
@endsection