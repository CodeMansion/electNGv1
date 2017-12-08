@extends('partials.app')
@section('extra_style')
    <!-- customize styling for student resource-->
    <link href="{{asset('js/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('js/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/select2-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('js/plugins/slick/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/slick/slick-theme.min.css') }}">
    {!! Charts::assets() !!}
@endsection
@section('content')
    <main id="main-container">
        <!-- Page Content -->
        <div class="content">
            <div class="row" style="">
                <div class="col-12 col-xl-12">
                    <div class="block block-content title-hold">
                        <div class="col-md-12">
                            <h3 style="margin-bottom:5px;">
                                <i class="si si-feed"></i> {{$election['name']}} <span class="badge badge-{{$election->status->class}}"><i class=""></i> {{$election->status->name}}</span>
                                <p class="p-10 bg-primary-lighter text-primary-dark pull-right">{{config('constants.ACTIVE_STATE_NAME')}} - State</p>
                            </h3><hr/>
                            <p>
                                <a href="{{URL::route('Dashboard')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a> |
                                <a href="{{URL::route('Election.View')}}"><i class="si si-arrow-left"></i> Elections</a> 
                            </p>
                            <p>
                                @if($election['election_status_id'] == 1)
                                    <form action="{{URL::route('Election.ChangeStatus')}}" method="POST">{{csrf_field()}}
                                        <input type="hidden" name="election_id" value="{{$election['slug']}}">
                                        <input type="hidden" name="type" value="completed">
                                        <button type="submit" class="btn btl-sm btn-outline-secondary create-hover"> <i class="si si-equalizer"></i> Complete Process</button>
                                    </form>
                                @elseif($election['election_status_id'] == 2)
                                    <form action="{{URL::route('Election.ChangeStatus')}}" method="POST">{{csrf_field()}}
                                        <input type="hidden" name="election_id" value="{{$election['slug']}}">
                                        <input type="hidden" name="type" value="begin">
                                        <button type="submit" class="btn btl-sm btn-success create-hover" onclick="return confirm('Are you sure you want to start this election?');"><i class="si si-control-forward"></i> Begin Election</button>
                                    </form>
                                @elseif($election['election_status_id'] == 3)
                                    <form action="{{URL::route('Election.ChangeStatus')}}" method="POST">{{csrf_field()}}
                                        <input type="hidden" name="election_id" value="{{$election['slug']}}">
                                        <input type="hidden" name="type" value="end">
                                        <button type="submit" class="btn btl-sm btn-danger create-hover" onclick="return confirm('Are you sure you want to start this election?');"><i class="si si-close"></i> Stop Election</button>                                    </form>
                                    </form>
                                @endif
                            </p>
                            @include('partials.notifications')
                        </div>
                    </div>
                </div>
            </div>
            @if($election['election_status_id'] == 2)
                <div class="row">
                    
                </div>
            @endif

            <div class="row">
                <!-- <div class="col-2">
                    @include('admin.election.partials._left_col')
                </div> -->
                <div class="col-12 col-xl-12">
                    <!-- Block Tabs With Options Default Style -->
                    <div class="block">
                        <ul class="nav nav-tabs nav-tabs-block align-items-center nav-tabs-alt" data-toggle="tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" href="#statistics">Infographics</a></li>
                            <li class="nav-item"><a class="nav-link" href="#results">Polling Results</a></li>
                            <li class="nav-item"><a class="nav-link" href="#centres">Election Centres</a></li>
                            <li class="nav-item"><a class="nav-link" href="#users">Approved Users</a></li>
                            @if($election['election_status_id'] == 3)
                                <li class="nav-item"><a class="nav-link" href="#poll-result">Submit Result</a></li>
                            @endif
                            
                            <li class="nav-item ml-auto">
                                <div class="block-options mr-15">
                                    <div class="dropdown ">
                                        <button type="button" class="btn-block-option create-hover dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-fw fa-bell mr-5"></i>Election Status</a>
                                            <a data-toggle="modal" data-target="#assignUsers" class="dropdown-item" href="javascript:void(0)">
                                                <i class="si si-action-redo mr-5"></i> Assign Officials to stations
                                            </a>
                                            <a data-toggle="modal" data-target="#userPasscode" class="dropdown-item" href="javascript:void(0)">
                                                <i class="si si-magic-wand mr-5"></i> Query User Passcode
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0)">
                                                <i class="si si-grid mr-5"></i> Export CSV
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{URL::route('Election.View')}}">
                                                <i class="fa fa-fw fa-sign-out mr-5"></i> Logout
                                            </a>
                                        </div>
                                    </div>

                                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                        <i class="si si-refresh"></i>
                                    </button>
                                    <!-- <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button> -->
                                </div>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <div class="tab-pane active" id="statistics" role="tabpanel">
                                @include('admin.election.partials._infographics')
                            </div>
                            <div class="tab-pane" id="results" role="tabpanel">
                                <h4 class="font-w400">Polling Results</h4>
                                @include('admin.election.partials.polling_results')
                            </div>
                            <div class="tab-pane" id="centres" role="tabpanel">
                                @include('admin.election.partials._polling_stations')
                            </div>
                            <div class="tab-pane" id="users" role="tabpanel">
                                <h4 class="font-w400">Approved Officials</h4>
                                @include('admin.election.partials._approved_passcode')
                            </div>
                            @if($election['election_status_id'] == 3)
                            <div class="tab-pane" id="poll-result" role="tabpanel">
                                <h4 class="font-w400">Submit Polling Result</h4>
                                @include('admin.election.partials._submit_poll')
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- END Block Tabs With Options Default Style -->
                </div>
            </div>
        </div>
    </main>
@endsection
@section('modals')
    @php($index=0)
    @foreach($pollingUnits as $unit)
        @include('admin.election.modals._assign_users_stations')
    @php($index++)
    @endforeach
@endsection
@section('extra_script')
    <script src="{{ asset('js/plugins/slick/slick.min.js') }}"></script>

    <!-- <script src="{{ asset('js/pages/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/table-datatables-managed.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js')}}"></script>

    <script src="{{ asset('js/pages/be_forms_plugins.js') }}"></script> -->
    <script type="text/javascript">
        $(document).ready(function() {
            //submiting polling result
            $("#is-validating").hide();
            $("#polling-details").hide();
            $("#has-error").hide();
            $("#refresh").hide();
            
            //assigning a user to a polling centre under a state
            $("#modal .modal").each(function(index){
                $("#assignUser"+index).on("click",function() {
                    $.LoadingOverlay("show");
                    $.ajax({
                        url: "{{URL::route('ElectionAjax')}}",
                        method: "POST",
                        data:{
                            '_token': "{{csrf_token()}}",
                            'ward_id' : $("#ward_id"+index).val(),
                            'lga_id' : $("#lga_id"+index).val(),
                            'polling_unit_id' : $("#polling_unit_id"+index).val(),
                            'user_id' : $("#user_id"+index).val(),
                            'election_id' : <?php echo $election['id']; ?>,
                            'req' : "assignUsers"
                        },
                        success: function(rst){
                            $.LoadingOverlay("hide");
                            swal("Assigned Successfully!", rst, "success");
                            location.reload();
                        },
                        error: function(rst){
                            $.LoadingOverlay("hide");
                            swal("Oops! Error","An Error Occured!", "error");
                        }
                    });
                }); 
            });
            
            
            $("#check-passcode").on("click", function() {
                $("#refresh").show();
                var passcode = $("input[name=passcode]").val();
                if(passcode.length > 6 ){
                    alert('Invalid passcode!');
                } else {
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

            $("select[name=lga_id]").on("change", function(){
                $.ajax({
                    url: "{{URL::route('ElectionAjax')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'lga_id' : $(this).val(),
                        'req' : "displayWard"
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        $("select[name=ward_id]").html(rst);
                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
            });

            $("select[name=ward_id]").on("change", function(){
                $.ajax({
                    url: "{{URL::route('ElectionAjax')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'lga_id' : $('select[name=lga_id]').val(),
                        'ward_id' : $(this).val(),
                        'req' : "displayCentre"
                    },
                    success: function(rst){
                        $("select[name=polling_unit_id]").html(rst);
                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
            });

            //implementing refresh
            $("#refresh").on('click', function(){
                $("input[name=passcode]").attr('disabled',false);
                $("input[name=passcode]").val('');
            });
        });    
    </script>
    <script>
        jQuery(function () {
            // Init page helpers (BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
            Codebase.helpers(['datepicker', 'slick', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']); 
        });
    </script>
@endsection
