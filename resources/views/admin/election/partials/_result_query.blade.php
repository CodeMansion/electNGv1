<p>
    @can('super_admin')
    <a href="{{URL::route('Dashboard')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a> |
    <a href="{{URL::route('Election.View')}}"><i class="si si-arrow-left"></i> Elections</a> |
    @endcan
    @if($election['election_type_id'] == 1)
        <label class="create-hover"><input type="radio" checked class="create-hover" id="general" name="type" value="general"> General Collation | </label> 
        <label class="create-hover"><input type="radio" class="create-hover" id="lga" name="type" value="lga"> Local Govt Result | </label> 
        <label class="create-hover"><input type="radio" class="create-hover" id="ward" name="type" value="ward"> Ward Result | </label>
        <label class="create-hover"><input type="radio" class="create-hover" id="unit" name="type" value="station"> Polling Station Result |</label>
        <label></label>
    @elseif($election['election_type_id'] == 2)
        <label class="create-hover"><input type="radio" checked class="create-hover" id="general" name="type" value="general"> General Collation | </label> 
        <label class="create-hover"><input type="radio" class="create-hover" id="constituency" name="type" value="constituency"> Constituency | </label> 
        <label class="create-hover"><input type="radio" class="create-hover" id="lga" name="type" value="lga"> Local Govt Result | </label> 
        <label class="create-hover"><input type="radio" class="create-hover" id="ward" name="type" value="ward"> Ward Result | </label>
        <label class="create-hover"><input type="radio" class="create-hover" id="unit" name="type" value="station"> Polling Station Result |</label>
        <label></label>
    @elseif($election['election_type_id'] == 3)
        <label class="create-hover"><input type="radio" checked class="create-hover" id="general" name="type" value="general"> General Collation | </label> 
        <label class="create-hover"><input type="radio" class="create-hover" id="lga" name="type" value="lga"> Local Govt Result | </label> 
        <label class="create-hover"><input type="radio" class="create-hover" id="ward" name="type" value="ward"> Ward Result | </label>
        <label class="create-hover"><input type="radio" class="create-hover" id="unit" name="type" value="unit"> Polling Station Result |</label>
        <label></label>
    @elseif($election['election_type_id'] == 4)
        <label class="create-hover"><input type="radio" checked class="create-hover" id="general" name="type" value="general"> General Collation | </label> 
        <label class="create-hover"><input type="radio" class="create-hover" id="ward" name="type" value="ward"> Ward Result | </label>
        <label class="create-hover"><input type="radio" class="create-hover" id="unit" name="type" value="station"> Polling Station Result |</label>
        <label></label>
    @endif
</p>

@if($election['election_type_id'] == 1)

@elseif($election['election_type_id'] == 2)
<!-- views for senetorial level election -->
<div class="row" id="view-by-const-first-governor" style="display: none;">
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="const_id_first_governor">
                <option>--Select Constituency--</option>
                @foreach($constituency as $lga)
                <option value="{{$lga['id']}}">{{$lga['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row" id="view-by-const-second-governor" style="display: none;">
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="const_id_second_governor">
                <option>--Select Constituency--</option>
                @foreach($constituency as $lga)
                <option value="{{$lga['id']}}">{{$lga['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="lga_id_first_governor">
            </select>
        </div>
    </div>
</div>
<div class="row" id="view-by-ward-governor" style="display: none;">
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="const_id_third_governor">
                <option>--Select Constituency--</option>
                @foreach($constituency as $lga)
                <option value="{{$lga['id']}}">{{$lga['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="lga_id_second_governor">
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="ward_id_first_governor">
            </select>
        </div>
    </div>
</div>
<div class="row" id="view-by-unit-governor" style="display: none;">
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="const_id_fouth_governor">
                <option>--Select Constituency--</option>
                @foreach($constituency as $lga)
                <option value="{{$lga['id']}}">{{$lga['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="lga_id_fouth_governor">
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="ward_id_second_governor">
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="unit_id_governor">
            </select>
        </div>
    </div>
</div>
@elseif($election['election_type_id'] == 3)
<!-- views for senetorial level election -->
<div class="row" id="view-by-lga-senatorial" style="display: none;">
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="lga_id_first_senatorial">
                <option>--Select Local Govt--</option>
                @foreach($lgas as $lga)
                <option value="{{$lga['id']}}">{{$lga['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row" id="view-by-ward-senatorial" style="display: none;">
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="lga_id_second_senatorial">
                <option>--Select Local Govt--</option>
                @foreach($lgas as $lga)
                <option value="{{$lga['id']}}">{{$lga['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="ward_id_senatorial">
            </select>
        </div>
    </div>
</div>
<div class="row" id="view-by-unit-senatorial" style="display: none;">
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="lga_id_show_senatorial">
                <option>--Select Local Govt--</option>
                @foreach($lgas as $lga)
                <option value="{{$lga['id']}}">{{$lga['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="ward_id_show_senatorial">
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="unit_id_senatorial">
            </select>
        </div>
    </div>
</div>
<!-- end of senetorial level views -->
@elseif($election['election_type_id'] == 4)
<!-- views for local government level election -->
<div class="row" id="view-by-ward-local" style="display: none;">
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="ward_id_local">
                <option>--Select Ward--</option>
                @foreach($wards as $ward)
                <option value="{{$ward['id']}}">{{$ward['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row" id="view-by-unit-local" style="display: none;">
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="ward_id_show">
                <option>--Select Ward--</option>
                @foreach($wards as $ward)
                <option value="{{$ward['id']}}">{{$ward['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" name="unit_id_local">
            </select>
        </div>
    </div>
</div>
<!-- end of local government level views -->
@endif