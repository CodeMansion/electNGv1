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
                                <i class="si si-users"></i> Users 
                                <button data-toggle="modal" data-target="#new-user" class="btn btn-sm btn-primary create-hover" type="button">Add New</button>
                            </h3><hr/>
                            <p><a href="{{URL::route('Election.View')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a></p>
                            @include('partials.notifications')
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="block block-content content-hold">
                        @if(count($users) < 1)
                            <div class="danger-well">
                                <em>There are no users on this system. User to button above to create a new user.</em>
                            </div>
                        @else
                            <table class="table table-condensed table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th width="50"><input type="checkbox" name="" value=""></th>
                                        <th width="50"></th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                    </td>
                                </thead>
                                <tbody>
                                    @php($index=0)
                                    @foreach($users as $user)
                                        <tr>
                                            <td><input type="checkbox" name="" value=""></td>
                                            <td><img src="{{ asset('images/default.png') }}" width="26" height="26" /></td>
                                            <td class="user-edit{{$index}}">
                                                <a href="">{{$user['username']}}</a><br/>
                                                <span id="user-view{{$index}}" style="display:none;color:grey;" style="font-size: 12px;">
                                                    <a href="#" data-toggle="modal" data-target="#edit-user{{$user['id']}}" ><i class="fa fa-edit"></i> Edit</a> | 
                                                    <a href="#" class="danger" id="delete" data-id="{{$user->id}}"><i class="fa fa-times"></i> delete</a>
                                                </span>
                                            </td>
                                            <td>{{$user->profile->first_name.' '.$user->profile->last_name}}</td>
                                            <td>{{$user['email']}}</td>
                                            <td>{{$user->roles()->pluck('name')->implode('|')}}</td>
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