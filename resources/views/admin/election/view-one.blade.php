@extends('partials.app')
@section('extra_style')
    <!-- customize styling for student resource-->
    <link rel="stylesheet" href="{{ asset('js/plugins/slick/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/slick/slick-theme.min.css') }}">
    <style>
        .content .block-content label {
            margin-right: 10px;
            font-size: 15px;
        }
    </style>
    {!! Charts::assets() !!}
@endsection
@section('content')
    <?php $settings = \App\Preference::first(); ?>
    <main id="main-container">
        <!-- Page Content -->
        <div class="content">
            <div class="row" style="">
                <div class="col-12 col-xl-12">
                    @include('partials.notifications')
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">
                                <i class="si si-feed"></i> {{$election['name']}} 
                                <span class="badge badge-{{$election->status->class}}"><i class=""></i> {{$election->status->name}}</span>
                            </h3>
                            @can('super_admin')
                            <form action="{{URL::route('Election.ChangeStatus')}}" method="POST">{{csrf_field()}}
                                <input type="hidden" name="election_id" value="{{$election['slug']}}">
                                @if($election['election_status_id'] == 1)
                                    <input type="hidden" name="type" value="begin">
                                    <button class="btn btn-sm btn-default create-hover" id="begin" type="submit"><i class="si si-power"></i> Start Election</button> 
                                @elseif($election['election_status_id'] == 2)
                                    <input type="hidden" name="type" value="end">
                                    <button class="btn btn-sm btn-warning create-hover" id="end" type="submit"><i class="si si-lock"></i> End Election</button>
                                @elseif($election['election_status_id'] == 3)
                                    <button class="btn btn-sm btn-info create-hover" id="details" type="button"><i class="si si-bar-chart"></i> View Election Summary</button>
                                @endif
                            </form>
                            <button class="btn btn-sm btn-secondary create-hover" type="button">
                                <a href="{{URL::route('Election.View')}}">
                                <i class="fa fa-dashboard"></i> Dashboard</a>
                            </button>
                            <div class="block-options">
                                <div class="dropdown">
                                    <button type="button" class="btn-block-option dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">OTHER OPTIONS</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{URL::route('SubmittedResult',$election['slug'])}}">
                                            <i class="si si-book-open mr-5"></i>View Submitted Result
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="si si-printer mr-5"></i>Print Result
                                        </a>
                                        <a class="dropdown-item" href="{{URL::route('view.reports',$election['slug'])}}">
                                            <i class="si si-tag mr-5"></i>View Reports
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{URL::route('PasscodeView',$election['slug'])}}">
                                            <i class="si si-tag mr-5"></i>View Election Passcode
                                        </a>
                                        <a class="dropdown-item" href="{{URL::route('InfographicView',$election['slug'])}}">
                                            <i class="si si-tag mr-5"></i>View Infographics
                                        </a>
                                        <a data-toggle="modal" data-target="#assignCandidate" class="dropdown-item" href="javascript:void(0)">
                                            <i class="si si-user mr-5"></i>Election Candidate
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endcan
                        </div>
                        
                    </div>
                </div>
            </div>
            <div id="loader" style="display:none;margin-top:100px;">
                <center><img src="{{asset('images/loading.gif')}}"></center>
            </div>
            <div id="stats"></div>
        </div>
    </main>
@endsection
@section('extra_script')
    <script>
        var millisec =parseInt({{ $settings->page_refresh_interval }});
        //page refresh function for dashbboard
        function page_refresh_stats(){
            // $('#loader').show();
            // $("#stats").hide();
            $.ajax({
                url: "{{URL::route('Election.Stats')}}", 
                method: "POST",
                data: {
                    '_token': "{{csrf_token()}}",
                    'slug': "{{$election['slug']}}"
                },
                success: function(data) {
                    $("#loader").hide();
                    $('#stats').show();
                    $('#stats').html(data);
                    // location.reload();
                },
                complete: function() {}
            });
            setTimeout(page_refresh_stats, millisec);
        }

        $(document).ready(function() {
            //initializing page refresh function
            page_refresh_stats();

            //getting the election type
            var election_type = parseInt({{$election->election_type_id}});
            
            //initializing views

            //for local govt election
            $("#view-by-lga").hide();
            $("#view-by-ward-local").hide();
            $("#view-by-unit-local").hide();

            //for senatorial election
            $("#view-by-lga-senatorial").hide();
            $("#view-by-ward-senatorial").hide();
            $("#view-by-unit-senatorial").hide();

            //for governorship election
            $("#view-by-const-first-governor").hide();
            $("#view-by-const-second-governor").hide();
            $("#view-by-ward-governor").hide();
            $("#view-by-unit-governor").hide();
            $("#refresh").hide();

            //executing processes based on election type
            if(election_type == 1) {

            } 


            //queries for governorship election
            if(election_type == 2) {
                $("input[name=type][type=radio]").on("change", function() {
                    if($(this).val() == 'constituency'){
                        $("#view-by-const-second-governor").hide();
                        $("#view-by-ward-governor").hide();
                        $("#view-by-unit-governor").hide();
                        $("#view-by-const-first-governor").show();;
                    }

                    if($(this).val() == 'lga'){
                        $("#view-by-const-first-governor").hide();
                        $("#view-by-unit-senatorial").hide();
                        $("#view-by-unit-governor").hide();
                        $("#view-by-const-second-governor").show();
                    }

                    if($(this).val() == 'ward'){
                        $("#view-by-const-first-governor").hide();
                        $("#view-by-const-second-governor").hide();
                        $("#view-by-unit-governor").hide();
                        $("#view-by-ward-governor").show();
                    }

                    if($(this).val() == 'station'){
                        $("#view-by-const-first-governor").hide();
                        $("#view-by-const-second-governor").hide();
                        $("#view-by-ward-governor").hide();
                        $("#view-by-unit-governor").show();
                    }

                    if($(this).val() == 'general'){
                        $("#view-by-const-first-governor").hide();
                        $("#view-by-const-second-governor").hide();
                        $("#view-by-ward-governor").hide();
                        $("#view-by-unit-governor").hide();
                        location.reload();
                    }
                });

                //query result by constituency
                $("select[name=const_id_first_governor]").on("change", function() {
                    $('#stats').hide();
                    $("#loader").show();
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'constituency_id': $(this).val(),
                            'slug': "{{$election['slug']}}",
                            'req': "constituency-result"
                        },
                        success: function(data) {
                            $("#loader").hide();
                            $('#stats').show();
                            $('#stats').html(data);
                        }
                    });
                });

                //query result by lga
                $("select[name=lga_id_first_governor]").on("change", function() {
                    $('#stats').hide();
                    $("#loader").show();
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'lga_id': $(this).val(),
                            'constituency_id': $("select[name=const_id_second_governor]").val(),
                            'slug': "{{$election['slug']}}",
                            'req': "lga-result-gov"
                        },
                        success: function(data) {
                            $("#loader").hide();
                            $('#stats').show();
                            $('#stats').html(data);
                        }
                    });
                });

                 //query result by ward
                $("select[name=ward_id_first_governor]").on("change", function() {
                    $('#stats').hide();
                    $("#loader").show();
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'constituency_id': $("select[name=const_id_third_governor]").val(),
                            'lga_id': $("select[name=lga_id_second_governor]").val(),
                            'ward_id': $(this).val(),
                            'slug': "{{$election['slug']}}",
                            'req': "ward-result-governor"
                        },
                        success: function(data) {
                            $("#loader").hide();
                            $('#stats').show();
                            $('#stats').html(data);
                        }
                    });
                });

                //query result by polling stations
                $("select[name=unit_id_governor]").on("change", function() {
                    $('#stats').hide();
                    $("#loader").show();
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'unit_id': $(this).val(),
                            'constituency_id': $("select[name=const_id_fouth_governor]").val(),
                            'lga_id': $("select[name=lga_id_fouth_governor]").val(),
                            'ward_id': $("select[name=ward_id_second_governor]").val(),
                            'slug': "{{$election['slug']}}",
                            'req': "unit-result-governor"
                        },
                        success: function(data) {
                            $("#loader").hide();
                            $('#stats').show();
                            $('#stats').html(data);
                        }
                    });
                });

                $("select[name=const_id_third_governor]").on("change", function() {
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'constituency_id': $(this).val(),
                            'slug': "{{$election['slug']}}",
                            'req': "showLgas"
                        },
                        success: function(data) {
                            $('select[name=lga_id_second_governor]').html(data);
                        }
                    });
                });

                $("select[name=const_id_fouth_governor]").on("change", function() {
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'constituency_id': $(this).val(),
                            'slug': "{{$election['slug']}}",
                            'req': "showLgas"
                        },
                        success: function(data) {
                            $('select[name=lga_id_fouth_governor]').html(data);
                        }
                    });
                });

                $("select[name=const_id_second_governor]").on("change", function() {
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'constituency_id': $(this).val(),
                            'slug': "{{$election['slug']}}",
                            'req': "showLgas"
                        },
                        success: function(data) {
                            $('select[name=lga_id_first_governor]').html(data);
                        }
                    });
                });

                $("select[name=lga_id_second_governor]").on("change", function() {
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'lga_id': $(this).val(),
                            'slug': "{{$election['slug']}}",
                            'req': "showWards"
                        },
                        success: function(data) {
                            $('select[name=ward_id_first_governor').html(data);
                        }
                    });
                });

                $("select[name=lga_id_fouth_governor]").on("change", function() {
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'lga_id': $(this).val(),
                            'slug': "{{$election['slug']}}",
                            'req': "showWards"
                        },
                        success: function(data) {
                            $('select[name=ward_id_second_governor').html(data);
                        }
                    });
                });
                

                $("select[name=lga_id_second_senatorial]").on("change", function() {
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'lga_id': $(this).val(),
                            'slug': "{{$election['slug']}}",
                            'req': "showWards"
                        },
                        success: function(data) {
                            $('select[name=ward_id_senatorial]').html(data);
                        }
                    });
                });

                $("select[name=ward_id_second_governor]").on("change", function() {
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'ward_id': $(this).val(),
                            'slug': "{{$election['slug']}}",
                            'req': "showUnits"
                        },
                        success: function(data) {
                            $('select[name=unit_id_governor]').html(data);
                        }
                    });
                });
            } 


            //queries for senatorial election
            if(election_type == 3) {
                $("input[name=type][type=radio]").on("change", function() {
                    if($(this).val() == 'lga'){
                        $("#view-by-ward-senatorial").hide();
                        $("#view-by-unit-senatorial").hide();
                        $("#view-by-lga-senatorial").show();
                    }

                    if($(this).val() == 'ward'){
                        $("#view-by-lga-senatorial").hide();
                        $("#view-by-unit-senatorial").hide();
                        $("#view-by-ward-senatorial").show();
                    }

                    if($(this).val() == 'unit'){
                        $("#view-by-lga-senatorial").hide();
                        $("#view-by-ward-senatorial").hide();
                        $("#view-by-unit-senatorial").show();
                    }

                    if($(this).val() == 'general'){
                        $("#view-by-lga-senatorial").hide();
                        $("#view-by-ward-senatorial").hide();
                        $("#view-by-unit-senatorial").hide();
                        location.reload();
                    }
                });

                //query result by lga
                $("select[name=lga_id_first_senatorial]").on("change", function() {
                    $('#stats').hide();
                    $("#loader").show();
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'lga_id': $(this).val(),
                            'slug': "{{$election['slug']}}",
                            'req': "lga-result"
                        },
                        success: function(data) {
                            $("#loader").hide();
                            $('#stats').show();
                            $('#stats').html(data);
                        }
                    });
                });

                 //query result by ward
                $("select[name=ward_id_senatorial]").on("change", function() {
                    $('#stats').hide();
                    $("#loader").show();
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'ward_id': $(this).val(),
                            'slug': "{{$election['slug']}}",
                            'req': "ward-result"
                        },
                        success: function(data) {
                            $("#loader").hide();
                            $('#stats').show();
                            $('#stats').html(data);
                        }
                    });
                });

                //query result by polling stations
                $("select[name=unit_id_senatorial]").on("change", function() {
                    $('#stats').hide();
                    $("#loader").show();
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'unit_id': $(this).val(),
                            'ward_id': $("select[name=ward_id_show_senatorial]").val(),
                            'slug': "{{$election['slug']}}",
                            'req': "unit-result"
                        },
                        success: function(data) {
                            $("#loader").hide();
                            $('#stats').show();
                            $('#stats').html(data);
                        }
                    });
                });

                $("select[name=lga_id_show_senatorial]").on("change", function() {
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'lga_id': $(this).val(),
                            'slug': "{{$election['slug']}}",
                            'req': "showWards"
                        },
                        success: function(data) {
                            $('select[name=ward_id_show_senatorial]').html(data);
                        }
                    });
                });

                $("select[name=lga_id_second_senatorial]").on("change", function() {
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'lga_id': $(this).val(),
                            'slug': "{{$election['slug']}}",
                            'req': "showWards"
                        },
                        success: function(data) {
                            $('select[name=ward_id_senatorial]').html(data);
                        }
                    });
                });

                $("select[name=ward_id_show_senatorial]").on("change", function() {
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'ward_id': $(this).val(),
                            'slug': "{{$election['slug']}}",
                            'req': "showUnits"
                        },
                        success: function(data) {
                            $('select[name=unit_id_senatorial]').html(data);
                        }
                    });
                });
            } 

            //queries for local government election
            if(election_type == 4) {
                $("input[name=type][type=radio]").on("change", function() {
                    if($(this).val() == 'ward'){
                        $("#view-by-unit-local").hide();
                        $("#view-by-ward-local").show();
                    }

                    if($(this).val() == 'station'){
                        $("#view-by-ward-local").hide();
                        $("#view-by-unit-local").show();
                    }

                    if($(this).val() == 'general'){
                        $("#view-by-ward").hide();
                        $("#view-by-unit").hide();
                        location.reload();
                    }
                });

                //query result by ward
                $("select[name=ward_id_local]").on("change", function() {
                    $('#stats').hide();
                    $("#loader").show();
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'ward_id': $(this).val(),
                            'slug': "{{$election['slug']}}",
                            'req': "ward-result"
                        },
                        success: function(data) {
                            $("#loader").hide();
                            $('#stats').show();
                            $('#stats').html(data);
                        }
                    });
                });

                //query result by polling stations
                $("select[name=unit_id_local]").on("change", function() {
                    $('#stats').hide();
                    $("#loader").show();
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'unit_id': $(this).val(),
                            'ward_id': $("select[name=ward_id_local]").val(),
                            'slug': "{{$election['slug']}}",
                            'req': "unit-result"
                        },
                        success: function(data) {
                            $("#loader").hide();
                            $('#stats').show();
                            $('#stats').html(data);
                        }
                    });
                });

                $("select[name=ward_id_show]").on("change", function() {
                    $.ajax({
                        url: "{{URL::route('QueryApi')}}", 
                        method: "POST",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'ward_id': $(this).val(),
                            'slug': "{{$election['slug']}}",
                            'req': "showUnits"
                        },
                        success: function(data) {
                            $('select[name=unit_id_local]').html(data);
                        }
                    });
                });
            }

            //assigning of candidate
            $("#assign-btn").on("click", function() {
                $.LoadingOverlay("show");
                var user_id = $("select[name=user_id]").val();
                $.ajax({
                    url: "{{URL::route('ElectionAjax')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'user_id': user_id,
                        'slug': "{{$election['slug']}}",
                        'req': "assignCandidate"
                    },
                    success: function(data){
                        swal("Completed!","Candidate has been assigned to election successfully.", "success");
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
    <script src="{{ asset('js/plugins/slick/slick.min.js') }}"></script>
    <script>
        jQuery(function () {
            // Init page helpers (BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
            Codebase.helpers(['datepicker', 'slick', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']); 
        });
    </script>
@endsection
@section('modals')
    @include('admin.election.modals._assign_candidate')
@endsection
