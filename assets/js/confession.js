$(document).ready(function () {
  $('#cfs_btn').click(function (e) {
    e.preventDefault();
    var mes = $('#cfs_content');
    var t = $('#cfs_title');
    var c = $('#category');

    if ($.trim(mes.val()) === "") {
      $('#err').html('<span>This field is required!</span>')
      return;
    }
    $.ajax({
      url: 'Engine/Ajax.php',
      type: 'post',
      data: {
        action: 'postCFS',
        msg: mes.val(),
        t: t.val(),
        c: c.val()
      },
      beforeSend: function () {
        $('#cfs_btn').html('<i class="fa fa-spinner fa-spin"></i> &nbsp; Confessing...')

      },
      success: function (res) {
        window.location.href = '/c/'+res;
      }
    });
  });
});

$(document).on('click', '.smile', function (e) {
  e.preventDefault();
  var id = $(this).data('id');
  $.ajax({
    type: "POST",
    url: "/Engine/Ajax.php",
    data: {
      action: "smile",
      id: id,
      user: user,
    },
    success: function (data) {
      if (data === "no") {
        $("#vote" + id).html("<p>You already voted!</p>")
        setTimeout(function () {
          $('#vote' + id).fadeOut('fast');
        }, 3000); // <-- time in milliseconds
      } else {
        location.reload();
        window.location.hash = "#confession_" + id;
      }

    }
  });
});


$(document).on('click', '.smiled',
  function (w) {
    w.preventDefault();
    var id = $(this).data('id');

    $.ajax({
      type: 'POST',
      url: '/Engine/Ajax.php',
      data: {
        action: 'delSmile',
        id: id,
        user: user
      },
      success: function (data) {
        location.reload();
        window.location.hash = "#confession" + id;
      }
    });
  });

$(document).on('click', '.notification', function () {

    var notif_id = $(this).data('notif');
    var target = $(this).data('href');
  
    $.ajax({
      type: 'POST',
      url: '/Engine/Ajax.php',
      data: {
        action: 'markAsRead',
        id: notif_id
      },
      success: function () {
        window.location.href = '/'+ target;
      }
    });
  });

setTimeout(function () {
  $('.loading-skeleton').removeClass('loading-skeleton');
  
}, 3000);