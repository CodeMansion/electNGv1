<!-- Create New Student Modal -->
<div class="modal" id="edit-user{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title"><i class="si si-user"></i> Edit User</h3>
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
                            <input type="hidden" class="form-control form-input" value="{{ $user->id }}" id="id{{$index}}" placeholder="Username" required>
                            <div class="form-group row">
                                <label for="example-text-input">Username <span class="required">*</span></label>
                                <input type="text" class="form-control form-input" value="{{ $user->username }}" id="username{{$index}}" placeholder="Username" required>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">Email <span class="required">*</span></label>
                                <input type="email" class="form-control form-input" value="{{ $user->email }}" id="email{{$index}}" placeholder="Email Address" required>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">First Name <span class="required">*</span></label>
                                <input type="text" class="form-control form-input" value="{{ $user->profile->first_name }}" id="first_name{{$index}}" placeholder="Enter First Name" required>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">Last Name <span class="required">*</span></label>
                                <input type="text" class="form-control form-input" value="{{ $user->profile->last_name }}" id="last_name{{$index}}" placeholder="Enter Last Name" required>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">Phone <span class="required">*</span></label>
                                <input type="text" class="form-control form-input" min-length="11" max-length="11" value="{{ $user->profile->phone }}" id="phone{{$index}}" placeholder="Telephone" required>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">User Type <span class="required">*</span></label>
                                <select id="user_type_id{{$index}}" class="form-control form-input" required>
                                    <option value="{{$user->userType->id}}">{{$user->userType->name}}</option>
                                    <option value="">--select user type--</option>
                                    @foreach($userTypes as $type)
                                        <option value="{{$type['id']}}">{{$type['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">Role <span class="required">*</span></label>
                                <select id="role_id{{$index}}" class="form-control form-input" required>
                                    <option value="{{$user->roles()->pluck('id')->implode('|')}}">{{$user->roles()->pluck('name')->implode('|')}}</option>
                                    <option value="">--select system role--</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role['id']}}">{{$role['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">Residential Address <span class="required">*</span></label>
                                <textarea rows="4" cols="" class="form-control" id="res_address{{$index}}" required>{{ $user->profile->res_address}}</textarea>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary create-hover" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success create-hover" id="updateUser{{$index}}"><i class="fa fa-check"></i> Update</button>
            </div>
        </div>
    </div>
</div>

