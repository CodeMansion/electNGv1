@extends('partials.app')
@section('extra_style')
    <link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
@endsection
@section('content')
<div class="breadcrumbs">
        <h1>Polling Stations</h1>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">Dashboard</a></li>
            <li class="active">Polling Stations</li>
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
                        @if(\Auth::user()->isAn('admin'))
                            <li><a href="{{ URL::route('Dashboard') }}"><i class="icon-home"></i> Home </a></li>
                            <li><a href="#"><i class="icon-note "></i> Reports </a></li>
                            <li><a href="{{URL::route('Users.View')}}"><i class="icon-user"></i> Manage Users </a></li>
                            <li><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Elections </a></li>
                            <li class="active"><a href="{{URL::route('polling.index')}}"><i class="icon-directions"></i> Polling Stations</a></li>
                            <li><a href="{{URL::route('PP.View')}}"><i class="icon-users"></i> Political Parties </a></li>
                            <li><a href="{{URL::route('preference.uploadView')}}"><i class="icon-cloud-upload"></i> Bulk Upload </a></li>
                            <li><a href="{{URL::route('preference.index')}}"><i class="icon-bell"></i> System Settings </a></li>
                        @endif
                        @if(\Auth::user()->isAn('moderator'))
                            <li><a href="{{ URL::route('Dashboard') }}"><i class="icon-home"></i> Home </a></li>
                            <li><a href="#"><i class="icon-note "></i> Reports </a></li>
                            <li><a href="{{URL::route('Users.View')}}"><i class="icon-user"></i> Manage Users </a></li>
                            <li><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Elections </a></li>
                            <li class="active"><a href="{{URL::route('polling.index')}}"><i class="icon-directions"></i> Polling Stations</a></li>
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
                            <li><a href="{{ URL::route('Dashboard') }}"><i class="icon-home"></i> Home </a></li>
                            <li><a href="#"><i class="icon-note "></i> Reports </a></li>
                            <li><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Elections </a></li>
                            <li class="active"><a href="{{URL::route('polling.index')}}"><i class="icon-directions"></i> Polling Stations</a></li>
                            <li><a href="{{URL::route('PP.View')}}"><i class="icon-users"></i> Political Parties </a></li>
                        @endif
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
                                    <span class="caption-subject bold uppercase">Polling Stations</span>
                                    <span class="caption-helper">Showing the list if political parties...</span>
                                </div>
                                <div class="actions"></div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <select class="form-control" id="state_id">
                                                    <option value="">--select state--</option>
                                                    @foreach($states as $state)
                                                        <option value="{{ $state['id'] }}">{{ $state['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <select class="form-control" id="lga_id">
                                                    <option value="">--select local govt--</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <select class="form-control" id="ward_id">
                                                    <option value="">--select wards--</option>
                                                </select>
                                            </div>
                                        </div><hr/>
                                        <div id="loader"><center><img src="{{asset('images/loading.gif')}}"> Loading ...</center></div>
                                        <div id="show-result">

                                        </div>
                                    </div>
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
    <script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#loader").hide();

            $('#state_id').on("change",function(){
              var state_id = $(this).val();      
                  $.ajax({
                    type: 'POST',
                    url: "{{ URL::route('getLga') }}",
                    data: {
                        'state_id': state_id,
                        '_token': "{{ csrf_token() }}"
                    },
                    success:function(data){
                        $('#lga_id').html(data);
                    }
                });
            });

            $('#lga_id').on("change",function(){
                var lga_id = $(this).val();      
                  $.ajax({
                    type: 'POST',
                    url: "{{ URL::route('getWard') }}",
                    data: {
                        'lga_id': lga_id,
                        '_token': "{{ csrf_token() }}"
                    },
                    success:function(data){
                        $('#ward_id').html(data);
                    }
                });
            });

            $('#ward_id').on("change",function(){
                $("#loader").fadeIn();
                var ward_id = $(this).val();      
                $.ajax({
                    type: 'POST',
                    url: "{{ URL::route('getPollingStation') }}",
                    data: {
                        'ward_id': ward_id,
                        '_token': "{{ csrf_token() }}"
                    },
                    success:function(data){
                        $("#loader").fadeOut();
                        $('#show-result').html(data);
                    }
                });
            });
            
        });    
    </script>
@endsection
@section('after_script')
    <script src="{{ asset('assets/pages/scripts/table-datatables-managed.min.js') }}" type="text/javascript"></script>
@endsection