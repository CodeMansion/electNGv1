<!-- Create New Student Modal -->
<div class="modal" id="submitResult{{$result->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title"><i class="si si-bar-chart"></i> Submit Polling Result</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option create-hover" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content" style="height:600px;overflow:scroll;">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-9 col-xl-9">
                                <input type="text" class="form-control" placeholder="ENTER PASSCODE HERE.." name="passcode" required style="height:50px;font-size:18px;">
                            </div>
                            <div class="col-md-3 col-xl-3">
                                <button class="btn btn-lg btn-alt-secondary" id="check-passcode"> VALIDATE</button>
                            </div>
                        </div>
                    </div>
                    <div id="is-validating">
                        <center><img src="{{ asset('images/loading.gif') }}" alt=""></center>
                    </div>
                    <div id="polling-details">
                        
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary create-hover" data-dismiss="modal">Close</button>
                @if(config('constants.ACTIVE_STATE_ID'))
                <button type="submit" class="btn btn-success create-hover"><i class="fa fa-check"></i> Submit</button>
                @endif
            </div> -->
            </form>
        </div>
    </div>
</div>
<!-- END Create New Student Modal -->
<script>
    
</script>
