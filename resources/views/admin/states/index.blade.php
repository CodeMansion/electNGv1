@extends('partials.app')
@section('extra_style')
    <link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
@endsection
@section('content')
    <div class="breadcrumbs">
        <h1>States</h1>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">Dashboard</a></li>
            <li class="active">States</li>
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
                            <li><a href="{{ URL::route('Dashboard') }}"><i class="icon-home"></i> Home </a></li>
                            <li><a href="#"><i class="icon-note "></i> Reports </a></li>
                            <li><a href="{{URL::route('Users.View')}}"><i class="icon-user"></i> Manage Users </a></li>
                            <li><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Elections </a></li>
                            <li><a href="{{URL::route('ward.index')}}"><i class="icon-directions"></i> Polling Stations</a></li>
                            <li><a href="{{URL::route('PP.View')}}"><i class="icon-users"></i> Political Parties </a></li>
                            <li><a href="{{URL::route('preference.uploadView')}}"><i class="icon-cloud-upload"></i> Bulk Upload </a></li>
                            <li><a href="{{URL::route('preference.index')}}"><i class="icon-bell"></i> System Settings </a></li>
                        @endif
                        @if(\Auth::user()->isAn('moderator'))
                            <li class="active"><a href="index.html"><i class="icon-home"></i> Home </a></li>
                            <li><a href="#"><i class="icon-note "></i> Reports </a></li>
                            <li><a href="{{URL::route('Users.View')}}"><i class="icon-user"></i> Manage Users </a></li>
                            <li><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Elections </a></li>
                            <li><a href="{{URL::route('ward.index')}}"><i class="icon-directions"></i> Polling Stations</a></li>
                            <li><a href="{{URL::route('PP.View')}}"><i class="icon-users"></i> Political Parties </a></li>
                            <li><a href="{{URL::route('preference.uploadView')}}"><i class="icon-cloud-upload"></i> Bulk Upload </a></li>
                        @endif
                        @if(\Auth::user()->isAn('agent'))
                            <li class="active"><a href="index.html"><i class="icon-home"></i> Home </a></li>
                            <li><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Elections </a></li>
                            <li><a href="#"><i class="icon-directions"></i> My Profile</a></li>
                            <li><a href="#"><i class="icon-directions"></i> Change Password</a></li>
                        @endif
                        @if(\Auth::user()->isAn('contestant'))
                        <li class="active"><a href="index.html"><i class="icon-home"></i> Home </a></li>
                            <li><a href="#"><i class="icon-note "></i> Reports </a></li>
                            <li><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Elections </a></li>
                            <li><a href="{{URL::route('ward.index')}}"><i class="icon-directions"></i> Polling Stations</a></li>
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
                                    <span class="caption-subject bold uppercase">States</span>
                                    <span class="caption-helper">Showing the list states...</span>
                                </div>
                                <div class="actions">
                                    <a href="javascript:;" data-toggle="modal" data-target="#new-election" class="btn btn-circle btn-default btn-sm"><i class="fa fa-plus"></i> Add </a>
                                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                @if(count($states) < 1)
                                    <div class="danger-well">
                                        <em>There are no states on this system. </em>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <table class="table table-striped table-hover" id="sample_3">
                                                <thead>
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>STATE</th>
                                                        <th>LGA Count</th>
                                                        <th>ACTIONS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php($index=0)
                                                    @foreach($states as $state)
                                                        <tr>
                                                            <td></td>
                                                            <td>{{$state['name']}}</td>
                                                            <td>{{count($state->Lgas)}}</td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-xs btn-default dropdown-toggle" type="button" id="button" data-toggle="dropdown" aria-expanded="false"> Actions<i class="fa fa-angle-down"></i></button>
                                                                    <ul class="dropdown-menu pull-left" role="menu">
                                                                        <li><a href="{{URL::route('Election.ViewOne')}}"><i class="icon-note"></i> View LGAs </a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('table.table-striped tbody tr').each(function(index) {
                $(".state_"+index).on('mouseover',function() {
                    $('#user-view'+index).show();
                });
                $(".state_"+index).on('mouseout',function() {
                    $('#user-view'+index).hide();
                });

                $("#activate_"+index).on("click", function() {
                    var state_id = $("#state_id_"+index).val();
                    $.LoadingOverlay("show");
                    $.ajax({
                        url: "{{URL::route('State.Activate')}}",
                        method: "POST",
                        data:{
                            '_token': "{{csrf_token()}}",
                            'state_id' : state_id,
                            'req' : "activateState"
                        },
                        success: function(rst){
                            $.LoadingOverlay("hide");
                            swal("User Created Successfully", "Mail sent successfully in minutes.", "success");
                            location.reload();
                        },
                        error: function(rst){
                            $.LoadingOverlay("hide");
                            swal("Oops! Error","An Error Occured!", "error");
                        }
                    });
                });
            });
           

            //submit new user form
            $('#submit').on("click",function() {
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('Users.New')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'email' : $('input[name=email]').val(),
                        'username' : $('input[name=username]').val(),
                        'user_type_id' : $('select[name=user_type_id]').val(),
                        'role_id' : $('select[name=role_id]').val(),
                        'first_name' : $('input[name=first_name]').val(),
                        'last_name' : $('input[name=last_name]').val(),
                        'phone' : $('input[name=phone]').val(),
                        'res_address': $('textarea[name=res_address]').val(),
                        'req' : "newUser"
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("User Created Successfully", "Mail sent successfully in minutes.", "success");
                        location.reload();
                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
            });   
        });    
    </script>
@endsection
@section('after_script')
    <script src="{{ asset('assets/pages/scripts/table-datatables-managed.min.js') }}" type="text/javascript"></script>
@endsection