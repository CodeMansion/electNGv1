$(document).ready(function() {
    //submiting polling result
    $("#is-validating").hide();
    $("#polling-details").hide();
    $("#has-error").hide();
    $("#refresh").hide();
    
    //assigning a user to a polling centre under a state
    $("#modal .modal").each(function(index){
        $("#assignUser"+index).on("click",function() {
            $.LoadingOverlay("show");
            $.ajax({
                url: "{{URL::route('ElectionAjax')}}",
                method: "POST",
                data:{
                    '_token': "{{csrf_token()}}",
                    'ward_id' : $("#ward_id"+index).val(),
                    'lga_id' : $("#lga_id"+index).val(),
                    'polling_unit_id' : $("#polling_unit_id"+index).val(),
                    'user_id' : $("#user_id"+index).val(),
                    'election_id' : $("election_id").val(),
                    'req' : "assignUsers"
                },
                success: function(rst){
                    $.LoadingOverlay("hide");
                    swal("Assigned Successfully!", rst, "success");
                    location.reload();
                },
                error: function(rst){
                    $.LoadingOverlay("hide");
                    swal("Oops! Error","An Error Occured!", "error");
                }
            });
        }); 
    });
    
    
    $("#check-passcode").on("click", function() {
        $("#refresh").show();
        var passcode = $("input[name=passcode]").val();
        if(passcode.length > 6 ){
            alert('Invalid passcode!');
        } else {
            $("input[name=passcode]").attr('disabled',true);
            $("#is-validating").show();
            $.ajax({
                url: "{{URL::route('CheckPasscode')}}",
                method: "POST",
                data:{
                    '_token': "{{csrf_token()}}",
                    'passcode' : passcode,
                    'req' : "checkCode"
                },
                success: function(rst){
                    $("#is-validating").hide();
                    $("#has-error").hide();
                    $("#polling-details").html(rst);
                    $("#polling-details").show();
                },
                error: function(rst){
                    $("#is-validating").hide();
                    $("#polling-details").hide();
                    $("#has-error").show();
                }
            });
        }
    });

    $("select[name=lga_id]").on("change", function(){
        $.ajax({
            url: "{{URL::route('ElectionAjax')}}",
            method: "POST",
            data:{
                '_token': "{{csrf_token()}}",
                'lga_id' : $(this).val(),
                'req' : "displayWard"
            },
            success: function(rst){
                $.LoadingOverlay("hide");
                $("select[name=ward_id]").html(rst);
            },
            error: function(rst){
                $.LoadingOverlay("hide");
                swal("Oops! Error","An Error Occured!", "error");
            }
        });
    });

    $("select[name=ward_id]").on("change", function(){
        $.ajax({
            url: "{{URL::route('ElectionAjax')}}",
            method: "POST",
            data:{
                '_token': "{{csrf_token()}}",
                'lga_id' : $('select[name=lga_id]').val(),
                'ward_id' : $(this).val(),
                'req' : "displayCentre"
            },
            success: function(rst){
                $("select[name=polling_unit_id]").html(rst);
            },
            error: function(rst){
                $.LoadingOverlay("hide");
                swal("Oops! Error","An Error Occured!", "error");
            }
        });
    });

    //implementing refresh
    $("#refresh").on('click', function(){
        $("input[name=passcode]").attr('disabled',false);
        $("input[name=passcode]").val('');
    });
});    