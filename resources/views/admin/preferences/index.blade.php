@extends('partials.app')
@section('extra_style')

@endsection
@section('content')
<div class="breadcrumbs">
        <h1>System Settings</h1>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">Dashboard</a></li>
            <li class="active">System Settings</li>
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
                            <li><a href="{{URL::route('preference.uploadView')}}"><i class="icon-cloud-upload"></i> Bulk Upload </a></li>
                            <li class="active"><a href="{{URL::route('preference.index')}}"><i class="icon-bell"></i> System Settings </a></li>
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
                                    <span class="caption-subject bold uppercase">System Settings</span>
                                    <span class="caption-helper"></span>
                                </div>
                                <div class="actions">
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6 col-xs-12">
                                        <div id="errorMsg"></div>
                                        <form action="" class="form-horizontal" method="POST">
                                            <h4>Out-going Mail Settings</h4><hr/>
                                            <div class="form-group">
                                                <label class="col-md-5" align="right">Host</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" id="host" value="{{ $setting->host }}" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5" align="right">Port</label>
                                                <div class="col-md-7">
                                                    <input type="number" class="form-control" id="port" value="{{ $setting->port }}" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5" align="right">Username</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" id="username" value="{{ $setting->username }}" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5" align="right">Password</label>
                                                <div class="col-md-7">
                                                    <input type="password" class="form-control" id="password" value="{{ $setting->password }}" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5" align="right">Encryption</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" id="encryption" value="{{ $setting->encryption }}" />
                                                </div>
                                            </div>

                                            <h4>Preferences</h4><hr/>
                                            <div class="form-group">
                                                <label class="col-md-5" align="right">Enable Page Refresh</label>
                                                <div class="col-md-7">
                                                    <label class="custom-control custom-radio">
                                                        <input type="checkbox" id="enable_page_refresh" <?php echo ($setting->enable_page_refresh) ? "checked" : ""; ?> >
                                                    </label><br/>
                                                    <span style="font-size:12px"><em>If enabled election result broadsheet will auto reload at every 10 seconds to fetch for newly submit result</em></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-5" align="right">Enable Sound Notification</label>
                                                <div class="col-md-7">
                                                    <label class="custom-control custom-radio">
                                                        <input type="checkbox" id="sound_notification" <?php echo ($setting->enable_sound_notification) ? "checked" : ""; ?>  >
                                                    </label><br/>
                                                    <span style="font-size:12px"><em>If enabled the system will notify of new submitted result or report with a sound notification</em></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5" align="right">Enable Report Image Upload</label>
                                                <div class="col-md-7">
                                                    <label class="custom-control custom-radio">
                                                        <input type="checkbox" id="enable_report_upload" <?php echo ($setting->enable_report_image) ? "checked" : ""; ?>  >
                                                    </label><br/>
                                                    <span style="font-size:12px"><em>If enabled picture can be uploaded along side a report or disputes from polling stations</em></span>                            
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5" align="right">Enable Accreditation Integrity Check</label>
                                                <div class="col-md-7">
                                                    <label class="custom-control custom-radio">
                                                        <input type="checkbox" id="enable_integrity_check" <?php echo ($setting->enable_integrity_check) ? "checked" : ""; ?> >
                                                    </label><br/>
                                                    <span style="font-size:12px"><em>If enabled the mobile application will not submit result that is overall total is not equal to the number of accredited voters in a polling station</em></span>                             
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5" align="right">Enable Result Override</label>
                                                <div class="col-md-7">
                                                    <label class="custom-control custom-radio">
                                                        <input type="checkbox" id="enable_result_override" <?php echo ($setting->enable_result_override) ? "checked" : ""; ?> >
                                                    </label><br/>
                                                    <span style="font-size:12px"><em>If enabled result can be submitted more than once from a polling station in the case of mistakes at first submittion</em></span>                             
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5" align="right">Enable Result Submission at Ward Level</label>
                                                <div class="col-md-7">
                                                    <label class="custom-control custom-radio">
                                                        <input type="checkbox" id="enable_ward_result" <?php echo ($setting->enable_ward_result) ? "checked" : ""; ?> >
                                                    </label><br/>
                                                    <span style="font-size:12px"><em>If enabled note that result can inputed at ward level by an ADMIN with the authorized privilege</em></span>                      
                                                </div>
                                            </div><hr/>
                                            <div class="form-group">
                                                <button type="button" id="update_setting_btn" class="btn btn-sm btn-success">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-3"></div>
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
    $(document).ready(function() {
        $("#update_setting_btn").on("click", function() {
            var host = $('#host').val();
            var username = $("#username").val();
            var password = $("#password").val();
            var port = $("#port").val();
            var encryption = $("#encryption").val();

            if($("#enable_page_refresh").is(':checked')) {
                var page_refresh = 1;
            } else {
                var page_refresh = 0;
            }

            if($("#sound_notification").is(':checked')) {
                var sound_notification = 1;
            } else {
                var sound_notification = 0;
            }

            if($("#enable_report_upload").is(':checked')) {
                var report_upload = 1;
            } else {
                var report_upload = 0;
            }

            if($("#enable_integrity_check").is(':checked')) {
                var integrity_check = 1;
            } else {
                var integrity_check = 0;
            }

            if($("#enable_result_override").is(':checked')) {
                var result_override = 1;
            } else {
                var result_override = 0;
            }

            if($("#enable_ward_result").is(':checked')) {
                var ward_result = 1;
            } else {
                var ward_result = 0;
            }

            if(host.length < 1){
                App.scrollTop($("#errorMsg"));
                $("#errorMsg").html("<div class='alert alert-danger'>Provide host</div>");
            } else if(username.length < 1){
                App.scrollTop($("#errorMsg"));
                $("#errorMsg").html("<div class='alert alert-danger'>Provide username</div>");
            } else if(password.length < 1) {
                App.scrollTop($("#errorMsg"));
                $("#errorMsg").html("<div class='alert alert-danger'>Provide password</div>");
            } else if(port.length < 1) {
                App.scrollTop($("#errorMsg"));
                $("#errorMsg").html("<div class='alert alert-danger'>Provide port</div>");
            } else {
                
                $("#errorMsg").html("");
                $(this).attr('disabled',true);
                $(this).html("<i class='fa fa-spinner fa-spin'></i> Updating...");
                
                $.ajax({
                    url: "{{ URL::route('preferenceUpdate') }}",
                    method: "POST",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'host': host,
                        'port': port,
                        'username': username,
                        'password': password,
                        'encryption': encryption,
                        'page_refresh': page_refresh,
                        'integrity_check': integrity_check,
                        'sound_notification': sound_notification,
                        'report_upload': report_upload,
                        'ward_result': ward_result,
                        'result_override': result_override,
                        'req': "update_settings"
                    },
                    success: function(rst){
                        if(rst.type == "true") {
                            $("#update_setting_btn").attr('disabled',false);
                            $("#update_setting_btn").html("<i class=''></i> Update");
                            App.scrollTop($("#errorMsg"));
                            $("#errorMsg").html("<div class='alert alert-success'>" + rst.msg + "</div>");
                        } else if(rst.type == "false") {
                            $("#update_setting_btn").attr('disabled',false);
                            $("#update_setting_btn").html("<i class=''></i> Try Again");
                            App.scrollTop($("#errorMsg"));
                            $("#errorMsg").html("<div class='alert alert-danger'>" + rst.msg + "</div>");
                        }
                    },
                    error: function(jqXHR, textStatus, errorMessage){
                        $("#update_setting_btn").attr('disabled',false);
                        $("#update_setting_btn").html("<i class=''></i> Try again");
                        App.scrollTop($("#errorMsg"));
                        $("#errorMsg").html("<div class='alert alert-danger'>" + errorMessage + "</div>");
                    }
                });   
            }
        });  
    });
    </script>
@endsection