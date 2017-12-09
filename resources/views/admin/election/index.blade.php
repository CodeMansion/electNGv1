@extends('partials.app')
@section('extra_style')
    <!--customize styling for student resource-->
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/select2-bootstrap.min.css')}}">
@endsection
@section('content')
    <main id="main-container">
        <!-- Page Content -->
        <div class="content">
            <div class="row" style="">
                <div class="col-12 col-xl-12">
                    <div class="block block-content title-hold">
                        <div class="col-md-12">
                            <h3 style="margin-bottom:5px;">
                                <i class="si si-feed"></i> Elections 
                                @can('add_elections')
                                    <button data-toggle="modal" data-target="#new-election" class="btn btn-sm btn-primary create-hover" type="button"> Add Election</button>
                                @endcan
                                <p class="p-10 bg-primary-lighter text-primary-dark pull-right">{{config('constants.ACTIVE_STATE_NAME')}} - State</p>
                            </h3><hr/>
                            <p><a href="{{URL::route('Dashboard')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a></p>
                            @include('partials.notifications')
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-xl-12">
                    @if(count($elections) < 1)
                        <div class="danger-well">
                            <em>No Election has been added on this system Use the button above to create a new election.</em>
                        </div>
                    @else
                        <div class="row">
                            @foreach($elections as $election)
                                <div class="col-md-6 col-xl-3">
                                    <a class="block block-link-shadow election-hold" href="{{URL::route('Election.ViewOne',$election['slug'])}}" data-toggle="tooltip" title="View This Election">
                                        <div class="block-content block-content-full clearfix">
                                            <div class="float-right">
                                                <img class="img-avatar" src="{{ asset('/images/avatar6.jpg') }}" alt="">
                                            </div>
                                            <div class="float-left mt-9">
                                                <div class="font-w600 mb-3" style="font-size:20px;">
                                                    <span data-toggle="tooltip" title="{{$election['description']}}"><strong>{{$election['name']}}</strong></span>
                                                </div>
                                                <div class="font-size-sm text-muted">
                                                    <button class="btn btn-md btn-alt-secondary create-hover" type="button"><i class="si si-book-open"></i> View Election</button>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div><hr/>
                                            <p>Status: <span class="badge badge-{{$election->status->class}}"><i class="fa fa-cog mr-5"></i> {{$election->status->name}}</span></p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
@section('extra_script')
    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{ asset('js/pages/be_forms_plugins.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#view-lga").hide();
            $("#view-parties").hide();

            $("select[name=type]").on("change", function(){
                if($("select[name=type]").val() == 'lga') {
                    $.LoadingOverlay("show");
                    $.ajax({
                        url: "{{URL::route('ElectionAjax')}}",
                        method: "POST",
                        data:{
                            '_token': "{{csrf_token()}}",
                            'req': "viewLga"
                        },
                        success: function(data){
                            $("#view-lga").show();
                            $.LoadingOverlay("hide");
                            $("#view-lga").html(data);
                            $("#view-parties").show();
                        },
                        error: function(rst){
                            $.LoadingOverlay("hide");
                            swal("Oops! Error","An Error Occured!", "error");
                        }
                    });
                } else {
                    $("#view-state").hide();
                }
            });
        });    
    </script>
    <script>
        jQuery(function () {
            // Init page helpers (BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
            Codebase.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']);
        });
    </script>
@endsection
@section('modals')
    @include('admin.election.modals._new_election')
@endsection