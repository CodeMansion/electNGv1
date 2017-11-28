<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">
            Registered Political Party
            <button class="btn btn-sm btn-secondary create-hover pull-right" id="viewAsnForm" data-toggle="tooltip" title="Assign parties to election." type="button"><i class="fa fa-plus"></i> </button>
        </h3>
    </div>
    <div class="block-content" data-toggle="slimscroll">
        @if(count($electionParties) < 1)
            <div class="danger-well">
                <em>There are no party assigned to this election</em>
            </div><br/>
            <div id="assignParties" style="display:none;">
                <form>
                    <div class="form-group">
                        <label>Select Multiple Parties</label>
                        <select class="js-select2 form-control" id="example-select2-multiple" name="party" style="width: 100%;" data-placeholder="Choose many.." multiple>
                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            @foreach($politicalParties as $p)
                                <option value="{{$p['id']}}">{{$p['code']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="button" id="submit" class="btn btn-sm btn-success create-hover"><i class="si si-cursor-move"></i> Submit</button>
                        <button type="button" id="cls" class="btn btn-sm btn-danger create-hover"><i class="fa fa-close"></i> Close</button>
                    </div>
                </form>
            </div>
        @else
            <table class="table table-striped">
                <thead>
                    <th>S/N</th>
                    <th>CODE</th>
                    <th>STATUS</th>
                </thead>
                <tbody>
                    @php($index=1)
                    @foreach($electionParties as $party)
                        <tr>
                            <td>{{$index}}</td>
                            <td>{{$party['code']}}</td>
                            <td>{{$party['status']}}</td>
                        </tr>
                    @php($index++)
                    @endforeach
                </tbody>
            </table>
            <div id="assignParties" style="display:none;">
                <form>
                    <div class="form-group">
                        <label>Select Multiple Parties</label>
                        <select class="js-select2 form-control" id="example-select2-multiple" name="party" style="width: 100%;" data-placeholder="Choose many.." multiple>
                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            @foreach($politicalParties as $p)
                                <option value="{{$p['id']}}">{{$p['code']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="button" id="submit" class="btn btn-sm btn-success create-hover"><i class="si si-cursor-move"></i> Submit</button>
                        <button type="button" id="cls" class="btn btn-sm btn-danger create-hover"><i class="fa fa-close"></i> Close</button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>