<table id="sample_2" class="table table-striped table-vcenter table-condensed table-bordered">
    <thead>
        <tr class="text-center">
            <th>S/N</th>
            <th>LGA</th>
            <th>WARD</th>
            <th>STATUS</th>
            <th>POLLING CENTRES</th>
            <th>ACCR VOTERS</th>
            <th>VOID VOTERS</th>
            <th>CONFIRMED VOTERS</th>
            @foreach($electionParties as $party)
                <th><strong><?php echo strtoupper($party->code); ?></strong></th>
            @endforeach
            @if($election['election_status_id'] == 3)
                <th></th>
            @endif
        </tr>
    </thead>
    <tbody>
        @php($count=1)
        @foreach($pollingResults as $result)
            <tr>
                <td>{{$count}}</td>
                <td>{{$election->lga($result->lga_id)}}</td>
                <td>{{$election->ward($result->ward_id)}}</td>
                <td>
                    {{str_limit($election->centre($result->polling_station_id), 25)}} 
                    <span class="create-hover" data-toggle="tooltip" title="{{$election->centre($result->polling_station_id)}}">
                    <i class="si si-eye"></i></span>
                </td>
                <td class="text-center">
                    @if($result->status == 1)
                        <span class="badge badge-danger">Unprocessed</span>
                    @elseif($result->status == 2)
                        <span class="badge badge-success">Processed</span>
                    @endif
                </td>
                <td class="text-center">{{$result->accr_voters}}</td>
                <td class="text-center">{{$result->void_voters}}</td>
                <td class="text-center">{{$result->confirmed_voters}}</td>
                @foreach($electionParties as $party)
                    @php($code=strtolower($party['code']))
                    <td class="text-center"><strong><?php echo $result->$code; ?></strong></td>
                @endforeach
                @if($election['election_status_id'] == 3)
                    <td>
                        <button type="button" class="btn-block-option create-hover" data-toggle="modal" data-target="#submitResult{{$result->id}}"><i class="si si-hourglass"></i></button>
                    </td>
                @endif
            </tr>
            
        @php($count++)
        @endforeach
    </tbody>
</table>