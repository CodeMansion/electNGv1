@extends('partials.app')

@section('content')
    <main id="main-container">
        <div class="content">
            <div class="row" style="">
                <div class="col-12 col-xl-12">
                    @include('partials.notifications')
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h2 class="block-title">
                                <i class="si si-feed"></i> Latest Submitted Results
                            </h2>
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
