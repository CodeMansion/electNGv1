<!-- Create New Student Modal -->
<div class="modal" id="new-election" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                        <em>Please follow the instructions and fill the form carefully. Note that fields make with asterisk (<span class="required">*</span>) are compulsory.</em>
                    </div><hr/>
                    <div class="card card-body">
                    <form action="{{URL::route('Election.New')}}" method="POST">{{csrf_field()}}
                        <div class="col-sm-12">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="example-text-input">Name <span class="required">*</span></label>
                                    <input type="text" class="form-control form-input" name="name" required>
                                    <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="example-text-input">Description <span class="required"></span></label>
                                    <input type="text" class="form-control form-input" name="description">
                                    <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="example-text-input">Start Date <span class="required">*</span></label>
                                    <input type="text" class="js-datepicker form-control form-input" id="example-datepicker1" name="start_date" 
                                    data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy">
                                    <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="example-text-input">End Date <span class="required">*</span></label>
                                    <input type="text" class="js-datepicker form-control form-input" id="example-datepicker1" name="end_date" 
                                    data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy">
                                    <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="example-text-input">Type of Election <span class="required">*</span></label>
                                    <select name="type" class="form-control">
                                        <option value="">--select election type--</option>
                                        @foreach($electionTypes as $type)
                                            <option value="{{$type['id']}}">{{$type['name']}}</option>
                                        @endforeach
                                    </select>
                                    <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                                </div>
                                <div class="col-md-6" id="view-states" style="display: none;">
                                    <label for="example-text-input">Select States <span class="required">*</span></label>
                                    <select class="form-control" name="state_id" style="width: 100%;">
                                        <option value="">--select state--</option>
                                        @foreach($states as $state)
                                            <option value="{{$state['id']}}">{{strtoupper($state['name'])}}</option>
                                        @endforeach
                                    </select>
                                    <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6" id="const" style="display: none;">
                                    <label for="example-select2-multiple">Select Constituency <span class="required">*</span></label>
                                    <select class="form-control" name="constituency_id" id="view-const">
                                    </select>
                                    <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                                </div>
                                <div class="col-md-6" id="lga" style="display: none;">
                                    <label for="example-select2-multiple">Select LGA<span class="required">*</span></label>
                                    <select class="form-control" name="lga_id" style="width: 100%;" id="view-lga">
                                        <option value="0">-- --</option>
                                    </select>
                                    <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                                </div>
                            </div>
                            <div class="form-group row" id="view-parties" style="display: none;">
                                <div class="col-md-6">
                                    <label for="example-text-input">Select Parties <span class="required">*</span></label>
                                    <select class="js-select2 form-control" id="example2-select2" name="party[]" style="width: 100%;" data-placeholder="Choose many.." multiple>
                                        <option value="">--select political parties--</option>
                                        @foreach($politicalParties as $party)
                                            <option value="{{$party['id']}}">{{$party['code']}}</option>
                                        @endforeach
                                    </select>
                                    <span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary create-hover" data-dismiss="modal">Close</button>
                <button type="submit" id="submit-election" class="btn btn-success create-hover"><i class="fa fa-check"></i> Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- END Create New Student Modal -->


