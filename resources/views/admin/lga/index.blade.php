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
                                <i class="si si-grid"></i> Local Govt. Areas
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
                    <h4>Add New Local Govt. Area</h4>
                    <form>
                        <div class="form-group">
                            <label>State <span class="required">*</span></label>
                            <input class='form-control' name="state_id" type="text" value="{{config('constants.ACTIVE_STATE_NAME')}}" disabled>
                            <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                        </div>
                        <div class="form-group">
                            <label>Name <span class="required">*</span></label>
                            <input class='form-control' name="name" type="text" required>
                            <span style="font-size:13px;"><em>The <b>name</b> is the full meaning of the code.</em></span>
                        </div>
                        <div class="form-group">
                            <label>Code <span class="required"></span></label>
                            <input class='form-control' name="code" required>
                            <span style="font-size:13px;"><em>The <b>description</b> is just a brief explanation of the political party.</em></span>
                        </div>
                        <div class="form-group">
                            <button type="button" id="submit" class="create-hover btn btn-sm btn-primary">Add Local Govt Area</button>
                        </div>
                    </form>
                </div>
                <div class="col-7 col-xl-7">
                    <div class="block block-content content-hold">
                        @if(!config('constants.ACTIVE_STATE_ID'))
                            <div class="info-well">
                                <em>There is no active state on this system. Please go to states to activate a state.</em>
                            </div>
                        @else
                            @if(count($lgas) < 1)
                                <div class="danger-well">
                                    <em>There are no politial parties on this system. Use the button above to add a political party.</em>
                                </div>
                            @else
                                <table class="table table-striped js-dataTable-full">
                                    <thead>
                                        <tr>
                                            <th width="50"><input type="checkbox" name="" value=""></th>
                                            <th>NAME</th>
                                            <th>CODE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($index=0)
                                        @foreach($lgas as $lga)
                                            <tr>
                                                <td><input type="checkbox" name="" value=""></td>
                                                <td class="state_{{$index}}">
                                                    <a href="">{{$lga['name']}}</a><br/>
                                                    <span id="user-view{{$index}}" style="display:none;color:grey;" style="font-size: 12px;">
                                                        <a href="#"><i class="fa fa-edit"></i> Edit</a> | 
                                                        <a href="#"><i class="fa fa-trash-o"></i> Delete</a>
                                                    </span>
                                                </td>
                                                <td>{{$lga['code']}}</td>
                                            </tr>
                                        @php($index++)
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
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
        });    
    </script>
@endsection