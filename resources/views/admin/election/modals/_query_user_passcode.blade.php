<!-- Create New Student Modal -->
<div id="modal">
<div class="modal" id="userPasscode" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title"><i class="si si-users"></i> Query Passcode</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option create-hover" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <div class="info-well">
                        <em>Please follow the instructions and fill the form carefully. Note that fields make with asterisk (<span class="required">*</span>) are compulsory.</em>
                    </div><hr/>
                    <div class="card card-body">
                
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary create-hover" data-dismiss="modal">Close</button>
                @if(config('constants.ACTIVE_STATE_ID'))
                <button type="button" class="btn btn-success create-hover" id="assignUser{{$index}}"><i class="fa fa-check"></i> Assign User</button>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
<!-- END Create New Student Modal -->


