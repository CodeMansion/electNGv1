<div class="row">
    <div class="col-2"></div>
    <div class="col-8">
        <div class="form-group">
            <div class="row">
                <div class="col-md-9 col-xl-9">
                    <input type="text" class="form-control" placeholder="ENTER PASSCODE HERE.." name="passcode" required style="height:50px;font-size:18px;">
                </div>
                <div class="col-md-3 col-xl-3">
                    <button class="btn btn-lg btn-outline-success create-hover" id="check-passcode"> VALIDATE</button>
                    <i class="fa fa-refresh create-hover" id="refresh" data-toggle="tooltip" title="Clear text field"></i>
                </div>
            </div>
        </div>
        <div id="is-validating">
            <center><img src="{{ asset('images/loading.gif') }}" alt=""></center>
        </div>
        <div id="polling-details">
            
        </div>
        <div id="has-error">
            <div style='margin-bottom:30px;' class='danger-well'>Invalid passcode or server error. Contact Administrator.</div>
        </div>
    </div>
    <div class="col-2"></div>
</div>