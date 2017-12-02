@if(\Session::has('error'))
    <!-- notification script -->
    <div class="danger-well">
        <em>{!! \Session::get('error') !!}</em>
        <span class="pull-right create-hover"><i class="fa fa-close"></i></span>
    </div>
@endif
@if(\Session::has('success'))
    <!-- notification script -->
    <div class="success-well">
        <em>{!! \Session::get('success') !!}</em>
        <span class="pull-right create-hover"><i class="fa fa-close"></i></span>
    </div>
@endif
@if(\Session::has('info'))
    <!-- notification script -->
    <div class="info-well">
        <em>{!! \Session::get('info') !!}</em>
        <span class="pull-right create-hover"><i class="fa fa-close"></i></span>
    </div>
@endif
@if(\Session::has('warning'))
    <!-- notification script -->
    <div class="warning-well">
        <em>{!! \Session::get('warning') !!}</em>
        <span class="pull-right create-hover"><i class="fa fa-close"></i></span>
    </div>
@endif