$(document).ready(function () {
    //Check Admin Password is Correct or not
    $('#current_password').keyup(function () {
        let current_password = $('#current_password').val();


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/check-current-password',
            data: { current_password: current_password },
            success: function (resp) {
                if (resp == 'false') {
                    $('#check_current_password').html(" <font color='red'> Incorrect Current Password! </font>");
                } else if (resp == 'true') {
                    $('#check_current_password').html(" <font color='green'> Correct Current Password </font>");
                }
            },
            error: function (err) {
                alert(err);
            }

        });
    });

    // Update Admin Status
    $(document).on("click",".updateAdminStatus", function(){
        let status = $(this).children("i").attr("status");
        let admin_id = $(this).attr("admin_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/update-admin-status",
            data: {status:status, admin_id:admin_id},
            success: function(resp){
                // alert(resp);
                if(resp['status'] == 0){
                    alert("This user is now InActive");
                    $("#admin-"+admin_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-outline' status='InActive'> </i>");
                    
                }else if(resp['status'] == 1){
                    alert("This user is now Active");
                    $("#admin-"+admin_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-check' status='Active'> </i>");
                    
                }

            },
            error: function(){
                alert("Error happen..Please refresh the page and do it again..");
            },

        });
    });

});