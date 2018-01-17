@extends('partials.app')
@section('extra_style')
    <!--customize styling for student resource-->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
@endsection
@section('content')
    <main id="main-container">
        <!-- Page Content -->
        <div class="content container">
            @include('partials.notifications')
            <div class="row">
                <div class="block block-content title-hold">
                    <div class="col-12 col-xl-12">
                        <h3 style="margin-bottom:5px;"><i class="si si-settings"></i> Preferences</h3><br/>
                        <p><a href="{{URL::route('Dashboard')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="block block-content">
                    <div class="col-7 col-xl-7">
                        <form action="{{URL::route('preference.Store')}}" class="form-horizontal" method="POST">{{csrf_field()}}
                            <h5>Out-going Mail Settings</h5>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" for="example-hf-email">Host</label>
                                <div class="col-lg-7">
                                    <input type="email" class="form-control" id="example-hf-email" name="example-hf-email" placeholder="Enter Email..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" for="example-hf-email">Port</label>
                                <div class="col-lg-7">
                                    <input type="email" class="form-control" id="example-hf-email" name="example-hf-email" placeholder="Enter Email..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" for="example-hf-email">Username</label>
                                <div class="col-lg-7">
                                    <input type="email" class="form-control" id="example-hf-email" name="example-hf-email" placeholder="Enter Email..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" for="example-hf-email">Password</label>
                                <div class="col-lg-7">
                                    <input type="email" class="form-control" id="example-hf-email" name="example-hf-email" placeholder="Enter Email..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" for="example-hf-email">Encryption</label>
                                <div class="col-lg-7">
                                    <input type="email" class="form-control" id="example-hf-email" name="example-hf-email" placeholder="Enter Email..">
                                </div>
                            </div>

                            <h5>Preferences</h5>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Enable Page Refresh</label>
                                <div class="col-lg-7">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="example-inline-radio1" name="page_refresh" value="1" <?php if($settings->page_refresh === 1){ ?> checked <?php } ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">YES</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="page_refresh" value="0" <?php if($settings->page_refresh === 0){ ?> checked <?php } ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">NO</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Page Refresh Time</label>
                                <div class="col-lg-9">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="example-inline-radio1" name="interval" 
                                        value="10000" <?php if($settings->page_refresh_interval === 10000){ ?> checked <?php } ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">10 SEC</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="example-inline-radio2" name="interval" 
                                        value="20000" <?php if($settings->page_refresh_interval === 20000){ ?> checked <?php } ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">20 SEC</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="example-inline-radio3" name="interval" 
                                        value="30000" <?php if($settings->page_refresh_interval === 30000){ ?> checked <?php } ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">30 SEC</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="example-inline-radio3" name="interval" 
                                        value="60000" <?php if($settings->page_refresh_interval === 60000){ ?> checked <?php } ?>>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">60 SEC</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Enable Sound</label>
                                <div class="col-lg-9">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="example-inline-radio3"  name="sound" 
                                        value="1" <?php if($settings->sound_notification === 1){ ?> checked <?php } ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">YES</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="example-inline-radio3" name="sound" 
                                        value="0" <?php if($settings->sound_notification === 0){ ?> checked <?php } ?>>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">NO</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Counter Display</label>
                                <div class="col-lg-9">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="example-inline-radio3" 
                                        name="party_counter" value="1" <?php if($settings->party_counter === 1){ ?> checked <?php } ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">YES</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="example-inline-radio3" 
                                        name="party_counter" value="0" <?php if($settings->party_counter === 0){ ?> checked <?php } ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">NO</span>
                                    </label>                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary create-hover">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('extra_script')
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/pages/be_tables_datatables.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>

    <script src="{{ asset('js/pages/be_forms_plugins.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#submit").prop('disabled',true);
            $('select[name=upload-type]').on("change", function() {
                if($(this).val() == "") {
                    $("#upload").hide();
                } else {
                    $("#upload").show();
                }
            });

            $('input[name=file]').on("change", function(){
                $("#submit").prop('disabled',false);
            });
        });    
    </script>
@endsection