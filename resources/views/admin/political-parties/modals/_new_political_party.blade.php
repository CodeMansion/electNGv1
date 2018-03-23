<!-- Create New Student Modal -->
<div id="modal">
    <div class="modal" id="new-party" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
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
                        <h5>Add New Political Party</h5>
                        <div class="form-group">
                            <label>Code <span class="required">*</span></label>
                            <input class='form-control' name="code" type="text" required>
                            <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                        </div>
                        <div class="form-group">
                            <label>Name <span class="required">*</span></label>
                            <input class='form-control' name="name" type="text" required>
                            <span style="font-size:13px;"><em>The <b>name</b> is the full meaning of the code.</em></span>
                        </div>
                        <div class="form-group">
                            <label>Description <span class="required"></span></label>
                            <textarea class='form-control' name="description" rows="6" required></textarea>
                            <span style="font-size:13px;"><em>The <b>description</b> is just a brief explanation of the political party.</em></span>
                        </div>
                        <div class="form-group">
                            <div style="padding: 5px;">
                                <label class="control-label">Logo <span class="required"> * </span></label><br/>
                                <div id="image_preview_logo" style="height:100px;width:100px;-webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);background-position:center center;background-size:cover;display:inline-block;"></div><br/>
                                <input type="file" name="logo" id="uploadLogo"/>
                            </div>
                            <div id="errorMessage_logo"></div>
                        </div>
                        <div class="form-group">
                            <button type="button" id="submit" class="create-hover btn btn-sm btn-primary">Add New Political Party</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary create-hover" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success create-hover" id="assign-btn"><i class="fa fa-check"></i> Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Create New Student Modal -->



