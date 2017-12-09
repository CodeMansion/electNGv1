@if(\Session::has('error'))
    <!-- notification script -->
    <div class="danger-well" id="close">
        <em>{!! \Session::get('error') !!}</em>
        <span class="pull-right create-hover"><i class="fa fa-close" id="close-notify"></i></span>
    </div>
@endif
@if(\Session::has('success'))
    <!-- notification script -->
    <div class="success-well" id="close">
        <em>{!! \Session::get('success') !!}</em>
        <span class="pull-right create-hover"><i class="fa fa-close" id="close-notify"></i></span>
    </div>
@endif
@if(\Session::has('info'))
    <!-- notification script -->
    <div class="info-well" id="close">
        <em>{!! \Session::get('info') !!}</em>
        <span class="pull-right create-hover"><i class="fa fa-close" id="close-notify"></i></span>
    </div>
@endif
@if(\Session::has('warning'))
    <!-- notification script -->
    <div class="warning-well" id="close">
        <em>{!! \Session::get('warning') !!}</em>
        <span class="pull-right create-hover"><i class="fa fa-close" id="close-notify"></i></span>
    </div>
@endif