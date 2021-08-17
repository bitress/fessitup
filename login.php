<?php
require 'Engine/E.php';
CSRF::generate();
$d_none = (!Cookie::_check('user')) ? '' : 'd-none';
$d_none1 = (Cookie::_check('user')) ? '' : 'd-none';
$username = (Cookie::_check('user')) ? $row['username'] : '';
if ($login->_isLoggedIn()) {
    header('Location: /');
}
if (isset($_POST['loginxx'])) {
    Cookie::_destroy('user');
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
              <h4 class="card-title">Login<?=(Cookie::_check('user')) ? ' as @' . htmlentities($username) . '' : '';?></h4>

              <form method="POST" id="__login__"  novalidate="">
              <div id="alert_box"></div>

              <input type="hidden" id="token" name="token" value="<?=Session::get('csrf');?>">
                <div class="form-group <?=$d_none;?>">
                  <label for="email">Username or E-mail</label>
                  <input id="username_email" type="text" class="form-control" name="username_email" value="<?=$username;?>" required>
                  <small id="usernamehelpLine" class="text-muted">
                    Your username or email adress.
                  </small>
                </div>

                <div class="form-group">
                  <label for="password">Password
                    <a data-toggle="modal" data-target="#fp" class="float-right">
                      Forgot password?
                    </a>
                  </label>
                  <input id="password" type="password" class="form-control" value="" name="password" required data-eye>
                  <small id="usernamehelpLine" class="text-muted">
                    Your password.
                  </small>
                </div>

                <div class="form-check form-group <?=$d_none;?>">
                  <div class="custom-checkbox custom-control">
                    <label class="form-check-label">
                      <input class="form-check-input" name="remember" id="remember" type="checkbox">
                      <span class="form-check-sign"></span>
                      I'll remember you?
                    </label>
                  </div>
                </div>
                <div class="form-group m-0">
                  <button type="submit" name="login" id="_login_btn_" class="btn btn-primary btn-block">
                    Login
                  </button>

                  <button type="submit" name="loginxx" id="btn-login" class="btn btn-primary btn-block <?=$d_none1;?>">
                    Use another account?
                  </button>

                </div>
                <div class="mt-4 text-center">
                  Don't have an account? <a href="#">Register</a>
                </div>
              </form>
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
  <script src="assets/js/login.js"></script>
  <script src="assets/js/sha512.min.js"></script>


</body>
</html>