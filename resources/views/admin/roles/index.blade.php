@extends('partials.app')

@section('content')
    <main id="main-container">
        <!-- Page Content -->
        <div class="content">
            <div class="row" style="">
                <div class="col-12 col-xl-12">
                    <div class="block block-content title-hold">
                        <div class="col-md-12">
                            <h3 style="margin-bottom:5px;">
                                <i class="si si-users"></i> Roles and Permissions 
                                <button data-toggle="modal" data-target="#new-role" class="btn btn-sm btn-primary create-hover" type="button">Add New Roles</button>
                                <button data-toggle="modal" data-target="#new-permission" class="btn btn-sm btn-primary create-hover" type="button">Add New Permission</button>
                                <button data-toggle="modal" data-target="#assign-role" class="btn btn-sm btn-primary create-hover" type="button">Assign</button>
                            </h3><hr/>
                            <p><a href="{{URL::route('Dashboard')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-xl-12">
                    @if(count($roles) < 1)
                        <div class="danger-well">
                            <em>There are no roles and permissions on this system. Use the button above to assign.</em>
                        </div>
                    @else
                        <div class="row">
                            @php($index=0) 
                            @foreach($roles as $role)
                                <div class="col-md-6 col-xl-3">
                                    <div class="block">
                                        <div class="block-header block-header-default">
                                            <h3 class="block-title">{{ strtoupper($role->name) }} <i class="fa fa-trash-o create-hover"></i></h3>
                                        </div>
                                        <div class="block-content" data-toggle="slimscroll">
                                            <input type="hidden" name="" id="role_id{{$index}}" value="{{ $role->id }}">
                                            @php($check=0)
                                            <div class="row">
                                                @foreach($role->permissions as $permission)
                                                    <div class="col-6">
                                                        <label>
                                                                <input type="checkbox" name="check" id="check" value="{{$permission->id}}"> {{$permission->name}}
                                                        </label>
                                                    </div>
                                                @php($check++)
                                                @endforeach
                                            </div>
                                            <hr/><button type="button" class="btn btn-outline-danger btn-sm create-hover" data-delete="{{$role->id}}" id="deleteAssignPermission{{$index}}"><i class="fa fa-close"></i> Remove</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm create-hover" data-delete="{{$role->id}}" id="deleteAssignPermission{{$index}}"><i class="fa fa-edit"></i> Update</button>
                                        </div>
                                    </div>
                                </div>
                            @php($index++)
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection

@section('extra_script')
<script type="text/javascript">
    $(document).ready(function() {
        // this is use to add roles 
            $('#submitRoles').on("click",function() {
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('roles.store')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'name' : $('input[name=name]').val(),
                        'label' : $('input[name=label]').val(),
                        'req' : "newRoles"
                    },
                    success: function(rst,type,title){
                        $.LoadingOverlay("hide");
                        //swal(title, rst, type);
                        swal("Role Created Successfully", "Mail sent successfully in minutes.", "success");
                        location.reload();
                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
            });
            // this is use to assign roles to permissions
            $(".row .card").each(function(i) {
            $('#deleteAssignPermission'+i).on("click",function() {
                var id=$('#role_id'+i).val();
                var ckbox = $("input[name='check']");
                var chkId = '';
                if (ckbox.is(':checked')) {
                $("input[name='check']:checked").each ( function() {
                    chkId = $(this).val() + ",";
                    chkId = chkId.slice(0, -1);
                                     
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('Delete.assign_roles')}}",
                    method: "DELETE",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'check' : chkId,
                        'role' : id,
                        'req' : "DeleteAsssignRoles"
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Permission Removed Successfully", "Mail sent successfully in minutes.", "success");
                        location.reload();
                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                }); });}
            });   
        });
            // this is use to assign roles to permissions
            $('#submitAssign').on("click",function() {
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('roles.assign_permission')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'permissions' : $('#permissions').val(),
                        'roles' : $('#roles').val(),
                        'req' : "newAsssignRoles"
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        //swal(title, rst, type);
                        swal("Permission Assigned Successfully", "Mail sent successfully in minutes.", "success");
                        location.reload();
                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
            });
            // this is use to add permissions 
            $('#submitPermission').on("click",function() {
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('roles.store')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'pname' : $('input[name=pname]').val(),
                        'plabel' : $('input[name=plabel]').val(),
                        'req' : "newPermission"
                    },
                    success: function(rst,type,title){
                        $.LoadingOverlay("hide");
                        //swal(title, rst, type);
                        swal("Permission Created Successfully", "Mail sent successfully in minutes.", "success");
                        location.reload();
                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
            });/**/
        $('#delete').on("click",function(){
            alert($(this).data('id'));
            $.ajax({
                    url: "{{URL::route('Delete.ward')}}",
                    method: "DELETE",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'id': $(this).data('id'),
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Ward Deleted Successfully", "Mail sent successfully in minutes.", "success");
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
    @include('admin.roles.modals._new_roles')
    @include('admin.roles.modals._new_permission')
    @include('admin.roles.modals._assign_roles')
@endsection