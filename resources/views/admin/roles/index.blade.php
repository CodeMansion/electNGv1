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
                                <i class="si si-users"></i> Roles &amp; Permissions 
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
                    <div class="block block-content content-hold">
                        @if(count($roles) < 1)
                            <div class="danger-well">
                                <em>There are no roles &amps; permissions on this system. Use the button above to assign.</em>
                            </div>
                        @else
                        <div class="row">
                            @php($index=0) 
                            @foreach($roles as $role)
                            <div class="card col-lg-4 col-md-4 col-sm-12">
                                <div class="card-block">
                                    <div class="block-header">
                                        <h3 class="card-title">
                                            {{ strtoupper($role->name) }} <small></small>
                                        </h3>
                                    </div>
                                    <div class="block-content block-content-full">
                                        <div class="pull-all">
                                            <input type="hidden" name="" id="role_id{{$index}}" value="{{ $role->id }}">
                                            @php($check=0)
                                            @foreach($role->permissions as $permission)
                                                <div class="form-group" style="display: inline;padding-left: 10px;">
                                                    <label class="no-margin">
                                                            <input type="checkbox" name="check" id="check" value="{{$permission->id}}" required="">{{$permission->name}}
                                                    </label>
                                                </div>
                                            @php($check++)
                                            @endforeach
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success create-hover" data-delete="{{$role->id}}" id="deleteAssignPermission{{$index}}"><i class="fa fa-check"></i> remove</button>
                                </div>
                            </div>
                            @php($index++)
                            @endforeach
                        </div>
                        @endif
                    </div>
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
            $.ajax({
                    url: "{{URL::route('Delete.each')}}",
                    method: "DELETE",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'id': $(this).data('id'),
                        'req' : "DeleteRoles"
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Role Deleted Successfully", "Mail sent successfully in minutes.", "success");
                        location.reload();

                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
        });
        $('#deleteperm').on("click",function(){
            $.ajax({
                    url: "{{URL::route('Delete.each')}}",
                    method: "DELETE",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'id': $(this).data('id'),
                        'req' : "DeletePermissions"
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Permissions Deleted Successfully", "Mail sent successfully in minutes.", "success");
                        location.reload();

                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
        });
        $('.add').hide();
        $('.show_role').hide();
        $('.add_role').click(function(){
            $('.add').show();
            $('.show_role').show();
            $('.add_role').hide();
            $('.role_table').hide();
        })
        $('.show_role').click(function(){
            $('.add').hide();
            $('.show_role').hide();
            $('.add_role').show();
            $('.role_table').show();
        })
        $("#modal .modal").each(function(i) {
            $('#updatePermission'+i).on("click",function() {
                var id=$('#id'+i).val();
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('roles.update')}}",
                    method: "PATCH",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'id':id,
                        'pname' : $('#pnames'+i).val(),
                        'plabel': $('#plabels'+i).val(),
                        'req' : "UpdatePermission"
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Permission Updated Successfully", "Mail sent successfully in minutes.", "success");
                        location.reload();

                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
            });   
        });
        $("#modal .modal").each(function(i) {
            $('#updateRole'+i).on("click",function() {
                var id=$('#roleid'+i).val();
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('roles.update')}}",
                    method: "PATCH",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'role_id':$('#roleid'+i).val(),
                        'name' : $('#name'+i).val(),
                        'label': $('#label'+i).val(),
                        'req' : "UpdateRole"
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Role Updated Successfully", "Mail sent successfully in minutes.", "success");
                        location.reload();

                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
            });   
        });
    });   
</script>
@endsection
@section('modals')
    @include('admin.roles.modals._new_roles')
    @include('admin.roles.modals._new_permission')
    @include('admin.roles.modals._assign_roles')
    <div id="modal">
        @php($index=0)        
        @foreach($permissions as $permission)
            @include('admin.roles.modals._new_edit_permission')
            @php($index++)
        @endforeach
    </div>
    <div id="modal">
        @php($index=0)        
        @foreach($roles as $role)
            @include('admin.roles.modals._new_edit_role')
            @php($index++)
        @endforeach
    </div>
@endsection