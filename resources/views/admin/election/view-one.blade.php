@extends('partials.app')
@section('extra_style')
    <!-- customize styling for student resource-->
    <link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <style>
        .content .block-content label {
            margin-right: 10px;
            font-size: 15px;
        }
    </style>
@endsection
@section('content')
<div class="breadcrumbs">
        <h1>{{ $election['name'] }} </h1>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Election</a></li>
            <li class="active">{{ $election['name'] }}</li>
        </ol>
    </div>
    <!-- BEGIN SIDEBAR CONTENT LAYOUT -->
    <div class="page-content-container">
        <div class="page-content-row">
            <!-- BEGIN PAGE SIDEBAR -->
            <div class="page-sidebar">
                <nav class="navbar" role="navigation">
                    <ul class="nav navbar-nav margin-bottom-35">
                        <li class="active"><a href="{{ URL::route('Election.ViewOne',$election['slug']) }}"><i class="icon-home"></i> Home </a></li>
                        <li><a href="{{ URL::route('view.reports', $election['slug']) }}"><i class="icon-note "></i> View Reports </a></li>
                        <li><a href="{{URL::route('winMetric',$election['slug'])}}"><i class="icon-flag"></i> Win Metrics </a></li>
                        <li><a href="{{ URL::route('Election.broadsheet', $election['slug']) }}"><i class="icon-trophy "></i> Broadsheet </a></li>
                        <li><a href="{{ URL::route('view.activity',$election['slug']) }}"><i class="icon-bell"></i> Activity Logs </a></li>
                        <li><a href="{{ URL::route('PasscodeView',$election['slug']) }}"><i class="icon-user"></i> Passcodes</a></li>
                        <li><a href="{{URL::route('ward.index')}}"><i class="icon-directions"></i> Party Agents</a></li>
                        <li><a href="{{ URL::route('SubmittedResult',$election['slug']) }}"><i class="icon-bell"></i> View Result </a></li>
                    </ul>
                </nav>
            </div>
            <!-- END PAGE SIDEBAR -->
            <div class="page-content-col">
                @include('partials.notifications')
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <!-- BEGIN Portlet PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-green-sharp">
                                    <i class="icon-speech font-green-sharp"></i>
                                    <span class="caption-subject bold uppercase"> {{$election['name']}} </span>
                                    <span class="caption-helper">Displaying list of contesting parties ...</span>
                                </div>
                                <div class="actions"></div>
                            </div>
                            <div class="portlet-body">
                                @if(count($politicalParties) < 1)
                                    <div class="alert alert-danger">
                                        <em>There are political parties in this election </em>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <table class="table table-striped table-hover political_parties" id="sample_3">
                                                <thead>
                                                    <tr>
                                                        <th>LOGO</th>
                                                        <th>CODE</th>
                                                        <th>NAME</th>
                                                        <th></th>
                                                        <th>ACTIONS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php($index=0)
                                                    @foreach($politicalParties as $party)
                                                    @php($star = \App\ElectionParty::where('election_id',$election['id'])->where('political_party_id',$party['id'])->first())
                                                        <tr>
                                                            <td><img src=<?php echo asset("uploads/party-logo/$party->code.jpg"); ?> width="50px" height="50px" alt=""></td>
                                                            <td>{{ $party['code'] }}</td>
                                                            <td>{{ $party['name'] }}</td>
                                                            <th>
                                                                @if($star['is_star_party'] == true)
                                                                    <img src="{{ asset('images/star.png')}}" height="30" width="30" />
                                                                @endif 
                                                            </th>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-xs btn-default dropdown-toggle" type="button" id="button_{{ $index }}" data-toggle="dropdown" aria-expanded="false"> Actions<i class="fa fa-angle-down"></i></button>
                                                                    <ul class="dropdown-menu pull-left" role="menu">
                                                                        @if($election['election_status_id'] == 2)
                                                                            <li><a href="{{ URL::route('Election.ViewOne') }}"><i class="icon-note"></i> View Party Result </a></li>
                                                                        @endif
                                                                        <li><a href="#" id="mark_star_{{ $index }}"><i class="icon-star"></i> Make as star </a></li>
                                                                        <input type="hidden" id="political_party_id_{{ $index }}" value="{{ $party['id'] }}" />
                                                                        @if($election['election_status_id'] == 1)
                                                                            <li><a href="{{URL::route('Election.ViewOne')}}"><i class="icon-trash"></i> Remove  </a></li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @php($index++)
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra_script')
    <script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('body').find('.table.table-striped.table-hover.political_parties tbody tr').each(function(index) {
                $("#mark_star_" + index).on("click", function() {
                    var party_id = $("#political_party_id_" + index).val();
                    $("#button_" + index).attr('disabled', true);
                    $("#button_" + index).html("<i class='fa fa-spinner fa-spin'></i> Processing ...");

                    $.ajax({
                        url: "{{ URL::route('MarkStar') }}", 
                        method: "POST",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'party_id': party_id,
                            'election_id': "{{ $election['id'] }}"
                        },
                        success: function(data) {
                            $("#button_" + index).attr('disabled', false);
                            $("#button_" + index).html(" Action <i class='fa fa-angle-down'></i>");
                            alert("Marked Successfully!")
                            location.reload();
                        },
                        error: function() {
                            $("#button_" + index).attr('disabled', false);
                            $("#button_" + index).html(" Try Again <i class='fa fa-angle-down'></i>");
                            alert("Error");
                        }
                    });
                });
            });
        });
    </script>
@endsection
@section('modals')
@endsection
