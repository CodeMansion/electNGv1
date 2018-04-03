$(document).ready(function() {
    //submiting polling result
    $("#view-parties").hide();
    $("#view-states").hide();
    $("#lga").hide();
    $("#const").hide();
    
    //making availability of the election type
    $("select[name=type]").on("change", function() {
        if($(this).val() == '1') {
            // $("#view-parties").hide();
            $("#view-states").hide();
            $("#lga").hide();
            $("#const").hide();

            $("#view-parties").show();
        }

        if($(this).val() == '2') {
            $("#view-parties").hide();
            $("#view-states").hide();
            $("#lga").hide();
            $("#const").hide();
            
            $("#view-states").show();
            $("#view-parties").show();
        }

        if($(this).val() == '3') {
            $("#view-parties").hide();
            $("#view-states").hide();
            $("#lga").hide();
            $("#const").hide();

            $("#view-states").show();
            $("#const").show();
            $("#view-parties").show();
        }

        if($(this).val() == '4') {
            $("#view-states").hide();
            $("#lga").hide();
            $("#const").hide();

            $("#view-parties").show();
            $("#view-states").show();
            $("#lga").show();
            $("#const").show();
        }

        if($(this).val() == '') {
            $("#view-parties").hide();
            $("#view-states").hide();
            $("#lga").hide();
            $("#const").hide();
        }
    });

    //populating constituencies based on state_id
    $("select[name=state_id]").on("change", function() {
        var state_id = $(this).val();
        $.ajax({
            url: URL_CHECK,
            method: "POST",
            data:{
                '_token': TOKEN,
                'state_id': state_id,
                'req': "viewConst"
            },
            success: function(data){
                $("#view-const").html(data);
            },
            error: function(rst){
                $.LoadingOverlay("hide");
                swal("Oops! Error","An Error Occured!", "error");
            }
        });
    });

    //populating lgas based on constituency id
    $("select[name=constituency_id]").on("change", function() {
        var constituency_id = $(this).val();
        var state_id = $("select[name=state_id]").val();
        $.ajax({
            url: URL_CHECK,
            method: "POST",
            data:{
                '_token': TOKEN,
                'constituency_id': constituency_id,
                'state_id': state_id,
                'req': "viewLga"
            },
            success: function(data){
                $("#view-lga").html(data);
            },
            error: function(rst){
                $.LoadingOverlay("hide");
                swal("Oops! Error","An Error Occured!", "error");
            }
        });
    });


    //submitting election details
    $("#submit-election").on("click", function() {
        var name = $("input[name=name]").val();
        var description = $("input[name=description]").val();
        var start_date = $("input[name=start_date]").val();
        var end_date = $("input[name=end_date]").val();
        var type =  $("select[name=type]").val();
        var party = $("select[name=party]").val();
        var state_id = $("select[name=state_id]").val();
        var constituency_id = $("select[name=constituency_id]").val();
        var lga_id = $("select[name=lga_id]").val();

        if(name.length < 1) {
            $("#ErrorMsg").html("<div class='danger-well'>Please enter election name</div><br/>");
        } else if(start_date.length < 1) {
            $("#ErrorMsg").html("<div class='danger-well'>Enter a start date</div><br/>");
        } else if(end_date.length < 1) {
            $("#ErrorMsg").html("<div class='danger-well'>Enter an end date</div><br/>");
        } else if(type.length < 1) {
            $("#ErrorMsg").html("<div class='danger-well'>Please select an election type</div><br/>");
        } else if(party.length < 2) {
            $("#ErrorMsg").html("<div class='danger-well'>Please select at least two parties</div><br/>");
        } else {
            if(type == '1') {
                $("#ErrorMsg").html("");
                $(this).attr('disabled',true);
                $(this).html("<i class='fa fa-spinner fa-spin'></i> Processing... this may take a minute");

                $.ajax({
                    url: INSERT,
                    method: "POST",
                    data:{
                        '_token': TOKEN,
                        'name': name,
                        'description': description,
                        'start_date': start_date,
                        'end_date': end_date,
                        'party': party,
                        'type': type,
                        'req': "presidential"
                    },
                    success: function(rst){
                        if(rst.type == "true") {
                            $("#submit-election").attr('disabled',false);
                            $("#submit-election").html("<i class='fa fa-check'></i> Submit");
                            $("#ErrorMsg").html("<div class='success-well'>"+rst.msg+"</div><br/>");
                            location.reload();
                        } else if(rst.type == "false") {
                            $("#submit-election").attr('disabled',false);
                            $("#submit-election").html("<i class='fa fa-warning'></i> Failed! Try Again.");
                            $("#ErrorMsg").html("<div class='danger-well'>"+rst.msg+"</div><br/>");
                        }
                    },
                    error: function(jqXHR, textStatus, errorMessage){
                        $("#submit-election").attr('disabled',false);
                        $("#submit-election").html("<i class='fa fa-warning'></i> Failed. Try Again!");
                        $("#ErrorMsg").html("<div class='danger-well'>"+errorMessage+"</div><br/>");
                    }
                });
            }

            if(type == '2') {
                if(state_id.length < 1){
                    $("#ErrorMsg").html("<div class='danger-well'>Please select a state</div><br/>");
                } else {
                    $("#ErrorMsg").html("");
                    $(this).attr('disabled',true);
                    $(this).html("<i class='fa fa-spinner fa-spin'></i> Processing... this may take a minute");

                    $.ajax({
                        url: INSERT,
                        method: "POST",
                        data:{
                            '_token': TOKEN,
                            'name': name,
                            'description': description,
                            'start_date': start_date,
                            'end_date': end_date,
                            'party': party,
                            'state_id': state_id,
                            'type': type,
                            'req': "governorship"
                        },
                        success: function(rst){
                            if(rst.type == "true") {
                                $("#submit-election").attr('disabled',false);
                                $("#submit-election").html("<i class='fa fa-check'></i> Submit");
                                $("#ErrorMsg").html("<div class='success-well'>"+rst.msg+"</div><br/>");
                                location.reload();
                            } else if(rst.type == "false") {
                                $("#submit-election").attr('disabled',false);
                                $("#submit-election").html("<i class='fa fa-warning'></i> Failed! Try Again.");
                                $("#ErrorMsg").html("<div class='danger-well'>"+rst.msg+"</div><br/>");
                            }
                        },
                        error: function(jqXHR, textStatus, errorMessage){
                            $("#submit-election").attr('disabled',false);
                            $("#submit-election").html("<i class='fa fa-warning'></i> Failed. Try Again!");
                            $("#ErrorMsg").html("<div class='danger-well'>"+errorMessage+"</div><br/>");
                        }
                    });
                }
            }

            if(type == '3') {
                if(state_id.length < 1){
                    $("#ErrorMsg").html("<div class='danger-well'>Please select a state</div><br/>");
                } else if(constituency_id.length < 1) {
                    $("#ErrorMsg").html("<div class='danger-well'>Please select a constituency</div><br/>");
                } else {
                    $("#ErrorMsg").html("");
                    $(this).attr('disabled',true);
                    $(this).html("<i class='fa fa-spinner fa-spin'></i> Processing... this may take a minute");

                    $.ajax({
                        url: INSERT,
                        method: "POST",
                        data:{
                            '_token': TOKEN,
                            'name': name,
                            'description': description,
                            'start_date': start_date,
                            'end_date': end_date,
                            'party': party,
                            'state_id': state_id,
                            'constituency_id': constituency_id,
                            'type': type,
                            'req': "senatorial"
                        },
                        success: function(rst){
                            if(rst.type == "true") {
                                $("#submit-election").attr('disabled',false);
                                $("#submit-election").html("<i class='fa fa-check'></i> Submit");
                                $("#ErrorMsg").html("<div class='success-well'>"+rst.msg+"</div><br/>");
                                location.reload();
                            } else if(rst.type == "false") {
                                $("#submit-election").attr('disabled',false);
                                $("#submit-election").html("<i class='fa fa-warning'></i> Failed! Try Again.");
                                $("#ErrorMsg").html("<div class='danger-well'>"+rst.msg+"</div><br/>");
                            }
                        },
                        error: function(jqXHR, textStatus, errorMessage){
                            $("#submit-election").attr('disabled',false);
                            $("#submit-election").html("<i class='fa fa-warning'></i> Failed. Try Again!");
                            $("#ErrorMsg").html("<div class='danger-well'>"+errorMessage+"</div><br/>");
                        }
                    });
                }
            }

            if(type == '4') {
                if(state_id.length < 1){
                    $("#ErrorMsg").html("<div class='danger-well'>Please select a state</div><br/>");
                } else if(constituency_id.length < 1) {
                    $("#ErrorMsg").html("<div class='danger-well'>Please select a constituency</div><br/>");
                } else if(lga_id.length < 1) {
                    $("#ErrorMsg").html("<div class='danger-well'>Please select a local government</div><br/>");
                } else {
                    $("#ErrorMsg").html("");
                    $(this).attr('disabled',true);
                    $(this).html("<i class='fa fa-spinner fa-spin'></i> Processing... this may take a minute");

                    $.ajax({
                        url: INSERT,
                        method: "POST",
                        data:{
                            '_token': TOKEN,
                            'name': name,
                            'description': description,
                            'start_date': start_date,
                            'end_date': end_date,
                            'party': party,
                            'state_id': state_id,
                            'constituency_id': constituency_id,
                            'lga_id': lga_id,
                            'type': type,
                            'req': "local"
                        },
                        success: function(rst){
                            if(rst.type == "true") {
                                $("#submit-election").attr('disabled',false);
                                $("#submit-election").html("<i class='fa fa-check'></i> Submit");
                                $("#ErrorMsg").html("<div class='success-well'>"+rst.msg+"</div><br/>");
                                location.reload();
                            } else if(rst.type == "false") {
                                $("#submit-election").attr('disabled',false);
                                $("#submit-election").html("<i class='fa fa-warning'></i> Failed! Try Again.");
                                $("#ErrorMsg").html("<div class='danger-well'>"+rst.msg+"</div><br/>");
                            }
                        },
                        error: function(jqXHR, textStatus, errorMessage){
                            $("#submit-election").attr('disabled',false);
                            $("#submit-election").html("<i class='fa fa-warning'></i> Failed. Try Again!");
                            $("#ErrorMsg").html("<div class='danger-well'>"+errorMessage+"</div><br/>");
                        }
                    });
                }
            }
        }
    });

    $("select[name=lga_id]").on("change", function() {
        $("#view-parties").show();
    });
}); 
