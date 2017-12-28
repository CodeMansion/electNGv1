<option>--Select Ward --</option>
@foreach($wards as $ward)
<option value="{{$ward['id']}}">{{$ward['name']}}</option>
@endforeach