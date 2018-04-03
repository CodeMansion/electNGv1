    $('#new_user_btn').on("click", function() {
        var surname = $("#surname").val();
        var other_names = $("#other_names").val();
        var state_id = $("#state_id").val();
        var gender_id = $("#gender_id").val();
        var email = $("#email").val();
        var telephone = $("#phone").val();
        var address = $("#res_address").val();
        var category_id = $("#user_category_id").val();
        var photo = $("#photo")[0].files[0];
        var role_id = $("#role_id").val();

        (category_id.length < 1) ? $("#errorMsg").html("<div class='alert alert-danger'> Select a user category</div><hr/>") : "" ;
        (gender_id.length < 1) ? $("#errorMsg").html("<div class='alert alert-danger'> Select user gender</div><hr/>") : "" ;
        (surname.length < 1) ? $("#errorMsg").html("<div class='alert alert-danger'> Provide Surname</div><hr/>") : "" ;
        (other_names.length < 1) ? $("#errorMsg").html("<div class='alert alert-danger'> Provide other names</div><hr/>") : "" ;
        (telephone.length < 1) ? $("#errorMsg").html("<div class='alert alert-danger'> Provide telephone number</div><hr/>") : "" ;
        (email.length < 1) ? $("#errorMsg").html("<div class='alert alert-danger'> Provide valid email address</div><hr/>") : "" ;
        (state_id.length < 1) ? $("#errorMsg").html("<div class='alert alert-danger'> Select a state of origin</div><hr/>") : "" ;
        (address.length < 1) ? $("#errorMsg").html("<div class='alert alert-danger'> Provide residential address</div><hr/>") : "" ;

        $(this).attr('disabled', true);
        $(this).html("<i class='fa fa-spinner fa-spin'></i> Submit");

        var formData = new FormData();
        formData.append('category_id', category_id);
        formData.append('other_names', other_names);
        formData.append('state_id', state_id);
        formData.append('gender_id', gender_id);
        formData.append('email', email);
        formData.append('telephone', telephone);
        formData.append('address', address);
        formData.append('role_id', role_id);
        formData.append('surname', surname);
        formData.append('_token', TOKEN);
        formData.append('photo', photo);

        $.ajax({
            url: INSERT,
            method: "POST",
            cache: false,
            processData: false,
            contentType: false,
            data: formData,
            success: function(rst){
                if(rst.type == "true") {
                    $("#new_user_btn").attr('disabled', false);
                    $("#new_user_btn").html("<i class='fa fa-check'></i> Submit");
                    $("#errorMsg").html("<div class='alert alert-success'>" + rst.msg + "</div>");
                    location.reload();
                } else if(rst.type == "false") {
                    $("#new_user_btn").attr('disabled', false);
                    $("#new_user_btn").html(" Try again");
                    $("#errorMsg").html("<div class='alert alert-danger'>" + rst.msg + "</div>");
                }
            },
            error: function(jqXHR, textStatus, errorMessage){
                $("#new_user_btn").attr('disabled',false);
                $("#new_user_btn").html(" Try again");
                $("#errorMsg").html("<div class='alert alert-danger'>" + errorMessage + "</div>");
            }
        });
    }); 


    $("#modal .modal").each(function(i) {
        $('#updateUser'+i).on("click",function() {
            var id=$('#id'+i).val();
            $.ajax({
                url: "{{URL::route('Users.update')}}",
                method: "POST",
                data:{
                    '_token': "{{csrf_token()}}",
                    'id':id,
                    'email' : $('#email'+i).val(),
                    'username' : $('#username'+i).val(),
                    'user_type_id' : $('#user_type_id'+i).val(),
                    'role_id' : $('#role_id'+i).val(),
                    'first_name' : $('#first_name'+i).val(),
                    'last_name' : $('#last_name'+i).val(),
                    'phone' : $('#phone'+i).val(),
                    'res_address': $('#res_address'+i).val(),
                    'req' : "UpdateUser"
                },
                success: function(rst){
                    swal("User Updated Successfully", "Mail sent successfully in minutes.", "success");
                    location.reload();

                },
                error: function(rst){
                    swal("Oops! Error","An Error Occured!", "error");
                }
            });
        });   
    });
    
     