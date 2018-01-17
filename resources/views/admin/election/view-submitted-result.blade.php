@extends('partials.app')

@section('content')
    <main id="main-container">
        <div class="content container">
            <div class="row" style="">
                <div class="col-12 col-xl-12">
                    @include('partials.notifications')
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">
                                <i class="si si-feed"></i> {{$election['name']}} 
                                <span class="badge badge-{{$election->status->class}}"><i class=""></i> {{$election->status->name}}</span>
                            </h3>
                            @can('super_admin')
                                <form action="{{URL::route('Election.ChangeStatus')}}" method="POST">{{csrf_field()}}
                                    <input type="hidden" name="election_id" value="{{$election['slug']}}">
                                    @if($election['election_status_id'] == 1)
                                        <input type="hidden" name="type" value="begin">
                                        <button class="btn btn-sm btn-default create-hover" id="begin" type="submit"><i class="si si-power"></i> Start Election</button> 
                                    @elseif($election['election_status_id'] == 2)
                                        <input type="hidden" name="type" value="end">
                                        <button class="btn btn-sm btn-warning create-hover" id="end" type="submit"><i class="si si-lock"></i> End Election</button>
                                    @elseif($election['election_status_id'] == 3)
                                        <button class="btn btn-sm btn-info create-hover" id="details" type="button"><i class="si si-bar-chart"></i> View Election Summary</button>
                                    @endif
                                </form>
                            @endcan
                        </div>
                        <div class="block-content">
                            <p><a href="{{URL::route('Election.ViewOne',$election['slug'])}}"><i class="si si-arrow-left"></i> Return Back</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="block">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr style="background-color: #2C3E50;color:white;">
                                    <th>S/N</th>
                                    <th>STATE</th>
                                    <th>CONSTITUENCY</th>
                                    <th>LGA</th>
                                    <th>WARD</th>
                                    <th>POLLING STATION</th>
                                    <th>Accredited Voters</th>
                                    <th>Confirmed Voters</th>
                                    <th>Void Voters</th>
                                    @foreach($parties as $party)
                                    <th style="background-color: #566573;color:white;">{{ strtoupper($party['code']) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php($count=1)
                                @foreach($results as $code)
                                    <tr>
                                        <td>{{$count}}</td>
                                        <td>{{state($code->state_id)}}</td>
                                        <td>{{constituency($code->constituency_id)}}</td>
                                        <td>{{lga($code->lga_id)}}</td>
                                        <td>{{ward($code->ward_id)}}</td>
                                        <td>{{centre($code->polling_station_id)}}</td>
                                        <td>{{ $code->accr_voters}}</td>
                                        <td>{{ $code->confirmed_voters }}</td>
                                        <td>{{ $code->void_voters }}</td>
                                        @foreach($parties as $party)
                                            @php($c = strtolower($party['code']))
                                            <td style="background-color: #ECF0F1;color:black;">{{ $code->$c }}</td>
                                        @endforeach
                                    </tr>
                                    @php($count++)
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('extra_script')
    <script>
        jQuery(function () {
            // Init page helpers (BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
            Codebase.helpers(['datepicker', 'slick', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']); 
        });
    </script>
@endsection
