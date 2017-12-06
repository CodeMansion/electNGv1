<!-- Create New Student Modal -->
<div class="modal" id="assign-role" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title"><i class="si si-user"></i> Add New Role</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option create-hover" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content" style="">
                    <div class="warning-well">
                        <em>Please note that the field marked with asterik (<span class="required">*</span>) are compulsory.</em>
                    </div><hr/>
                    <div class="card card-body">
                        <div class="col-sm-12">
                            <div class="form-group row">
                                <label for="example-text-input">Roles<span class="required">*</span></label>
                                <select name="roles" id="roles" class="form-control form-input" required>
                                    <option value="">--select Role--</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role['id']}}">{{$role['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">Permissions<span class="required">*</span></label>
                                <select class="form-control form-input select2" multiple="multiple" name="permission" id="permissions" required>
                                    <option>-- Select Permissions --</option>
                                    @foreach($permissions as $permission)
                                        <option value="{{$permission['id']}}">{{$permission['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary create-hover" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success create-hover" id="submitAssign"><i class="fa fa-check"></i> Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- END Create New Student Modal -->

@section('extra_script')
@endsection
