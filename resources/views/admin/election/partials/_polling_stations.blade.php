<table id="sample_2" class="table table-striped table-vcenter table-condensed table-bordered">
    <thead>
        <tr>
            <th></th>
            <th>CENTRES</th>
            <td></td>
        </tr>
    </thead>
    <tbody>
        @php($count=1)
        @foreach($pollingUnits as $unit)
            <tr>
                <td>{{$count}}</td>
                <td>{{$unit['name']}}</td>
                <td></td>
            </tr>
        @php($count++)
        @endforeach
    </tbody>
</table>