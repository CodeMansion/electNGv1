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
                            <div class="block-options">
                                <button type="button" class="btn-block-option">
                                    <i class="si si-wrench"></i>
                                </button>
                                <button type="button" class="btn-block-option" data-toggle="tooltip" title="Edit">
                                    <i class="si si-pencil"></i>
                                </button>
                                <div class="dropdown">
                                    <button type="button" class="btn-block-option dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Other Options</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="fa fa-fw fa-bell mr-5"></i>View Polling Centres
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="fa fa-fw fa-envelope-o mr-5"></i>Print Result
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="fa fa-fw fa-envelope-o mr-5"></i>Mail Result
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="fa fa-fw fa-pencil mr-5"></i>Edit Profile
                                        </a>
                                        @if($election['election_status_id'] == 1)
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="fa fa-fw fa-pencil mr-5"></i>Complete Process
                                        </a>
                                        @elseif($election['election_status_id'] == 2)
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="fa fa-fw fa-pencil mr-5"></i>Begin Election
                                        </a>
                                        @elseif($election['election_status_id'] == 3)
                                        <a class="dropdown-item" href="{{URL::route('Election.ChangeStatus')}}">
                                            <i class="fa fa-fw fa-pencil mr-5"></i>End Election
                                        </a>
                                        <input type="hidden" name="type" value="completed">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content">
                            <p>
                                <a href="{{URL::route('Dashboard')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a> |
                                <a href="{{URL::route('Election.View')}}"><i class="si si-arrow-left"></i> Elections</a> 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="block"><!-- Block Tabs With Options Default Style -->
                         <div class="block-header block-header-default">
                            <h3 class="block-title">
                                <i class="si si-feed"></i> Infographics
                            </h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option"> <i class="si si-wrench"></i></button>
                                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                                <button type="button" class="btn-block-option" data-toggle="tooltip" title="Edit"><i class="si si-pencil"></i></button>
                            </div>
                        </div>
                        <div class="block-content">
                            @if($election['election_status_id'] == 3 || $election['election_status_id'] == 4)
                                <div class="js-slider text-center" data-autoplay="true" data-dots="true" data-arrows="true" data-slides-to-show="3">
                                    @foreach($resultSummary as $key => $value)
                                        <div class="col-3 " style="border-left: 4px solid #ECF0F1;">
                                            <a class="block block-link-shadow text-right" href="javascript:void(0)">
                                                <div class="block-content block-content-full clearfix">
                                                    <div class="float-left mt-10 d-none d-sm-block">
                                                        <i class="si si-bag fa-3x text-body-bg-dark"></i>
                                                    </div>
                                                    <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="{{$value}}">0</div>
                                                    <div class="font-size-h4 font-w600 text-uppercase text-muted">{{$key}}</div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div><hr/>
                                <div class="row">
                                    <div class="col-6">
                                        {!! $barChart->render() !!}
                                    </div>
                                    <div class="col-6">
                                        {!! $pieChart->render() !!}
                                    </div>
                                </div><hr/> 
                            @else
                                <div class="warning-well">
                                    <em>Can't show election result infographic as this moment. Election has not started.</em>
                                </div>
                            @endif
                        </div>
                    </div><!-- END Block Tabs With Options Default Style -->
                </div>
            </div>
        </div>
    </main>
@endsection
@section('extra_script')
    <script src="{{ asset('js/plugins/slick/slick.min.js') }}"></script>
    <script src="{{ asset('js/pages/election.js') }}"></script>
    <script>
        jQuery(function () {
            // Init page helpers (BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
            Codebase.helpers(['datepicker', 'slick', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']); 
        });
    </script>
@endsection
