@extends('partials.app')
@section('extra_style')
    <!--customize styling for student resource-->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
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
                            </div>
                            <div class="form-group">
                                <button type="button" id="submit" class="btn btn-sm btn-primary create-hover">Upload File</button>
                            </div>
                        </form><br/>
                        <div class="progress" id="progress_div">
                            <div class='bar' id='bar'></div>
                            <div class='percent' id='percent'>0%</div>
                        </div>
                    </div>
                    <div class="col-7 col-xl-7"></div>
                </div>
            </div>
        </div>
    </main>
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
                
                $(this).attr('disabled',true);
                $(this).html("<i class='fa fa-refresh fa-spin'></i> Uploading... Please wait");
                
                $.ajax({
                    url: "{{URL::route('preference.uploadStore')}}",
                    method: "POST",
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(rst){
                        if(rst.type == "true") {
                            $("#submit").attr('disabled',false);
                            $("#submit").html("<i class=''></i> Submit");
                            $("#ErrorMsg").html("<div class='alert alert-success'>"+rst.msg+"</div>");
                        } else if(rst.type == "false") {
                            $("#submit").attr('disabled',false);
                            $("#submit").html("<i class=''></i> Try again");
                            $("#ErrorMsg").html("<div class='alert alert-danger'>"+rst.msg+"</div>");
                        }
                    },
                    error: function(jqXHR, textStatus, errorMessage){
                        $("#submit").attr('disabled',false);
                        $("#submit").html("<i class=''></i> Try again");
                        $("#ErrorMsg").html("<div class='alert alert-danger'>"+errorMessage+"</div>");
                    }
                });   
            }
        });  
    </script>
@endsection