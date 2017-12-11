<!-- Create New Student Modal -->
<div class="modal" id="edit-permission{{$permission->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title"><i class="si si-user"></i> Edit Permision</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option create-hover" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content" style="">
                    <div class="warning-well" style="margin-bottom: 10px;">
                        <em>Please note that the field marked with asterik (<span class="required">*</span>) are compulsory.</em>
                    </div><hr/>
                    <div class="card card-body">
                        <div class="col-sm-12">
                            <input type="hidden" class="form-control form-input" value="{{ $permission->id }}" id="id{{$index}}" placeholder="Username" required>
                            
                        </div> 
                        <div class="col-sm-12">
                            <div class="form-group row">
                                <label for="example-text-input">Name <span class="required">*</span></label>
                                <input type="text" class="form-control form-input" name="pname{{$index}}" id="pnames{{$index}}" value="{{ $permission->name }}" placeholder="Name" required>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">Label <span class="required">*</span></label>
                                <input type="text" class="form-control form-input" name="plabel{{$index}}" id="plabels{{$index}}" value="{{ $permission->label }}" placeholder="Name" required>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary create-hover" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success create-hover" id="updatePermission{{$index}}"><i class="fa fa-check"></i> Update</button>
            </div>
        </div>
    </div>
</div>

