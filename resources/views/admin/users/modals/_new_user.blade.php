<!-- Create New Student Modal -->
<div class="modal" id="new-user" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title"><i class="si si-user"></i> Add New User</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option create-hover" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content" style="overflow: scroll;height: 600px;">
                    <div class="warning-well">
                        <em>Please note that the field marked with asterik (<span class="required">*</span>) are compulsory.</em>
                    </div><hr/>
                    <div class="card card-body">
                        <div class="col-sm-12">
                            <div class="form-group row">
                                <label for="example-text-input">Username <span class="required">*</span></label>
                                <input type="text" class="form-control form-input" name="username" placeholder="Username" required>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">Email <span class="required">*</span></label>
                                <input type="email" class="form-control form-input" name="email" placeholder="Email Address" required>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">First Name <span class="required">*</span></label>
                                <input type="text" class="form-control form-input" name="first_name" placeholder="Enter First Name" required>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">Last Name <span class="required">*</span></label>
                                <input type="text" class="form-control form-input" name="last_name" placeholder="Enter Last Name" required>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">Phone <span class="required">*</span></label>
                                <input type="text" class="form-control form-input" min-length="11" max-length="11" name="phone" placeholder="Telephone" required>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">User Type <span class="required">*</span></label>
                                <select name="user_type_id" class="form-control form-input" required>
                                    <option value="">--select user type--</option>
                                    @foreach($userTypes as $type)
                                        <option value="{{$type['id']}}">{{$type['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">Role <span class="required">*</span></label>
                                <select name="role_id" class="form-control form-input" required>
                                    <option value="">--select system role--</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role['id']}}">{{$role['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">Residential Address <span class="required">*</span></label>
                                <textarea rows="4" cols="" class="form-control" name="res_address" required></textarea>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary create-hover" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success create-hover" id="submit"><i class="fa fa-check"></i> Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- END Create New Student Modal -->

@section('extra_script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('table.table-condensed tbody tr').on('mouseover',function() {
                $('#user-view').show();
            });
            $('table.table-condensed tbody tr').on('mouseout',function() {
                $('#user-view').hide();
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
