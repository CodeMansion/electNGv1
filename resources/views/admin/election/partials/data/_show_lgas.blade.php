<option>--Select Local Govt--</option>
@foreach($lgas as $lga)
<option value="{{$lga['id']}}">{{$lga['name']}}</option>
@endforeach