<div id="new-election" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><span class="icon-layers font-green"></span> Create Election</h4>
            </div>
            <div class="modal-body">
                <div class="info-well">
                    <em>Please follow the instructions and fill the form carefully. Note that fields make with asterisk (<span class="required">*</span>) are compulsory.</em>
                </div><hr/>
                <div id="ErrorMsg"></div><br/>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <label >Name <span class="required">*</span></label>
                                    <input type="text" id="name" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Description <span class="required"></span></label>
                                    <input type="text" class="form-control" name="description">
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="example-text-input">Start Date <span class="required">*</span></label>
                                    <input type="text" class="js-datepicker form-control form-input" id="example-datepicker1" name="start_date" 
                                    data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy">
                                </div>
                                <div class="col-md-6">
                                    <label for="example-text-input">End Date <span class="required">*</span></label>
                                    <input type="text" class="js-datepicker form-control form-input" id="example-datepicker1" name="end_date" 
                                    data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy">
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Type of Election <span class="required">*</span></label>
                                    <select name="type" class="form-control">
                                        <option value="">--select election type--</option>
                                        @foreach($electionTypes as $type)
                                            <option value="{{$type['id']}}">{{$type['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6" id="view-states" style="display:none;">
                                    <label>Select States <span class="required">*</span></label>
                                    <select class="form-control" name="state_id" style="width: 100%;">
                                        <option value="">--select state--</option>
                                        @foreach($states as $state)
                                            <option value="{{$state['id']}}">{{strtoupper($state['name'])}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-md-6" id="const" style="display: none;">
                                    <label>Select Constituency <span class="required">*</span></label>
                                    <select class="form-control" name="constituency_id" id="view-const" multiple>
                                    </select>
                                </div>
                                <div class="col-md-6" id="lga" style="display: none;">
                                    <label for="example-select2-multiple">Select LGA<span class="required">*</span></label>
                                    <select class="form-control" name="lga_id" style="width: 100%;" id="view-lga">
                                        <option value="0">-- --</option>
                                    </select>
                                </div>
                            </div><br/>
                            <div class="row" id="view-parties" style="display: none;">
                                <div class="col-md-6">
                                    <label>Select Parties <span class="required">*</span></label>
                                    <select class="js-select2 form-control" id="example2-select2" name="party" style="width: 100%;" data-placeholder="Choose many.." multiple>
                                        <option value="">--select political parties--</option>
                                        @foreach($politicalParties as $party)
                                            <option value="{{$party['id']}}">{{$party['code']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><br/>
                            <div class="form-group">
                                <button type="button" id="submit-election" class="btn btn-success create-hover"><i class="fa fa-check"></i> Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


