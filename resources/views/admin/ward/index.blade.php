@extends('partials.app')

@section('content')
    <main id="main-container">
        <!-- Page Content -->
        <div class="content container">
            <div class="row" style="">
                <div class="col-12 col-xl-12">
                    <div class="block block-content title-hold">
                        <h3 style="margin-bottom:5px;">
                            <i class="si si-users"></i> Wards and Polling Units
                            <button data-toggle="modal" data-target="#new-ward" class="btn btn-sm btn-primary create-hover" type="button">Add New</button>
                        </h3>
                        <p><a href="{{URL::route('Dashboard')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6 col-xl-6">
                    <div class="block block-content content-hold">
                        
                    </div>
                </div>
                <div class="col-6 col-xl-6"></div>
            </div>
        </div>
    </main>
@endsection

@section('extra_script')
<script type="text/javascript">
    $(document).ready(function() {
       
    });   
</script>
@endsection
@section('modals')
    @include('admin.ward.modals._new_ward')
    <div id="modal">
    @php($index=0)        
        @foreach($wards as $ward)
            @include('admin.ward.modals._new_edit')
        @php($index++)
        @endforeach
    </div>
@endsection