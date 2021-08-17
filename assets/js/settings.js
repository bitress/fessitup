$(document).ready(function () {
    $('#privacyNsecurity_btn').bind('click', function (e) {
    e.preventDefault();
    var pc = $("#public_confession").is(":checked") ? '1': '0';
    var cc = $("#commentable_confession").is(":checked") ? '1': '0';
    var cs = $("#confession_searchable").is(":checked") ? '1': '0';
    var pp = $("#public_profile").is(":checked") ? '1': '0';
    var sp = $("#searchable_profile").is(":checked") ? '1': '0';
    var token = $("#token").val();
 
    $.ajax({
        type: "POST",
        url: "/Engine/Ajax.php",
        data: {
          action: "UserPrivacySecurity",
          pc: pc,
          cc: cc,
          cs: cs,
          pp: pp,
          sp: sp,
          _token: token
        },
        beforeSend: function () {
          $('#privacyNsecurity_btn').html('<i class="fa fa-spinner fa-spin"></i> &nbsp; Saving changes...')

        },
        success: function(result) {
          
              if(result === "true"){
                showSuccessToasts("User settings has been updated!");      
                $('#privacyNsecurity_btn').html('&nbsp; Save changes');
              }
        }
    
      });
    });
});

$(document).ready(function () {
    $('#private_info_btn').bind('click', function (e) {
      e.preventDefault();
      var token = $('#PItoken').val();
      var firstname = $('#firstname').val();
      var lastname = $('#lastname').val();
      var birthmonth = $('#birthmonth').val();
      var birthday = $('#birthday').val();
      var birtyear = $('#birthyear').val();
      var birthdate = birtyear+'-'+birthmonth+'-'+birthday;

     $.ajax({
        type: "POST",
        url: "/Engine/Ajax.php",
        data: {
          action: "UpdatePrivateDetails",
          firstname: firstname,
          lastname: lastname,
          birthdate: birthdate,
          token: token
        },
        beforeSend: function () {
          $('#private_info_btn').html('<i class="fa fa-spinner fa-spin"></i> &nbsp; Saving changes...')

        },
        success: function(result) {
          
              if(result === "true"){
                showSuccessToasts("User details has been updated!");      
                $('#private_info_btn').html('&nbsp; Save changes');
              } else {
                showErrorToasts(result);
                $('#private_info_btn').html('&nbsp; Save changes')
                
              }
        }
     });
      
    });
});


$(document).ready(function (e) {
  $("#public_info_btn").on('click', function(e){
    e.preventDefault();

    var action = 'UpdatePublicDetails';
    var bio = $('#bio').val();

    var data = $('#avatar').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('avatar', data);
    form_data.append('action', action);
    form_data.append('bio', bio);

    $.ajax({
      type: 'POST',
      url: '/Engine/Ajax.php',
      data: form_data,
      dataType: 'text',
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function(data){
        $('#public_info_btn').html('<i class="fa fa-spinner fa-spin"></i> &nbsp; Saving changes...')
    

      },
      success: function(result){ 
        
        if(result === "true"){
          showSuccessToasts("User profile has been updated!");      
          $('#public_info_btn').html('&nbsp; Save changes');
        } else {
          showErrorToasts(result);
          $('#public_info_btn').html('&nbsp; Save changes')
          
        }      
      }
    });
   
  });
});


$(document).ready(function () {
  $('#email_info_btn').bind('click', function (e) {
  e.preventDefault();

    var currentpassword = $('#password');
    var email = $('#email');
    var token = $('#emailtoken');

    var data = {
      pass: currentpassword.val(),
      email: email.val(),
      token: token.val()
    };

    data.pass = CryptoJS.SHA512(data.pass).toString();
    $.ajax({
      type: 'POST',
      url: '/Engine/Ajax.php',
      data: {
          action: 'updateEmail',
          email: data.email,
          pass: data.pass,
          _token: data.token
      },
      beforeSend: function(){
          $('#email_info_btn').html('<i class="fa fa-spinner fa-spin"></i> &nbsp; Saving changes...')
      },
      success: function(result) {
              if(result === "true"){
                  showSuccessToasts("Your email has updated successfully!");
                  $('#email_info_btn').html('&nbsp; Save changes')
              } else {
                  showErrorToasts(result);
                  $('#email_info_btn').html('&nbsp; Save changes')
                  
              }
      }
    });
    

  });
});

$(document).ready(function () {
  $('#change_password_btn').bind('click', function (e) {
  e.preventDefault();

    var currentpassword = $('#currentpassword');
    var newpassword = $('#newpassword');
    var confirmpassword = $('#confirmpassword');
    var token = $('#psktoken');

    var data = {
      oldpass: currentpassword.val(),
      newpass: newpassword.val(),
      verifypass: confirmpassword.val(),
      token: token.val()
    };

    data.oldpass = CryptoJS.SHA512(data.oldpass).toString();
    data.newpass = CryptoJS.SHA512(data.newpass).toString();
    data.verifypass = CryptoJS.SHA512(data.verifypass).toString();

    $.ajax({
      type: 'POST',
      url: '/Engine/Ajax.php',
      data: {
          action: 'updatePassword',
          oldpass: data.oldpass,
          newpass: data.newpass,
          confirmpass: data.verifypass,
          _token: data.token
      },
      beforeSend: function(){
          $('#change_password_btn').html('<i class="fa fa-spinner fa-spin"></i> &nbsp; Saving changes...')
      },
      success: function(result) {
              if(result === "true"){
                  showSuccessToasts("Your password has updated successfully!");
                  $('#change_password_btn').html('&nbsp; Save changes')
              } else {
                  showErrorToasts(result);
                  $('#change_password_btn').html('&nbsp; Save changes')
                  
              }
      }
    });
    

  });
});

$(document).ready(function(e) {
  $('#verifyPassBtn').on('click', function () {
    var password = $('#2fapasswordverify').val();
    var setup = new bootstrap.Modal(document.getElementById('2FASetup'));
    var validatePass = new bootstrap.Modal(document.getElementById('validatePass'));
   
       validatePass.hide();
      

      password = CryptoJS.SHA512(password).toString();

      $.ajax({
        type: 'POST',
        url: '/Engine/Ajax.php',
        data: {
            action: 'verifyUser',
            password: password,
        },
        beforeSend: function(){
            $('#verifyPassBtn').html('<i class="fa fa-spinner fa-spin"></i> &nbsp; Wait...')
        },
        success: function(result) {
                if(result === "lol"){
                    
                   $.ajax({
                     type: 'POST',
                     url: '/Engine/Ajax.php',
                     data: {action: '2FA'},
                     dataType: 'json',
                     success: function (res) {
                      // $('#secretKey').html('This is your secret key: &nbsp;' + res.secretCode);
                      $('#secretKey').val(res.secretCode)
                      new QRCode(document.getElementById('qrcode'), res.QrURL)
                     }
                   });

                   setup.show();

                } else {
                  validatePass.show();
                    showErrorToasts('Incorrect Password');
                    $('#verifyPassBtn').html('&nbsp; Confirm')
                    
                }
        }
      });
  });
});

$(document).ready(function (){
  $('#confirmSetup').on('click', function () {

    var code = $('#6digitcode').val();
    var secretKey = $('#secretKey').val();

      $.ajax({
        type: 'POST',
        url: '/Engine/Ajax.php',
        data: {
          action: 'verifySecretKey',
          code: code,
          secretKey: secretKey
        },
        success: function (res) {
          if (res === 'true') {
            showSuccessToasts("You’re two-factor authenticated!");
            setup.hide();
            setTimeout(window.location.reload.bind(window.location), 3000);
          }
        }
      })

  });
});
