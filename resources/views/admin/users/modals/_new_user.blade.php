<div id="new-user" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><span class="icon-layers font-green"></span> Create New User</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="errorMsg"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">User Category <span class="required">*</span></label>
                                    <select id="user_category_id" class="form-control" required>
                                        <option value="">--select--</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category['id']}}">{{$category['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Gender <span class="required">*</span></label>
                                    <select id="gender_id" class="form-control" required>
                                        <option value="">--select--</option>
                                        @foreach($genders as $gender)
                                            <option value="{{$gender['id']}}">{{$gender['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Surname <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="surname" placeholder="Enter Surname" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Other Names <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="other_names" placeholder="Enter Other Names" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Phone <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="phone" placeholder="Telephone" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Email <span class="required">*</span></label>
                                    <input type="email" class="form-control" id="email" placeholder="Email Address" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Role <span class="required">*</span></label>
                                    <select id="role_id" class="form-control" required>
                                        <option value="">--select--</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role['id']}}">{{$role['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Residential Address <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="res_address" placeholder="Residential Address" required>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">State of Origin <span class="required">*</span></label>
                                    <select id="state_id" class="form-control" required>
                                        <option value="">--select--</option>
                                        @foreach($states as $state)
                                            <option value="{{$state['id']}}">{{$state['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Photo <span class="required">*</span></label>
                                    <input type="file" class="form-control form-input" id="photo"/>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div><hr/>
                <button type="button" id="new_user_btn" class="btn btn-success create-hover"> Submit</button>
            </div>
        </div>
    </div>
</div>