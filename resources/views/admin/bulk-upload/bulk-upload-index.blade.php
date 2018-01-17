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
            <div class="row" style="">
                @include('partials.notifications')
                <div class="block block-content title-hold">
                    <div class="col-md-12">
                        <h3 style="margin-bottom:5px;">
                            <i class="si si-grid"></i> Bulk Upload
                        </h3><br/>
                        <p><a href="{{URL::route('Dashboard')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="block block-content title-hold">
                    <div class="col-6 col-xl-6">
                        <h4>Upload a CSV file</h4>
                        <form action="{{URL::route('preference.uploadStore')}}" method="POST" enctype="multipart/form-data">{{csrf_field()}}
                            <div class="form-group">
                                <label>Table <span class="required">*</span></label>
                                <select class="form-control" name="upload-type" required>
                                    <option value="">--select table to upload--</option>
                                    <option value="state">State</option>
                                    <option value="constituency">Constituency</option>
                                    <option value="ward">Ward</option>
                                    <option value="lga">Local Govt. Areas</option>
                                    <option value="polling-centres">Polling Centres</option>
                                </select>
                                <span style="font-size:13px;"><em>The <b>table</b> field is the type of file you want to upload.</em></span>
                            </div>
                            <div class="form-group" id="upload" style="display:none;">
                                <label>File  <span class="required">*</span></label>
                                <input class='form-control' name="file" type="file" required>
                                <span style="font-size:13px;"><em>This must be a CSV/Excel file.</em></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" id="submit" class="btn btn-sm btn-primary create-hover">Upload File</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-7 col-xl-7"></div>
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
            $("#submit").attr('disabled',true);
            $('select[name=upload-type]').on("change", function() {
                if($(this).val() == "") {
                    $("#upload").hide();
                } else {
                    $("#upload").show();
                }
            });

            $('input[name=file]').on("change", function(){
                $("#submit").attr('disabled',false);
            });
        });    
    </script>
@endsection