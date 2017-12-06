<!-- Create New Student Modal -->
<div class="modal" id="edit-user{{$ward->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
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
                    <div class="warning-well">
                        <em>Please note that the field marked with asterik (<span class="required">*</span>) are compulsory.</em>
                    </div><hr/>
                    <div class="card card-body">
                        <div class="col-sm-12">
                            <input type="hidden" class="form-control form-input" value="{{ $ward->id }}" id="id{{$index}}" placeholder="Username" required>
                            <div class="form-group row">
                                <label for="example-text-input">Name <span class="required">*</span></label>
                                <input type="text" class="form-control form-input" value="{{ $ward->name }}" id="name{{$index}}" placeholder="Name" required>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">State<span class="required">*</span></label>
                                <select name="state" id="state{{$index}}" class="form-control form-input" required>
                                    <option value="{{$ward->state->id}}">{{$ward->state->name}}</option>
                                    <option value="">--select State--</option>
                                    @foreach($states as $state)
                                        <option value="{{$state['id']}}">{{$state['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">Local Govt.<span class="required">*</span></label>
                                <select class="form-control form-input" name="local" id="local{{$index}}" required>
                                    <option value="{{$ward->lga->id}}">{{$ward->lga->name}}</option>
                                </select>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary create-hover" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success create-hover" id="updateWard{{$index}}"><i class="fa fa-check"></i> Update</button>
            </div>
        </div>
    </div>
</div>

