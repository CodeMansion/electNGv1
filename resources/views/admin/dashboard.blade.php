@extends('partials.app')

@section('content')
<main id="main-container">
<!-- Page Content -->
<div class="content">
    <!-- permission set for polling station officials -->
    @can('submit_poll_result')
        <div class="row ">
            <div class="col-12" style="margin-bottom:10px;">
                @include('partials.notifications')
            </div>
            <div class="col-12 col-xl-12">
                <div class="block block-content title-hold">
                    <img class="img-avatar pull-right" src="{{ asset('images/logo.png') }}" alt="">
                    <h3 style="margin-bottom:5px;"><i class="si si-user"></i> Welcome to back {{strtoupper(\Auth::user()->profile->first_name.' '.\Auth::user()->profile->last_name)}}!</h3>
                    <p style="font-size:16px;">We've put together some quick links to get you started right away.. </p>
                    <p>
                        | <a href="#"><i class="si si-magnifier-add"></i> Update Profile</a> |
                        <a href="#"><i class="si si-book-open"></i> Reports</a> | 
                        <a href="#"><i class="si si-users"></i> Reset Password</a> | 
                        <a href="#"><i class="si si-settings"></i> Preferences</a> | 
                    </p><hr/>
                    @if(isset($election))
                        <div class="info-well">
                            <em>{{$election['name']}} is currently active. Check your ONE TIME PASSCODE below for authentication.</em>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-2"></div>
            <div class="col-8 col-xl-8">
                <div class="block block-content title-hold">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-9 col-xl-9">
                                <input type="text" class="form-control" placeholder="ENTER PASSCODE HERE.." name="passcode" required style="height:50px;font-size:18px;">
                            </div>
                            <div class="col-md-3 col-xl-3">
                                <button class="btn btn-lg btn-outline-success create-hover" id="check-passcode"><i class="si si-anchor"></i> VALIDATE</button>
                                <button class="btn-sm btn-outline-secondary create-hover" id="refresh" style="display:none;"><i class="fa fa-refresh"data-toggle="tooltip" title="Clear text field"></i></button>
                            </div>
                        </div>
                    </div>
                    <div id="is-validating" style="display:none;">
                        <center><img src="{{ asset('images/loading.gif') }}" alt=""></center>
                    </div>
                    <div id="polling-details">
                        
                    </div>
                    <div id="has-error" style="display:none;">
                        <div style='margin-bottom:30px;' class='danger-well'>Invalid passcode or server error. Contact Administrator.</div>
                    </div>
                        </div>
                        <div class="col-2"></div>
                    </div>
                </div>
            <div class="col-2"></div>
        </div>
    @endcan
    <!-- end of polling unit officials permission -->

    <!-- permissions set for admins and super admin -->
    @can('view_dashboard')
        <div class="row ">
            <div class="col-12" style="margin-bottom:10px;">
                @include('partials.notifications')
            </div>
            <div class="col-12 col-xl-12">
                <div class="block block-content title-hold">
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
                @include('partials.notifications')
            </div>
        </div>
    
            <div class="row gutters-tiny invisible" data-toggle="appear">
                <!-- Row #1 -->
                <div class="col-6 col-xl-3">
                    <a class="block block-link-shadow text-right" href="javascript:void(0)">
                        <div class="block-content block-content-full clearfix">
                            <div class="float-left mt-10 d-none d-sm-block">
                                <i class="si si-bag fa-3x text-body-bg-dark"></i>
                            </div>
                            <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="1500">0</div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Sales</div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-xl-3">
                    <a class="block block-link-shadow text-right" href="javascript:void(0)">
                        <div class="block-content block-content-full clearfix">
                            <div class="float-left mt-10 d-none d-sm-block">
                                <i class="si si-wallet fa-3x text-body-bg-dark"></i>
                            </div>
                            <div class="font-size-h3 font-w600">$<span data-toggle="countTo" data-speed="1000" data-to="780">0</span></div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Earnings</div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-xl-3">
                    <a class="block block-link-shadow text-right" href="javascript:void(0)">
                        <div class="block-content block-content-full clearfix">
                            <div class="float-left mt-10 d-none d-sm-block">
                                <i class="si si-envelope-open fa-3x text-body-bg-dark"></i>
                            </div>
                            <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="15">0</div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Messages</div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-xl-3">
                    <a class="block block-link-shadow text-right" href="javascript:void(0)">
                        <div class="block-content block-content-full clearfix">
                            <div class="float-left mt-10 d-none d-sm-block">
                                <i class="si si-users fa-3x text-body-bg-dark"></i>
                            </div>
                            <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="4252">0</div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Online</div>
                        </div>
                    </a>
                </div>
                <!-- END Row #1 -->
            </div>
        @endcan
    </div><!-- END Row #5 -->
</div><!-- END Page Content -->
</main><!-- END Main Container -->
@endsection
@section('extra_script')
    <script src="{{ asset('js/plugins/slick/slick.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            //submiting polling result
            $("#is-validating").hide();
            $("#polling-details").hide();
            $("#has-error").hide();
            $("#refresh").hide();

            //implementing refresh
            $("#refresh").on('click', function(){
                $("input[name=passcode]").attr('disabled',false);
                $("input[name=passcode]").val('');
                $("#polling-details").hide();
                $("#has-error").hide();
            });

            $("#check-passcode").on("click", function() {
                var passcode = $("input[name=passcode]").val();
                if(passcode.length > 6 || passcode.length < 1 || passcode.length < 6){
                    alert('Invalid passcode!');
                } else {
                    $("#refresh").show();
                    $("input[name=passcode]").attr('disabled',true);
                    $("#is-validating").show();
                    $.ajax({
                        url: "{{URL::route('CheckPasscode')}}",
                        method: "POST",
                        data:{
                            '_token': "{{csrf_token()}}",
                            'passcode' : passcode,
                            'req' : "checkCode"
                        },
                        success: function(rst){
                            $("#is-validating").hide();
                            $("#has-error").hide();
                            $("#polling-details").html(rst);
                            $("#polling-details").show();
                        },
                        error: function(rst){
                            $("#is-validating").hide();
                            $("#polling-details").hide();
                            $("#has-error").show();
                        }
                    });
                }
            });
        });
    </script>
@endsection