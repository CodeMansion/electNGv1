<label for="example-select2-multiple">Select Multiple LGAs <span class="required">*</span></label>
<select class="js-select2 form-control" id="example2-select2" name="lga_id[]" style="width: 100%;" data-placeholder="Choose many.." multiple>
    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
    @foreach($lgas as $p)
        <option value="{{$p['id']}}">{{$p['name']}}</option>
    @endforeach
</select>
<span style="font-size:13px;"><em>The <b>code</b> is what is mostly used.</em></span>