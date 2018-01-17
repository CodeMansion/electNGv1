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
            <div class="row">
                <div class="block block-content title-hold">
                    <div class="col-12">
                        <h3 style="margin-bottom:5px;"><i class="si si-grid"></i> Political Parties</h3><br/>
                        <p><a href="{{URL::route('Dashboard')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a></p>
                    </div>
                </div>
            </div>

            <div class="block block-content title-hold">
                <div class="row">
                    <div class="col-md-5">
                        <h5>Add New Political Party</h5>
                        <div class="form-group">
                            <label>Code <span class="required">*</span></label>
                            <input class='form-control' name="code" type="text" required>
                            <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                        </div>
                        <div class="form-group">
                            <label>Name <span class="required">*</span></label>
                            <input class='form-control' name="name" type="text" required>
                            <span style="font-size:13px;"><em>The <b>name</b> is the full meaning of the code.</em></span>
                        </div>
                        <div class="form-group">
                            <label>Description <span class="required"></span></label>
                            <textarea class='form-control' name="description" rows="6" required></textarea>
                            <span style="font-size:13px;"><em>The <b>description</b> is just a brief explanation of the political party.</em></span>
                        </div>
                        <div class="form-group">
                            <div style="padding: 5px;">
                                <label class="control-label">Logo <span class="required"> * </span></label><br/>
                                <div id="image_preview_logo" style="height:100px;width:100px;-webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);background-position:center center;background-size:cover;display:inline-block;"></div><br/>
                                <input type="file" name="logo" id="uploadLogo"/>
                            </div>
                            <div id="errorMessage_logo"></div>
                        </div>
                        <div class="form-group">
                            <button type="button" id="submit" class="create-hover btn btn-sm btn-primary">Add New Political Party</button>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h5>List of Political Party</h5>
                        @if(count($politicalParties) < 1)
                        <div class="danger-well">
                            <em>There are no politial parties on this system. Use the button above to add a political party.</em>
                        </div>
                        @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="50"></th>
                                    <th>CODE</th>
                                    <th>NAME</th>
                                    <th>DESCRIPTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($index=0)
                                @foreach($politicalParties as $party)
                                    <tr class="state_{{$index}}">
                                        <td></td>
                                        <td>
                                            <a href="{{URL::route('PP.Edit',$party['slug'])}}">{{$party['code']}}</a>
                                        </td>
                                        <td>
                                            {{$party['name']}}<br/>
                                            <span id="user-view{{$index}}" style="display:none;color:grey;" style="font-size: 12px;">
                                                <a href="#"><i class="fa fa-edit"></i> Edit</a> | 
                                                <a href="#"><i class="fa fa-trash-o"></i> Delete</a>
                                            </span>
                                        </td>
                                        <td>{{$party['description']}}</td>
                                    </tr>
                                @php($index++)
                                @endforeach
                            </tbody>
                        </table>
                        @endif
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
            $('table.table-striped tbody tr').each(function(index) {
                $(".state_"+index).on('mouseover',function() {
                    $('#user-view'+index).show();
                });
                $(".state_"+index).on('mouseout',function() {
                    $('#user-view'+index).hide();
                });
            });
           

            //submit new user form
            $('#submit').on("click",function() {
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('PP.New')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'code' : $('input[name=code]').val(),
                        'name' : $('input[name=name]').val(),
                        'description' : $('textarea[name=description]').val(),
                        'req' : "newPP"
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Created Successfully", rst, "success");
                        location.reload();
                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
            });   


            $("#uploadLogo").bind("change", function () {
                $("#errorMessage_logo").html("");
                //Get reference of FileUpload.
                var fileUpload = $("#uploadLogo")[0];

                //Check whether the file is valid Image.
                var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
                if (regex.test(fileUpload.value.toLowerCase())) {
                    //Check whether HTML5 is supported.
                    if (typeof (fileUpload.files) != "undefined") {
                        var reader = new FileReader();
                        reader.readAsDataURL(fileUpload.files[0]);
                        reader.onload = function (e) {
                            var image = new Image();
                            image.src = e.target.result;
                            image.onload = function () {
                                var height = this.height;
                                var width = this.width;
                                if (width < 1024 && height < 683) {
                                    $("#image_preview_logo").css("background-image", "url("+e.target.result+")");
                                    return true;
                                } else {
                                    $("#errorMessage_logo").html("<em>Invalid image dimension! File must be 1024x683 respectively. Try Again!</em>");
                                    return false;
                                } 
                            };
                        }
                    } else {
                        $("#errorMessage_logo").html("<em>Sorry this browser does not support HTML5</em>");
                        return false;
                    }
                } else {
                    $("#errorMessage_logo").html("<em>Please select a valid image file.</em>");
                    return false;
                }
            });
        });    
    </script>
@endsection