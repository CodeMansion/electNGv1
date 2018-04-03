@extends('partials.app')
@section('extra_style')
    <style>
        .progress {
            display:none; 
            position:relative; 
            width:400px; 
            border: 1px solid #ddd; 
            padding: 1px; 
            border-radius: 3px; 
        }
        .bar{ 
            background-color: #B4F5B4; 
            width:0%; 
            height:20px; 
            border-radius: 3px; 
        }
        .percent { 
            position:absolute; 
            display:inline-block; 
            top:3px; 
            left:48%; 
        }
    </style>
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
                        @if(\Auth::user()->isAn('admin'))
                            <li><a href="{{ URL::route('Dashboard') }}"><i class="icon-home"></i> Home </a></li>
                            <li><a href="#"><i class="icon-note "></i> Reports </a></li>
                            <li><a href="{{URL::route('Users.View')}}"><i class="icon-user"></i> Manage Users </a></li>
                            <li><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Elections </a></li>
                            <li><a href="{{URL::route('polling.index')}}"><i class="icon-directions"></i> Polling Stations</a></li>
                            <li><a href="{{URL::route('PP.View')}}"><i class="icon-users"></i> Political Parties </a></li>
                            <li class="active"><a href="{{URL::route('preference.uploadView')}}"><i class="icon-cloud-upload"></i> Bulk Upload </a></li>
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
                            <li class="active"><a href="index.html"><i class="icon-home"></i> Home </a></li>
                            <li><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Elections </a></li>
                            <li><a href="#"><i class="icon-directions"></i> My Profile</a></li>
                            <li><a href="#"><i class="icon-directions"></i> Change Password</a></li>
                        @endif
                        @if(\Auth::user()->isAn('contestant'))
                        <li class="active"><a href="index.html"><i class="icon-home"></i> Home </a></li>
                            <li><a href="#"><i class="icon-note "></i> Reports </a></li>
                            <li><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Elections </a></li>
                            <li><a href="{{URL::route('pollling.index')}}"><i class="icon-directions"></i> Polling Stations</a></li>
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
                                    <span class="caption-subject bold uppercase"> Election Data Upload</span>
                                    <span class="caption-helper"></span>
                                </div>
                                <div class="actions">
                                    <a href="{{ URL::route('Dashboard') }}" class="btn btn-circle btn-default btn-sm"><i class="fa fa-arrow-left"></i> Return Back </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 col-xl-4">
                                        <h4>Upload a CSV file</h4><hr/>
                                        <form action="{{URL::route('preference.uploadStore')}}" method="POST" enctype="multipart/form-data">{{csrf_field()}}
                                            <div id="ErrorMsg"></div>
                                            <div class="form-group">
                                                <label>Query Type <span class="required">*</span></label>
                                                <select class="form-control" id="query_type" name="query_type" required>
                                                    <option value="">--select option--</option>
                                                    <option value="override">Override</option>
                                                    <option value="update">Update</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Upload Type <span class="required">*</span></label>
                                                <select class="form-control" id="upload_type" name="upload_type" required>
                                                    <option value="">--select table to upload--</option>
                                                    <option value="state">State</option>
                                                    <option value="constituency">Constituency</option>
                                                    <option value="ward">Ward</option>
                                                    <option value="lga">Local Govt. Areas</option>
                                                    <option value="polling-centres">Polling Centres</option>
                                                </select>
                                                <span style="font-size:13px;"><em>The <b>table</b> field is the type of file you want to upload.</em></span>
                                            </div>
                                            <div class="form-group" id="upload">
                                                <label>File  <span class="required">*</span></label>
                                                <input class='form-control' id="file" name="file" type="file" required>
                                                <span style="font-size:13px;"><em>This must be a CSV/Excel file.</em></span>
                                            </div><hr/>
                                            <div class="form-group">
                                                <button type="button" id="submit" class="btn btn-sm btn-primary create-hover">Upload File</button>
                                            </div>
                                        </form><br/>
                                        <div class="progress" id="progress_div">
                                            <div class='bar' id='bar'></div>
                                            <div class='percent' id='percent'>0%</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xl-4"></div>
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
    <script>
        //uploading the file 
        $("#submit").on("click", function() {
            var file_data = $('#file')[0].files[0];
            var query_type = $('#query_type').val();
            var upload_type = $('#upload_type').val();

            if(query_type.length < 1){
                $("#ErrorMsg").html("<div class='alert alert-danger'>Please select query type</div>");
            } else if(upload_type.length < 1){
                $("#ErrorMsg").html("<div class='alert alert-danger'>Please select upload type</div>");
            } else if(file_data == null) {
                $("#ErrorMsg").html("<div class='alert alert-danger'>Please choose file</div>");
            } else {
                var formData = new FormData();
                formData.append('file',file_data);
                formData.append('query_type',query_type);
                formData.append('upload_type',upload_type);
                formData.append('_token',"{{csrf_token()}}");
                
                $("#ErrorMsg").html("");
                $(this).attr('disabled',true);
                $(this).html("<i class='fa fa-spinner fa-spin'></i> Uploading... Please wait");
                
                $.ajax({
                    url: "{{ URL::route('preference.uploadStore') }}",
                    method: "POST",
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(rst){
                        if(rst.type == "true") {
                            $("#submit").attr('disabled',false);
                            $("#submit").html("<i class=''></i> Submit");
                            $("#ErrorMsg").html("<div class='alert alert-success'>" + rst.msg + "</div>");
                        } else if(rst.type == "false") {
                            $("#submit").attr('disabled',false);
                            $("#submit").html("<i class=''></i> Try again");
                            $("#ErrorMsg").html("<div class='alert alert-danger'>" + rst.msg + "</div>");
                        }
                    },
                    error: function(jqXHR, textStatus, errorMessage){
                        $("#submit").attr('disabled',false);
                        $("#submit").html("<i class=''></i> Try again");
                        $("#ErrorMsg").html("<div class='alert alert-danger'>" + errorMessage + "</div>");
                    }
                });   
            }
        });  
    </script>
@endsection