@extends('partials.app')
@section('extra_style')
    <!-- customize styling for student resource-->
    <link rel="stylesheet" href="{{ asset('js/plugins/slick/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/slick/slick-theme.min.css') }}">
    {!! Charts::assets() !!}
@endsection
@section('content')
    <main id="main-container">
        <!-- Page Content -->
        <div class="content">
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
                                    <!-- <button class="btn btn-sm btn-danger create-hover" id="cancal" type="submit"><i class="si si-close"></i> Cancal Election</button>  -->
                                @elseif($election['election_status_id'] == 3)
                                    <button class="btn btn-sm btn-info create-hover" id="details" type="button"><i class="si si-bar-chart"></i> View Election Summary</button>
                                @endif
                            </form>
                            <div class="block-options">
                                <button type="button" class="btn-block-option">
                                    <i class="si si-wrench"></i>
                                </button>
                                <button type="button" class="btn-block-option" data-toggle="tooltip" title="Edit">
                                    <i class="si si-pencil"></i>
                                </button>
                                <div class="dropdown">
                                    <button type="button" class="btn-block-option dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="create-hover">Other Options</span></button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="si si-book-open mr-5"></i>View Submitted Result
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="si si-printer mr-5"></i>Print Result
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="si si-picture mr-5"></i>Infographics
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="si si-tag mr-5"></i>View Election Passcode
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="si si-user mr-5"></i>Election Candidate
                                        </a>
                                    </div>
                                </div>
                            </div>
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
                                <tr>
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
        $(document).ready(function() {
            //submiting polling result
            $("#is-validating").hide();
            $("#polling-details").hide();
            $("#has-error").hide();
            $("#refresh").hide();

            page_refresh_stats();
        }); 

        function page_refresh_stats(){
            $('#loader').show();
            $("#stats").hide();
            $.ajax({
                url: "{{URL::route('Election.Stats')}}", 
                method: "POST",
                data: {
                    '_token': "{{csrf_token()}}",
                    'slug': "{{$election['slug']}}"
                },
                success: function(data) {
                    $("#loader").hide();
                    $('#stats').show();
                    $('#stats').html(data);
                    // location.reload();
                },
                complete: function() {}
            });
            setTimeout(page_refresh_stats, 20000);
        }
    </script>
    <script src="{{ asset('js/plugins/slick/slick.min.js') }}"></script>
    <script>
        jQuery(function () {
            // Init page helpers (BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
            Codebase.helpers(['datepicker', 'slick', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']); 
        });
    </script>
@endsection
