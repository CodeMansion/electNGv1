<div class="tab-pane" id="lga">
    <div id="table-report-lga">
        <table class="table table-striped table-hover table-bordered" id="sample_">
            <thead>
                <tr>
                    <th>STATE</th>
                    <th>CONSTITUENCY</th>
                    <th>LGA</th>
                    <th>ACCR VOTERS</th>
                    <th>CONF VOTERS</th>
                    <th>VOID VOTERS</th>
                    <th>METRIC</th>
                    <th>TOTAL VOTES</th>
                </tr>
            </thead>
            <tbody>
                @php($count=1)
                @foreach($lgas as $code)
                    @php($accr_votes = 0)
                    @php($conf_votes = 0)
                    @php($void_votes = 0)
                    @foreach($votes->where('lga_id',$code->lga_id) as $vote)
                        @php($accr_votes += $vote->accr_voters)
                        @php($conf_votes += $vote->confirmed_voters)
                        @php($void_votes += $vote->void_voters)
                    @endforeach
                    <tr>
                        <td>{{ state($code->state_id) }}</td>
                        <td>{{ constituency($code->constituency_id) }}</td>
                        <td>{{ lga($code->lga_id) }}</td>
                        <td>{{ $accr_votes }}</td>
                        <td>{{ $conf_votes }}</td>
                        <td>{{ $void_votes }}</td>
                        @php($values = [])
                        @foreach($parties as $party)
                        @php($star = \App\ElectionParty::where('election_id',$election['id'])->where('political_party_id',$party['id'])->first())
                        @php($accumulator = 0)
                        @php($max = 0)
                        @php($default = 0)
                        @foreach($votes->where('lga_id',$code->lga_id) as $vote)
                            @if($party['id'] === $vote->political_party_id) 
                                @php($accumulator += (int)$vote->votes)
                            @endif
                        @endforeach
                        @foreach($votes->where('lga_id',$code->lga_id) as $vote)
                            @if($star['political_party_id'] === $vote->political_party_id) 
                                @php($default += (int)$vote->votes)
                            @endif
                        @endforeach
                        @php(array_push($values, $accumulator))
                        @endforeach
                        @php($max = max($values))
                        @if($default >= $max)
                            <td><span class="badge badge-success">WIN</span></td>
                        @else 
                            <td><span class="badge badge-danger">LOSE</span></td>
                        @endif
                        <td>{{ $default }}</td>
                    </tr>
                @php($count++)
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="chart-report-lga" style="display:none;"></div>
</div>