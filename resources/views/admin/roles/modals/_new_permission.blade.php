<!-- Create New Student Modal -->
<div class="modal" id="new-permission" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title"><i class="si si-user"></i> Add New Permission</h3>
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
                                <label for="example-text-input">Name <span class="required">*</span></label>
                                <input type="text" class="form-control form-input" name="pname" placeholder="Name E.g (delete_users)" required>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">Label <span class="required">*</span></label>
                                <input type="text" class="form-control form-input" name="plabel" placeholder="Label E.g (Delete User)" required>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary create-hover" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success create-hover" id="submitPermission"><i class="fa fa-check"></i> Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- END Create New Student Modal -->

@section('extra_script')
@endsection
