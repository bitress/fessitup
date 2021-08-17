$(document).ready(function () {
    $('#_login_btn_').bind('click', function (e) {
        e.preventDefault();

        var un = $('#username_email');
        var pw = $('#password');
        var token = $('#token');
        var remember = ($('#remember').is(':checked')) ? 1 : 0;

        var data = {
                username: un.val(),
                password: pw.val(),
                token: token.val(),
                remember: remember
        }; 

         //encrypt the password
       data.password = CryptoJS.SHA512(data.password).toString();

        $.ajax({
            type: 'POST',
            url: '/Engine/Ajax.php',
            data: {
                action: 'userLogin',
                un: data.username,
                pw: data.password,
                token: data.token,
                remember: data.remember
            },
            beforeSend: function(){
                $('#_login_btn_').html('<i class="fa fa-spinner fa-spin"></i> &nbsp; Logging In...')
            },
            success: function(result) {
                    if(result === "true"){
                        showSuccessToasts("You are now logged in. Redirecting...");
                        setTimeout('window.location = "/";', 3000);
                    } else if(result === "no") {
                        setTimeout('window.location = "/challenge.php";', 3000);
                    } else {
                        showErrorToasts(result);
                        $('#_login_btn_').html('&nbsp; Login');
                        $('#alert_box').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+ result +' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div>');
                        $('#username_email').val(data.username);
                    }
            }
        });

    });
});

$(document).ready(function (){

    $('#challengeBtn').bind('click', function (e) {
        e.preventDefault();

        var code = $('code').val();

        $.ajax({
            type: 'POST',
            url: '/Engine/Ajax.php',
            data: {
                action: '2FAChallenge',
                code: code
            },
            beforeSend: function(){
                $('#challengeBtn').html('<i class="fa fa-spinner fa-spin"></i> &nbsp; Submitting Code...')
            },
            success: function (res) {
                if (res === 'true') {
                    showSuccessToasts("You are now logged in. Redirecting...");
                    setTimeout('window.location = "/";', 3000);
                } else {
                    showErrorToasts(result);
                        $('#challengeBtn').html('&nbsp; Submit');
                        $('#alert_box').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+ res +' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div>');
                }
              
            }
        });

    });
});

