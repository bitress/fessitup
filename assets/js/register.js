$(document).ready(function () {
    $('#signup').bind('click', function (e) {
        e.preventDefault();

        var username = $('#username');
        var email = $('#email');
        var password = $('#password');
        var confirm_password = $('#confirm_password');
        var math_captcha = $('#math_captcha');



        var data = {
            username: username.val(),
            email: email.val(),
            password: password.val(),
            confirm_password: confirm_password.val(),
            math_captcha: math_captcha.val()
        };



        data.password = CryptoJS.SHA512(data.password).toString();
        data.confirm_password = CryptoJS.SHA512(data.confirm_password).toString();

        $.ajax({
            type: 'POST',
            url: '/Engine/Ajax.php',
            data: {
                action: 'userRegister',
                username: data.username,
                email: data.email,
                password: data.password,
                confirm_password: data.confirm_password,
                math_captcha: data.math_captcha
            },
            beforeSend: function () {
                $('#signup').html('<i class="fa fa-spinner fa-spin"></i> &nbsp; Signing Up')
            },
            success: function (result) {
                console.log(result);

                    var res = JSON.parse(result);

                     if(res.status === "true") {

                                  showSuccessToasts(res.msg,'Success!', 3000);
                    setTimeout('window.location = "/";', 3000);
                    }
                    else {

                         for(var i=0; i<res.errors.length; i++) {
                            var error = res.errors[i];
                            showErrorToasts(error, 'Oopsie!');
                        }
                     $('#signup').html('&nbsp; Register');

                       
                    }


                // if (result === "true") {
                //     showSuccessToasts("Register Successful",'Success!', 3000);
                //     setTimeout('window.location = "/";', 3000);
                // } else {
                //     // toastr.error(result, 'Opsie');
                //     showErrorToasts(result, 'Oopsie!');
                //     $('#signup').html('&nbsp; Register')
                // }
            }
        });

    });
});