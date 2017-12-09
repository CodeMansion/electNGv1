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
                    </div>
                    <button class="btn btn-sm btn-primary create-hover add_role" type="button">Add New</button>
                    <button class="btn btn-sm btn-default create-hover show_role" type="button">View Permission</button>
                    <hr/>
                    <div class="card card-body add">
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
                    <table class="table table-condensed table-hover table-striped role_table">
                        <thead>
                            <tr>
                                <th width="50"><input type="checkbox" name="" value=""></th>
                                <th width="50"></th>
                                <th>Name</th>
                                <th>Label</th>
                            </td>
                        </thead>
                        <tbody>
                            @forelse($permissions as $perm)
                                <tr>
                                    <td><input type="checkbox" name="" value=""></td>
                                    <td><img src="{{ asset('images/default.png') }}" width="26" height="26" /></td>
                                    <td class="user-edit">
                                        <a href="">{{$perm['name']}}</a><br/>
                                        <span id="polling-view" style="display:none;color:grey;" style="font-size: 12px;"> | </span>
                                    </td>
                                    <td>{{$perm->label}}</td>
                                    <td>
                                        <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#edit-permission{{$perm['id']}}" ><i class="fa fa-edit"></i></a>
                                        <a href="#" class="label label-danger" id="deleteperm" data-id="{{$perm->id}}"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                            @empty
                            <tr colspan="4">
                                <div class="danger-well">
                                    <em>There are no roles on this system.</em>
                                </div>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
