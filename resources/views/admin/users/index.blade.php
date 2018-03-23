@extends('partials.app')
    <link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
@section('content')
<div class="breadcrumbs">
        <h1>Users</h1>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">Dashboard</a></li>
            <li class="active">Users</li>
        </ol>
    </div>
    <!-- BEGIN SIDEBAR CONTENT LAYOUT -->
    <div class="page-content-container">
        <div class="page-content-row">
            <!-- BEGIN PAGE SIDEBAR -->
            <div class="page-sidebar">
                <nav class="navbar" role="navigation">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <ul class="nav navbar-nav margin-bottom-35">
                        <li><a href="index.html"><i class="icon-home"></i> Home </a></li>
                        <li><a href="#"><i class="icon-note "></i> Reports </a></li>
                        <li><a href="{{URL::route('Users.View')}}"><i class="icon-user"></i> User </a></li>
                        <li><a href="{{URL::route('Election.View')}}"><i class="icon-trophy "></i> Elections </a></li>
                        <li><a href="#"><i class="icon-bell"></i> Activity Logs </a></li>
                        <li><a href="{{URL::route('State.View')}}"><i class="icon-flag"></i> States & LGAs</a></li>
                        <li><a href="{{URL::route('ward.index')}}"><i class="icon-directions"></i> Polling Units</a></li>
                        <li><a href="{{URL::route('PP.View')}}"><i class="icon-users"></i> Political Parties </a></li>
                        <li><a href="{{URL::route('preference.uploadView')}}"><i class="icon-cloud-upload"></i> Bulk Upload </a></li>
                        <li><a href="{{URL::route('preference.index')}}"><i class="icon-bell"></i> Settings </a></li>
                    </ul>
                </nav>
            </div>
            <!-- END PAGE SIDEBAR -->
            <div class="page-content-col">
                @include('partials.notifications')
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <!-- BEGIN Portlet PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-green-sharp">
                                    <i class="icon-speech font-green-sharp"></i>
                                    <span class="caption-subject bold uppercase">Users</span>
                                    <span class="caption-helper">Showing the list system users...</span>
                                </div>
                                <div class="actions">
                                    <a href="javascript:;" data-toggle="modal" data-target="#new-election" class="btn btn-circle btn-default btn-sm"><i class="fa fa-plus"></i> Add Users </a>
                                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                @if(count($users) < 1)
                                    <div class="danger-well">
                                        <em>There are no users on this system. </em>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <table class="table table-striped table-hover" id="sample_3">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th>USERNAME</th>
                                                        <th>NAME</th>
                                                        <th>EMAIL</th>
                                                        <th>ROLE</th>
                                                        <th>ACTIONS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php($index=0)
                                                    @foreach($users as $user)
                                                        <tr>
                                                            <td></td>
                                                            <td><img src="{{ asset('images/default.png') }}" width="26" height="26" /></td>
                                                            <td class="user-edit{{$index}}">{{$user['username']}}
                                                                <!-- <span id="user-view{{$index}}" style="display:none;color:grey;" style="font-size: 12px;">
                                                                    <a href="#" data-toggle="modal" data-target="#edit-user{{$user['id']}}" ><i class="fa fa-edit"></i> Edit</a> | 
                                                                    <a href="#" class="danger" id="delete" data-id="{{$user->id}}"><i class="fa fa-times"></i> delete</a>
                                                                </span> -->
                                                            </td>
                                                            <td>{{$user->profile->first_name.' '.$user->profile->last_name}}</td>
                                                            <td>{{$user['email']}}</td>
                                                            <td>{{$user->roles()->pluck('name')->implode('|')}}</td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-xs btn-default dropdown-toggle" type="button" id="button" data-toggle="dropdown" aria-expanded="false"> Actions<i class="fa fa-angle-down"></i></button>
                                                                    <ul class="dropdown-menu pull-left" role="menu">
                                                                        <li><a href="{{URL::route('Election.ViewOne')}}"><i class="icon-note"></i> Edit </a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @php($index++)
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra_script')
    <script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('table.table-condensed tbody tr').each(function(index) {
            $(".user-edit"+index).on('mouseover',function() {
                $('#user-view'+index).show();
            });
            $(".user-edit"+index).on('mouseout',function() {
                $('#user-view'+index).hide();
            });
        });

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
        $("#modal .modal").each(function(i) {
            $('#updateUser'+i).on("click",function() {
                var id=$('#id'+i).val();
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('Users.update')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'id':id,
                        'email' : $('#email'+i).val(),
                        'username' : $('#username'+i).val(),
                        'user_type_id' : $('#user_type_id'+i).val(),
                        'role_id' : $('#role_id'+i).val(),
                        'first_name' : $('#first_name'+i).val(),
                        'last_name' : $('#last_name'+i).val(),
                        'phone' : $('#phone'+i).val(),
                        'res_address': $('#res_address'+i).val(),
                        'req' : "UpdateUser"
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("User Updated Successfully", "Mail sent successfully in minutes.", "success");
                        location.reload();

                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
            });   
        });
        $('#delete').on("click",function(){
            alert($(this).data('id'));
            $.ajax({
                    url: "{{URL::route('Delete.User')}}",
                    method: "DELETE",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'id': $(this).data('id'),
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("User Deleted Successfully", "Mail sent successfully in minutes.", "success");
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
@section('modals')
    @include('admin.users.modals._new_user')
    <div id="modal">
    @php($index=0)        
        @foreach($users as $user)
            @include('admin.users.modals._new_edit')
        @php($index++)
        @endforeach
    </div>
@endsection
@section('after_script')
    <script src="{{ asset('assets/pages/scripts/table-datatables-managed.min.js') }}" type="text/javascript"></script>
@endsection