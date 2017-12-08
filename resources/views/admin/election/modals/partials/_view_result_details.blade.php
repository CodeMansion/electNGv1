<h5><i class="si si-user"></i> User Information</h5><hr/>
<div class="form-group row">
    <div class="col-md-3">
        <img src="{{asset('images/avatar6.jpg')}}" height="180" width="180">
    </div>
    <div class="col-md-9 col-xl-9">
        <ul class="list-group push">
            <li class="list-group-item"><strong>FULL NAME: </strong> {{strtoupper($user->profile->first_name.' '.$user->profile->last_name)}}</li>
            <li class="list-group-item"><strong>SEX: </strong> </li>
            <li class="list-group-item"><strong>EMAIL: </strong>{{strtoupper($user->email)}}</li>
            <li class="list-group-item"><strong>PHONE: </strong>{{strtoupper($user->profile->phone)}}</li>
        </ul>
    </div>
</div>

<h5><i class="si si-flag"></i> Election Information</h5><hr/>
<div class="form-group row">
    <div class="col-md-12 col-xl-12">
        <ul class="list-group push">
            <li class="list-group-item"><strong>ELECTION NAME: </strong> {{strtoupper($election->name)}} <span class="badge badge-{{$election->status->class}}"><i class=""></i> {{$election->status->name}}</span></li>
            <li class="list-group-item"><strong>STATE: </strong>{{$election->state($resultInfo->state_id)}}</li>
            <li class="list-group-item"><strong>LOCAL GOVT AREA: </strong>{{$election->ward($resultInfo->lga_id)}}</li>
            <li class="list-group-item"><strong>WARD: </strong>{{$election->ward($resultInfo->ward_id)}}</li>
            <li class="list-group-item"><strong>POLLING STATION: </strong>{{$election->pollingCentres($resultInfo->polling_station_id)}}</li>
        </ul>
    </div>
</div>
<h5><i class="si si-flag"></i> Poll Details</h5><hr/>
<div class="form-group row">
    <div class="col-md-12 col-xl-12">
    <form action="{{URL::route('SubmitResult')}}" method="POST">{{csrf_field()}} {{method_field('PUT')}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ACCREDITED VOTERS</th>
                    <th>VOID VOTERS</th>
                    <th>CONFIRMED VOTERS</th>
                    @foreach($electionParties as $party)
                        <th><strong><?php echo strtoupper($party->code); ?></strong></th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <input type="hidden" name="lga_id" value="{{$resultInfo->lga_id}}">
                    <input type="hidden" name="state_id" value="{{$resultInfo->state_id}}">
                    <input type="hidden" name="ward_id" value="{{$resultInfo->ward_id}}">
                    <input type="hidden" name="polling_station_id" value="{{$resultInfo->polling_station_id}}">
                    <input type="hidden" name="election_id" value="{{$election->id}}">
                    <input type="hidden" name="passcode" value="{{$passcode}}"> 
                    @if($codeStatus == 1)
                        <td><input type="number" name="accr_voters" value="{{$pollingResult->accr_voters}}" class="form-control" required></td>
                        <td><input type="number" name="void_voters" value="{{$pollingResult->void_voters}}" class="form-control" required></td>
                        <td><input type="number" name="confirmed_voters" value="{{$pollingResult->confirmed_voters}}" class="form-control" required></td>
                        @foreach($electionParties as $party)
                            @php($code=strtolower($party['code']))
                            <td class="text-center">
                                <input type="number" name="{{$code}}" value="{{$pollingResult->$code}}" class="form-control" required>
                            </td>
                        @endforeach
                    @elseif($codeStatus == 2)
                        <td>{{$pollingResult->accr_voters}}</td>
                        <td>{{$pollingResult->void_voters}}</td>
                        <td>{{$pollingResult->confirmed_voters}}</td>
                        @foreach($electionParties as $party)
                            @php($code=strtolower($party['code']))
                            <td class="text-center">
                                {{$pollingResult->$code}}
                            </td>
                        @endforeach
                    @endif
                </tr>
            </tbody>
        </table>
        @if($codeStatus == 1)
        <button type="submit" class="btn btn-sm btn-success create-hover"><i class="fa fa-save"></i> SUBMIT POLL</button>
        @endif
    </form>
    </div>
</div>