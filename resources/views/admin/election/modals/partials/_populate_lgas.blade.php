@foreach($lgas as $p)
    <option value="{{$p['id']}}">{{strtoupper($p['name'])}}</option>
@endforeach
