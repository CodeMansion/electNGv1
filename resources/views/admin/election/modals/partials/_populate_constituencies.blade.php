@foreach($constituency as $c)
    <option value="{{$c['id']}}">{{strtoupper($c['name'])}}</option>
@endforeach
