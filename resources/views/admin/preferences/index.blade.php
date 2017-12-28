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
        <div class="content">
            <div class="row" style="">
                <div class="col-12 col-xl-12">
                    <div class="block block-content title-hold">
                        <div class="col-md-12">
                            <h3 style="margin-bottom:5px;">
                                <i class="si si-settings"></i> Preferences
                                <p class="p-10 bg-primary-lighter text-primary-dark pull-right">{{config('constants.ACTIVE_STATE_NAME')}} - State</p>
                            </h3><hr/>
                            <p><a href="{{URL::route('Dashboard')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a></p>
                            @include('partials.notifications')
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-5 col-xl-5">
                    <div class="block">
                    <div class="block-content">
                        <form action="{{URL::route('preference.Store')}}" method="POST">{{csrf_field()}}
                            <div class="form-group">
                                <label>Enable Page Refresh</label>
                                <div>
                                    <div class="col-sm-3">
                                        <input type="radio" name="page_refresh" value="1" <?php if($settings->page_refresh === 1){ ?> checked <?php } ?> > Yes
                                    </div>  
                                    <div class="col-sm-3">
                                        <input type="radio" name="page_refresh" value="0" <?php if($settings->page_refresh === 0){ ?> checked <?php } ?> > No
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Page Refresh Interval</label>
                                <div>
                                    <div class="col-sm-3">
                                        <input type="radio" name="interval" value="10000" <?php if($settings->page_refresh_interval === 10000){ ?> checked <?php } ?> > 10 Sec
                                    </div>  
                                    <div class="col-sm-3">
                                        <input type="radio" name="interval" value="20000" <?php if($settings->page_refresh_interval === 20000){ ?> checked <?php } ?> > 20 Sec
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="radio" name="interval" value="30000" <?php if($settings->page_refresh_interval === 30000){ ?> checked <?php } ?> > 30 Sec
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="radio" name="interval" value="60000" <?php if($settings->page_refresh_interval === 60000){ ?> checked <?php } ?> > 60 Sec
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Enable Sound Notification </label>
                                <div> 
                                    <div class="col-sm-3">
                                        <input type="radio" name="sound" value="1" <?php if($settings->sound_notification === 1){ ?> checked <?php } ?> > Yes
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="radio" name="sound" value="0" <?php if($settings->sound_notification === 0){ ?> checked <?php } ?>> No
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Enable Party Counter Display </label>
                                <div> 
                                    <div class="col-sm-3">
                                        <input type="radio" name="party_counter" value="1" <?php if($settings->party_counter === 1){ ?> checked <?php } ?> > Yes
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="radio" name="party_counter" value="0" <?php if($settings->party_counter === 0){ ?> checked <?php } ?>> No
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary create-hover">Update</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
                <div class="col-7 col-xl-7">
                    
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