<option>--Select Polling Station--</option>
@foreach($units as $unit)
<option value="{{$unit['id']}}">{{$unit['name']}}</option>
@endforeach