$(document).ready(function () {
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

});