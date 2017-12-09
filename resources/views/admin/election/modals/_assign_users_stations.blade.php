<!-- Create New Student Modal -->
<div id="modal">
    <div class="modal" id="assignUsers{{$unit->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title"><i class="si si-users"></i> Assign Users to Polling Stations</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option create-hover" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                    @if($election['election_status_id'] == 3)
                        <div class="warning-well">
                            <em>Election is active. You cannot assign user to this polling station right now.</em>
                        </div><hr/>
                    @else
                        <div class="info-well">
                            <em>Please follow the instructions and fill the form carefully. Note that fields make with asterisk (<span class="required">*</span>) are compulsory.</em>
                        </div><hr/>
                        <div class="card card-body">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="example-text-input">State </label>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="example-text-input"><strong>{{strtoupper(config('constants.ACTIVE_STATE_NAME'))}}</strong></label>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="example-text-input">Local Govt Area </label>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="example-text-input"><strong>{{$election->lga($unit->lga_id)}}</strong></label>
                                        <input type="hidden" id="lga_id{{$index}}" value="{{$unit->lga_id}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="example-text-input">Ward </label>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="example-text-input"><strong>{{$election->ward($unit->ward_id)}}</strong></label>
                                        <input type="hidden" id="ward_id{{$index}}" value="{{$unit->ward_id}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="example-text-input">Polling Centre </label>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="example-text-input"><strong>{{$election->pollingCentres($unit->polling_station_id)}}</strong></label>
                                        <input type="hidden" id="polling_unit_id{{$index}}" value="{{$unit->polling_station_id}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="example-text-input">Official (User) <span class="required">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control" id="user_id{{$index}}" name="user_id">
                                            <option value="">--select official(users)--</option>
                                            @foreach($users as $user)
                                                <option value="{{$user['id']}}">{{strtoupper($user->profile->first_name.' '.$user->profile->last_name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
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



