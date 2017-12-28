<!-- Create New Student Modal -->
<div id="modal">
    <div class="modal" id="assignCandidate" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title"><i class="si si-users"></i> Assign Candidate To Election</h3>
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
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="example-text-input">Election </label>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="example-text-input"><strong>{{strtoupper($election['name'])}}</strong></label>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="example-text-input">Candidate (User) <span class="required">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control" id="user_id" name="user_id">
                                            <option value="">--select official(users)--</option>
                                            @foreach($users as $user)
                                                <option value="{{$user['id']}}">{{strtoupper($user->profile->first_name.' '.$user->profile->last_name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary create-hover" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success create-hover" id="assign-btn"><i class="fa fa-check"></i> Assign</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Create New Student Modal -->



