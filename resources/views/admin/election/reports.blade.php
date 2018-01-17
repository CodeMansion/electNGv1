@extends('partials.app')

@section('content')
    <main id="main-container">
        <!-- Page Content -->
        <div class="content container">
            <div class="row" style="">
                <div class="col-12 col-xl-12">
                    @include('partials.notifications')
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">
                                <i class="si si-feed"></i> Election Reports 
                                <span class="badge badge-{{$election->status->class}}"><i class=""></i> {{$election->status->name}}</span>
                            </h3>
                            <button class="btn btn-sm btn-alt-secondary create-hover" style="margin-right: 5px;" type="button"><i class="fa fa-print"></i> Print</button>
                            <button class="btn btn-sm btn-alt-secondary create-hover" style="margin-right: 5px;" type="button"><i class="fa fa-file-pdf-o"></i> Export PDF</button>
                            <button class="btn btn-sm btn-alt-secondary create-hover" type="button"><i class="fa fa-file-excel-o"></i> Export CSV</button>
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
                        @if(count($reports) < 1)
                            <div class="danger-well">There are no submitted report yet</div>
                        @else
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr style="background-color: #2C3E50;color:white;">
                                        <th>S/N</th>
                                        <th>STATE</th>
                                        <th>TTILE</th>
                                        <th>REPORT</th>
                                        <th>STATUS</th>
                                        <th>TIME</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($count=1)
                                    @foreach($reports as $report)
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td>{{state($report->state_id)}}</td>
                                            <td>{{$report->title}}</td>
                                            <td>{{$report->comment}}</td>
                                            <td>
                                                @if($report->status == 1)
                                                    <span class="badge badge-success">Unused</span>
                                                @elseif($report->status == 2)
                                                    <span class="badge badge-danger">Used</span>
                                                @endif
                                            </td>
                                            <td>{{$report->created_at->diffForHumans()}}</td>
                                            <td>
                                                <button class="btn btn-sm btn-secondary create-hover" data-href="#viewReport" type="button"><i class="fa fa-eye"></i> View Details</button>
                                            </td>
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
