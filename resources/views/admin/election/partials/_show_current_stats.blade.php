<div class="row">
    <!-- <div class="col-md-2">
        <div style="overflow-y: scroll; height: 900px;">
            @foreach($resultSummary as $key => $value)
                <div class="col-12 ">
                    <a class="block block-link-shadow text-right" href="javascript:void(0)">
                        <div class="block-content block-content-full clearfix">
                            <div class="float-left mt-10 d-none d-sm-block">
                                <img src=<?php echo asset("uploads/party-logo/$key.jpg"); ?> width="50px" height="50px" alt="">
                            </div>
                            <div class="font-size-h3 font-w600">{{$value}}</div>
                            <div class="font-size-h4 font-w600 text-uppercase text-muted">{{$key}}</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div> -->
    <div class="col-md-12">
        <div class="row">
            <div class="col-12 col-xl-12">
                @if($latest)
                    <table class="table table-striped table-bordered" data-href="tooltip" title="Displaying latest submitted result.">
                        <thead>
                            <tr style="background-color: #2C3E50;color:white;">
                                <th>State</th>
                                <th>Constituency</th>
                                <th>LGA</th>
                                <th>Ward</th>
                                <th>Polling Unit</th>
                                <th>Date</th>
                                @foreach($parties as $party)
                                <th>{{ strtoupper($party['code']) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="background-color: #ECF0F1;color:black;">
                                <td>{{ state($latest->state_id) }}</td>
                                <td>{{ constituency($latest->constituency_id) }}</td>
                                <td>{{ lga($latest->lga_id) }}</td>
                                <td>{{ ward($latest->ward_id) }}</td>
                                <td>{{ centre($latest->polling_station_id) }}</td>
                                <td>{{ $latest->created_at}}</td>
                                @foreach($parties as $party)
                                    @php($code = strtolower($party['code']))
                                    <td style="background-color: #D0ECE7;color:black;">{{ $latest->$code }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                @else 
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="block">
                    <div class="block-content">
                        <div class="row">
                            <div class="col-12">
                                {!! $barChart->render() !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {!! $areaChart->render() !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                {!! $donutChart->render() !!}
                            </div>
                            <div class="col-6">
                                {!! $pieChart->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>