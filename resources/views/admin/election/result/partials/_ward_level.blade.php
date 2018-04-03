<div class="tab-pane" id="ward">
    <div id="table-report-ward">
        <table class="table table-striped table-hover table-bordered" id="sample_">
            <thead>
                <tr>
                    <th>STATE</th>
                    <th>CONSTITUENCY</th>
                    <th>LGA</th>
                    <th>WARD</th>
                    <th>ACCR VOTERS</th>
                    <th>CONF VOTERS</th>
                    <th>VOID VOTERS</th>
                    @foreach($parties as $party)
                    @php($star = \App\ElectionParty::where('election_id',$election['id'])->where('political_party_id',$party['id'])->first())
                        @if($star['is_star_party'] == true)
                        <th style="background-color: #00B698;color:white;">{{ strtoupper($party['code']) }}</th>
                        @else 
                        <th>{{ strtoupper($party['code']) }}</th>
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php($count=1)
                @foreach($wards as $code)
                    @php($accr_votes = 0)
                    @php($conf_votes = 0)
                    @php($void_votes = 0)
                    @foreach($votes->where('ward_id',$code->ward_id) as $vote)
                        @php($accr_votes += $vote->accr_voters)
                        @php($conf_votes += $vote->confirmed_voters)
                        @php($void_votes += $vote->void_voters)
                    @endforeach
                    <tr>
                        <td>{{ state($code->state_id) }}</td>
                        <td>{{ constituency($code->constituency_id) }}</td>
                        <td>{{ lga($code->lga_id) }}</td>
                        <td>{{ ward($code->ward_id) }}</td>
                        <td>{{ $accr_votes }}</td>
                        <td>{{ $conf_votes }}</td>
                        <td>{{ $void_votes }}</td>
                        @foreach($parties as $party)
                        @php($star = \App\ElectionParty::where('election_id',$election['id'])->where('political_party_id',$party['id'])->first())
                        @php($accumulator = 0)
                        @foreach($votes->where('ward_id',$code->ward_id) as $vote)
                            @if($party['id'] == $vote->political_party_id) 
                                @php($accumulator += (int)$vote->votes)
                            @endif 
                        @endforeach
                        @if($star['is_star_party'] == true)
                        <th style="background-color: #00B698;color:white;">{{ $accumulator }}</th>
                        @else 
                        <th>{{ $accumulator }}</th>
                        @endif
                        @endforeach
                    </tr>
                @php($count++)
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="chart-report-ward" style="display:none;"></div>
</div>