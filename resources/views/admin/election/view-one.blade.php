@extends('partials.app')
@section('extra_style')
    <!--customize styling for student resource-->
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/select2-bootstrap.min.css')}}">
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
                                <i class="si si-feed"></i> {{$election['name']}} 
                            </h3><hr/>
                            <p>
                                <a href="{{URL::route('Dashboard')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a> |
                                <a href="{{URL::route('Election.View')}}"><i class="si si-arrow-left"></i> Elections</a> 
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-2">
                    @include('admin.election.partials._left_col')
                </div>
                <div class="col-7 col-xl-7">
                    <!-- Block Tabs With Options Default Style -->
                    <div class="block">
                        <ul class="nav nav-tabs nav-tabs-block align-items-center" data-toggle="tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" href="#statistics">Overview</a></li>
                            <li class="nav-item"><a class="nav-link active" href="#results">Polling Results</a></li>
                            <li class="nav-item"><a class="nav-link" href="#centres">Election Centres</a></li>
                            <li class="nav-item"><a class="nav-link" href="#officials">Polling Officials</a></li>
                            <li class="nav-item ml-auto">
                                <div class="block-options mr-15">
                                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                        <i class="si si-refresh"></i>
                                    </button>
                                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                                </div>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <div class="tab-pane active" id="statistics" role="tabpanel">
                                <h4 class="font-w400">General Statistics</h4>
                                <p>...</p>
                            </div>
                            <div class="tab-pane" id="results" role="tabpanel">
                                <h4 class="font-w400">Polling Results</h4>
                                <p>...</p>
                            </div>
                            <div class="tab-pane" id="centres" role="tabpanel">
                                <h4 class="font-w400">Election Centres</h4>
                                <p>...</p>
                            </div>
                            <div class="tab-pane" id="officials" role="tabpanel">
                                <h4 class="font-w400">Polling Officials</h4>
                                <p>...</p>
                            </div>
                        </div>
                    </div>
                    <!-- END Block Tabs With Options Default Style -->
                </div>
                <div class="col-3 col-xl-3">
                    @include('admin.election.partials._right_col')
                </div>
            </div>
        </div>
    </main>
@endsection
@section('extra_script')
    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js')}}"></script>


    <script src="{{ asset('js/pages/be_forms_plugins.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            //view assign parties form
            $("#viewAsnForm").on("click", function() {
                $("#assignParties").show();
                $("#viewAsnForm").hide();
                $("table.table-striped").hide();
            });

            //closing the assign form
            $("#cls").on("click", function() {
                $("#viewAsnForm").show();
                $("#assignParties").hide();
                $("table.table-striped").show();
            });

            //submit new user form
            $('#submit').on("click",function() {
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('Election.AssignParty')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'party' : $('select[name=party').val(),
                        'election_id' : <?php echo $election['id']; ?>,
                        'req' : "assignParty"
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
    </script>
    <script>
        jQuery(function () {
            // Init page helpers (BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
            Codebase.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']);
        });
    </script>
@endsection