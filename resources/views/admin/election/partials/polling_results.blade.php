<table id="sample_2" class="table table-striped table-vcenter table-condensed table-bordered">
    <thead>
        <tr class="text-center">
            <th>LGA</th>
            <th>WARD</th>
            <th>POLLING CENTRES</th>
            <th>ACCR VOTERS</th>
            <th>VOID VOTERS</th>
            <th>CONFIRMED VOTERS</th>
            <th>STATUS</th>
            @foreach($electionParties as $party)
                <th><strong><?php echo strtoupper($party->code); ?></strong></th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php($count=1)
        @foreach($pollingResults as $result)
            <tr>
                <td>{{$election->lga($result->lga_id)}}</td>
                <td>{{$election->ward($result->ward_id)}}</td>
                <td>{{$election->centre($result->polling_station_id)}}</td>
                <td class="text-center">{{$result->accr_voters}}</td>
                <td class="text-center">{{$result->void_voters}}</td>
                <td class="text-center">{{$result->confirmed_voters}}</td>
                <td class="text-center">
                    @if($result->status == 1)
                        <span class="badge badge-danger">Unprocessed</span>
                    @elseif($result->status == 2)
                        
                    @endif
                </td>
                @foreach($electionParties as $party)
                    @php($code=strtolower($party['code']))
                    <td class="text-center"><strong><?php echo $result->$code; ?></strong></td>
                @endforeach
            </tr>
        @php($count++)
        @endforeach
    </tbody>
</table>