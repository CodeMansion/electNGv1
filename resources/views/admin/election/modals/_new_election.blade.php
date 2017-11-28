<!-- Create New Student Modal -->
<div class="modal" id="new-election" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title"><i class="si si-bar-chart"></i> Create New Election</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option create-hover" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <div class="info-well">
                        <em>Please note that the field marked with asterik (<span class="required">*</span>) are compulsory.</em>
                    </div><hr/>
                    <div class="card card-body">
                        <div class="col-sm-12">
                            <div class="form-group row">
                                <label for="example-text-input">Name <span class="required">*</span></label>
                                <input type="text" class="form-control form-input" name="name" placeholder="Name" required>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">Description <span class="required">*</span></label>
                                <textarea rows="3" class="form-control" name="description" required placeholder="Brief Description"></textarea>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">Start Date <span class="required">*</span></label>
                                <input type="text" class="js-datepicker form-control form-input" id="example-datepicker1" name="start_date" 
                                data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy">
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input">End Date <span class="required">*</span></label>
                                <input type="text" class="js-datepicker form-control form-input" id="example-datepicker1" name="end_date" 
                                data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy">
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary create-hover" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success create-hover" id="submit"><i class="fa fa-check"></i> Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- END Create New Student Modal -->


