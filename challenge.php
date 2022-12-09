<?php
require 'Engine/E.php';
if ($login->_isLoggedIn()) {
  header('Location: /');
}

if (!Session::check('challenge')) {
  header('Location: /login');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/my-login.css">
    <!-- <link rel="stylesheet" href="vendor/toastr/toastr.min.css"> -->
    <link rel="stylesheet" href="vendor/jquery-toast/src/jquery.toast.css">
    <script src="vendor/font-awesome/fontawesome-all.min.js"></script>

</head>
<body class="my-login-page">

<section class="h-100">
    <div class="container h-100">
      <div class="row justify-content-md-center h-100">
        <div class="card-wrapper">
          <div class="brand">
            <img src="#" alt="logo">
          </div>

          <div class="card fat">
            <div class="card-body">
              <h4 class="card-title">Challenge</h4>
              <div id="alert_box"></div>

                <div class="form-group">
                    <p>You have turned on Two Factor Authentication</p>
                </div>

                <div class="form-group">
                  <label for="code">Code </label>
                  <input id="code" type="number" class="form-control" value="" name="code">
                </div>

                <div class="form-group m-0">
                  <button type="button" name="challengeBtn" id="challengeBtn" class="btn btn-primary btn-block">
                    Submit Code
                  </button>     
                </div>
                <div class="mt-4 text-center">
                  Not your account? <a href="/login">Login</a>
                </div>
            </div>
          </div>





          <div class="footer">
            Copyright &copy; <?=date('Y');?> &mdash; Confessionally
          </div>
        </div>
      </div>
    </div>
  </section>




  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/toastr.js"></script>
  <script src="vendor/jquery-toast/src/jquery.toast.js"></script>
  <script src="assets/js/sha512.min.js"></script>
  <script src="assets/js/login.js"></script>



</body>
</html>