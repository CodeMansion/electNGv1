@extends('partials.app')
@section('extra_style')
    <!--customize styling for student resource-->
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
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
                                <button data-toggle="modal" data-target="#new-election" class="btn btn-sm btn-primary create-hover" type="button">Add Election</button>
                            </h3><hr/>
                            <p><a href="{{URL::route('Dashboard')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a></p>
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
                                            <p>Status: <span class="badge badge-primary"><i class="fa fa-cog mr-5"></i> Settings</span></p>
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
@section('modals')
    @include('admin.election.modals._new_election')
@endsection
@section('extra_script')
    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>

    <script src="{{ asset('js/pages/be_forms_plugins.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            //submit new user form
            $('#submit').on("click",function() {
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('Election.New')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'name' : $('input[name=name]').val(),
                        'description' : $('textarea[name=description]').val(),
                        'start_date' : $('input[name=start_date]').val(),
                        'end_date' : $('input[name=end_date]').val(),
                        'req' : "newElection"
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Created!", rst, "success");
                        location.reload();
                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
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