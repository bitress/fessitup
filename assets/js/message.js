$(document).ready(function() {
    $('#send_btn').bind('click', function (e) {
        e.preventDefault();
        var message = $('#messageForm').val();
        var receiver = $('#og').val();

        if (message === '') {
            alert('empty field');
            return;
            
        }

        $.ajax({
            type: 'POST',
            url: '/Engine/Ajax.php',
            data: {
                action: 'sendMessage',
                msg: message,
                receiver: receiver
            },
            success: function(){
                location.reload();
            }
        });

    });

});