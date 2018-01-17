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
                            @include('admin.election.partials._result_query')
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="block">
                        
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
