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
                                <i class="si si-feed"></i> Elections 
                                <button data-toggle="modal" data-target="#new-election" class="btn btn-sm btn-primary create-hover" type="button">Add Election</button>
                                <p class="p-10 bg-primary-lighter text-primary-dark pull-right">{{config('constants.ACTIVE_STATE_NAME')}} - State</p>
                            </h3><hr/>
                            <p><a href="{{URL::route('Dashboard')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a></p>
                            @include('partials.notifications')
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6 col-xl-6">
                    <h4>Add New Political Party</h4>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="example-text-input">Name <span class="required">*</span></label>
                            <input type="text" class="form-control form-input" name="name" required>
                            <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                        </div>
                        <div class="col-md-6">
                            <label for="example-text-input">Description <span class="required"></span></label>
                            <input type="text" class="form-control form-input" name="description">
                            <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="example-text-input">Start Date <span class="required">*</span></label>
                            <input type="text" class="js-datepicker form-control form-input" id="example-datepicker1" name="start_date" 
                            data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy">
                            <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                        </div>
                        <div class="col-md-6">
                            <label for="example-text-input">End Date <span class="required">*</span></label>
                            <input type="text" class="js-datepicker form-control form-input" id="example-datepicker1" name="end_date" 
                            data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy">
                            <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="example-text-input">Type of Election <span class="required">*</span></label>
                            <select name="type" class="form-control">
                                <option value="">--select election type--</option>
                                <!-- <option value="national">National</option> -->
                                <option value="state">State</option>
                                <option value="lga">Local Govt. Area</option>
                            </select>
                            <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                        </div>
                        <div class="col-md-6" id="view-state" style="display:none;">
                            <label for="example-text-input">Select State <span class="required">*</span></label>
                            <select name="state_id" class="form-control">
                                <option value="">--select state--</option>
                                @foreach($states as $state)
                                    <option value="{{$state['id']}}">{{$state['name']}}</option>
                                @endforeach
                            </select>
                            <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6" id="view-lga">
                        </div>
                    </div>
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
            $("#view-state").hide();
            $("#view-lga").hide();
            $("select[name=type]").on("change", function(){
                if($(this).val() != '') {
                    $("#view-state").show();
                } else {
                    $("#view-state").hide();
                }
            });

            $("select[name=state_id]").on("change", function(){
                if($("select[name=type]").val() == 'state'){
                    $.LoadingOverlay("show");
                    var state_id = $(this).val();
                    $.ajax({
                        url: "{{URL::route('ElectionAjax')}}",
                        method: "POST",
                        data:{
                            '_token': "{{csrf_token()}}",
                            'state_id': state_id,
                            'req': "viewLga"
                        },
                        success: function(data){
                            $("#view-lga").show();
                            $.LoadingOverlay("hide");
                            $("#view-lga").html(data);
                        },
                        error: function(rst){
                            $.LoadingOverlay("hide");
                            swal("Oops! Error","An Error Occured!", "error");
                        }
                    });
                }
            });
            //submit new user form
            $('#submit').on("click",function() {
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('Election.New')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'name' : $('input[name=name]').val(),
                        'description' : $('textarea[name=description]').val(),
                        'start_date' : $('input[name=start_date]').val(),
                        'end_date' : $('input[name=end_date]').val(),
                        'req' : "newElection"
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Created!", rst, "success");
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
@section('modals')
    @include('admin.election.modals._new_election')
@endsection