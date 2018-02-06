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
                                <i class="si si-feed"></i> Recent Activity Logs
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
                        @if(count($logs) < 1)
                            <div class="danger-well">There are no activity logs yet..</div>
                        @else
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr style="background-color: #2C3E50;color:white;">
                                        <th>S/N</th>
                                        <th>USER</th>
                                        <th>LOCATION</th>
                                        <th>IP</th>
                                        <th>ACTION</th>
                                        <th>TIME</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($count=1)
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td>{{$log->user-name}}</td>
                                            <td>{{$log->location}}</td>
                                            <td>{{$log->ip_address}}</td>
                                            <td>{{$log->action}}</td>
                                            <td>{{$log->created_at->diffForHumans()}}</td> <
                                            <td>{{ $code->void_voters }}</td>
                                        </tr>
                                        @php($count++)
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
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
