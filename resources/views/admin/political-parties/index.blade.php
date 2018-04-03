@extends('partials.app')
@section('extra_style')
    <link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
@endsection
@section('content')
<div class="breadcrumbs">
        <h1>Political Parties</h1>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">Dashboard</a></li>
            <li class="active">Political Parties</li>
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
                            <li><a href="{{URL::route('ward.index')}}"><i class="icon-directions"></i> Polling Stations</a></li>
                            <li class="active"><a href="{{URL::route('PP.View')}}"><i class="icon-users"></i> Political Parties </a></li>
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
                                    <span class="caption-subject bold uppercase">Political Parties</span>
                                    <span class="caption-helper">Showing the list if political parties...</span>
                                </div>
                                <div class="actions">
                                    <a href="javascript:;" data-toggle="modal" data-target="#new-election" class="btn btn-circle btn-default btn-sm"><i class="fa fa-plus"></i> Add New Party</a>
                                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                @if(count($politicalParties) < 1)
                                    <div class="danger-well">
                                        <em>No political party found</em>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <table class="table table-striped table-hover" id="sample_2">
                                                <thead>
                                                    <tr>
                                                        <th>S/N</th>
                                                        <td>LOGO</td>
                                                        <td>CODE</td>
                                                        <th>NAME</th>
                                                        <th>DESCRIPTION</th>
                                                        <th>ACTIONS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php($index=0)
                                                    @foreach($politicalParties as $party)
                                                        <tr>
                                                            <td></td>
                                                            <td><img src=<?php echo asset("uploads/party-logo/$party->code.jpg"); ?> width="50px" height="50px" alt=""></td>
                                                            <td><a href="{{URL::route('PP.Edit',$party['slug'])}}">{{$party['code']}}</a></td>
                                                            <td>{{$party['name']}}</td>
                                                            <td>{{$party['description']}}</td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-xs btn-default dropdown-toggle" type="button" id="button" data-toggle="dropdown" aria-expanded="false"> Actions<i class="fa fa-angle-down"></i></button>
                                                                    <ul class="dropdown-menu pull-left" role="menu">
                                                                        <li><a href="{{URL::route('Election.ViewOne')}}"><i class="icon-note"></i> Edit </a></li>
                                                                        <li><a href="{{URL::route('Election.ViewOne')}}"><i class="icon-trash"></i> Delete </a></li>
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
            });
           

            //submit new user form
            $('#submit').on("click",function() {
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('PP.New')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'code' : $('input[name=code]').val(),
                        'name' : $('input[name=name]').val(),
                        'description' : $('textarea[name=description]').val(),
                        'req' : "newPP"
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Created Successfully", rst, "success");
                        location.reload();
                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
            });   


            $("#uploadLogo").bind("change", function () {
                $("#errorMessage_logo").html("");
                //Get reference of FileUpload.
                var fileUpload = $("#uploadLogo")[0];

                //Check whether the file is valid Image.
                var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
                if (regex.test(fileUpload.value.toLowerCase())) {
                    //Check whether HTML5 is supported.
                    if (typeof (fileUpload.files) != "undefined") {
                        var reader = new FileReader();
                        reader.readAsDataURL(fileUpload.files[0]);
                        reader.onload = function (e) {
                            var image = new Image();
                            image.src = e.target.result;
                            image.onload = function () {
                                var height = this.height;
                                var width = this.width;
                                if (width < 1024 && height < 683) {
                                    $("#image_preview_logo").css("background-image", "url("+e.target.result+")");
                                    return true;
                                } else {
                                    $("#errorMessage_logo").html("<em>Invalid image dimension! File must be 1024x683 respectively. Try Again!</em>");
                                    return false;
                                } 
                            };
                        }
                    } else {
                        $("#errorMessage_logo").html("<em>Sorry this browser does not support HTML5</em>");
                        return false;
                    }
                } else {
                    $("#errorMessage_logo").html("<em>Please select a valid image file.</em>");
                    return false;
                }
            });
        });    
    </script>
@endsection
@section('after_script')
    <script src="{{ asset('assets/pages/scripts/table-datatables-managed.min.js') }}" type="text/javascript"></script>
@endsection