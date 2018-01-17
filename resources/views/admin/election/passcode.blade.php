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
                                <i class="si si-feed"></i> {{$election['name']}} 
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
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr style="background-color: #2C3E50;color:white;">
                                    <td>S/N</td>
                                    <td>STATE</td>
                                    <td>CONSTITUENCY</td>
                                    <td>LGA</td>
                                    <td>WARD</td>
                                    <td>POLLING STATION</td>
                                    <td>STATUS</td>
                                    <td>OTP</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php($count=1)
                                @foreach($passcodes as $code)
                                    <tr>
                                        <td>{{$count}}</td>
                                        <td>{{state($code['state_id'])}}</td>
                                        <td>{{constituency($code['constituency_id'])}}</td>
                                        <td>{{lga($code['lga_id'])}}</td>
                                        <td>{{ward($code['ward_id'])}}</td>
                                        <td>{{centre($code['polling_unit_id'])}}</td>
                                        <td>
                                            @if($code['status'] == 1)
                                                <span class="badge badge-success">Unused</span>
                                            @elseif($code['status'] == 2)
                                                <span class="badge badge-danger">Used</span>
                                            @endif
                                        </td>
                                        <td>{{$code['otp']}}</td>
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
