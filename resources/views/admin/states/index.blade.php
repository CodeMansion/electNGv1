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
                                <i class="si si-users"></i> States 
                                <p class="p-10 bg-primary-lighter text-primary-dark pull-right">{{config('constants.ACTIVE_STATE_NAME')}} - State</p>

                            </h3><hr/>
                            <p><a href="{{URL::route('Dashboard')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a></p>
                            @include('partials.notifications')
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="block block-content content-hold">
                        @if(count($states) < 1)
                            <div class="danger-well">
                                <em>There are no users on this system. User to button above to create a new user.</em>
                            </div>
                        @else
                            <table class="table table-striped js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th width="50"><input type="checkbox" name="" value=""></th>
                                        <th>States</th>
                                        <th>LGA Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($index=0)
                                    @foreach($states as $state)
                                        <tr>
                                            <td><input type="checkbox" name="" value=""></td>
                                            <td class="state_{{$index}}">
                                                <a href="">{{$state['name']}}</a><br/>
                                                <span id="user-view{{$index}}" style="display:none;color:grey;" style="font-size: 12px;">
                                                    <a href="#"><i class="fa fa-edit"></i> Edit</a> | 
                                                    <span id="activate_{{$index}}"><a href="#"><i class="fa fa-cog"></i> Activate</a></span>
                                                    <input id="state_id_{{$index}}" value="{{$state['id']}}" type="hidden"> 
                                                </span>
                                            </td>
                                            <td>{{count($state->Lgas)}}</td>
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

                $("#activate_"+index).on("click", function() {
                    var state_id = $("#state_id_"+index).val();
                    $.LoadingOverlay("show");
                    $.ajax({
                        url: "{{URL::route('State.Activate')}}",
                        method: "POST",
                        data:{
                            '_token': "{{csrf_token()}}",
                            'state_id' : state_id,
                            'req' : "activateState"
                        },
                        success: function(rst){
                            $.LoadingOverlay("hide");
                            swal("User Created Successfully", "Mail sent successfully in minutes.", "success");
                            location.reload();
                        },
                        error: function(rst){
                            $.LoadingOverlay("hide");
                            swal("Oops! Error","An Error Occured!", "error");
                        }
                    });
                });
            });
           

            //submit new user form
            $('#submit').on("click",function() {
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('Users.New')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'email' : $('input[name=email]').val(),
                        'username' : $('input[name=username]').val(),
                        'user_type_id' : $('select[name=user_type_id]').val(),
                        'role_id' : $('select[name=role_id]').val(),
                        'first_name' : $('input[name=first_name]').val(),
                        'last_name' : $('input[name=last_name]').val(),
                        'phone' : $('input[name=phone]').val(),
                        'res_address': $('textarea[name=res_address]').val(),
                        'req' : "newUser"
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("User Created Successfully", "Mail sent successfully in minutes.", "success");
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