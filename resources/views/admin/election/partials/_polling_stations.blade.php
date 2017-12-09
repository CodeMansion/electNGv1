<table id="sample_2" class="table table-striped table-vcenter table-condensed table-bordered">
    <thead>
        <tr>
            <th></th>
            <th>LOCAL GOVT</th>
            <th>WARDS</th>
            <th>POLLING CENTRES</th>
            <th>OFFICIALS(Users)</th>
            <td></td>
        </tr>
    </thead>
    <tbody>
        @php($count=1)
        @foreach($pollingUnits as $unit)
            <tr>
                <td>{{$count}}</td>
                <td>{{$election->lga($unit->lga_id)}}</td>
                <td>{{$election->ward($unit->ward_id)}}</td>
                <td>{{$election->pollingCentres($unit->polling_station_id)}}</td>
                <td>
                    @if($unit->user_id == NULL)
                        <span class="badge badge-warning"> No Officail</span>
                    @else
                        <a href="javascript:void(0);" data-toggle="modal" data-target=""><i class="si si-user"></i> {{$election->pollingUsers($unit->user_id)}}</a>
                    @endif
                </td>
                <td>
                    @if($election['election_status_id'] == 4)

                    @elseif($election['election_status_id'] == 2 || $election['election_status_id'] == 1)
                        <button type="button" class="btn-block-option create-hover" data-toggle="modal" data-target="#assignUsers{{$unit->id}}"><i class="si si-link"></i></button> 
                        | <button type="button" class="btn-block-option create-hover" data-toggle="modal" data-target=""><i class="si si-close"></i></button>
                    @elseif($election['election_status_id'] == 3)
                        <button type="button" class="btn-block-option create-hover" data-toggle="modal" data-target="#assignUsers{{$unit->id}}"><i class="si si-link"></i></button> 
                    @endif
                </td>
            </tr>
        @php($count++)
        @endforeach
    </tbody>
</table>