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
    <link href="<?= BASE_URL ?>/dist/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/my-login.css">
    <!-- <link rel="stylesheet" href="vendor/toastr/toastr.min.css"> -->
    <link rel="stylesheet" href="vendor/jquery-toast/src/jquery.toast.css">
    <script src="vendor/font-awesome/fontawesome-all.min.js"></script>

</head>
<body class="my-login-page">


<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9 my-5">
					<div class="card shadow-lg">
						<div class="card-body p-5">
              <h1 class="card-title">Login<?=(Cookie::_check('user')) ? ' as @' . htmlentities($username) . '' : '';?></h4>
								<div class="mb-3 <?=$d_none;?>">
									<label class="mb-2 text-muted" for="email">Username or Email</label>
                  <input type="hidden" id="token" name="token" value="<?=Session::get('csrf');?>">
									<input id="username_email" type="email" class="form-control" name="username_email" value="<?= $username ?>" autofocus>
								</div>

								<div class="mb-3">
									<div class="mb-2 w-100">
										<label class="text-muted" for="password">Password</label>
										<a type="button" class="float-end" data-bs-toggle="modal" data-bs-target="#forgotPassword" href="#">Forgot your password?</a>
									</div>
									<input id="password" type="password" class="form-control" name="password">
								</div>

								<div class="d-flex align-items-center mb-3">
									<div class="form-check <?=$d_none;?>">
										<input type="checkbox" name="remember" id="remember" class="form-check-input">
										<label for="remember" class="form-check-label">Remember Me</label>
									</div>

                  <button type="submit" name="login" id="_login_btn_" class="btn btn-primary ms-auto">
                    Login
                  </button>

                  <button type="submit" name="loginxx" id="btn-login" class="btn btn-primary ms-auto <?=$d_none1;?>">
                    Use another account?
                  </button>
								</div>
						</div>
						<div class="card-footer py-3 border-0">
							<div class="text-center">
								Don't have an account? <a href="/register.php" class="text-primary">Create One</a>
							</div>
						</div>
					</div>
					<div class="text-center mt-5 text-muted">
						Copyright &copy; 2017-2021 &mdash; Your Company 
					</div>
				</div>
			</div>
		</div>
	</section>

  <div class="modal fade" id="forgotPassword" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title">Forgot my Password</h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                    </div>
                                    <div class="modal-body m-3">
                                       <p class="mb-1">To continue, please enter your email for recovery.</p>
                                       <div class="form-group">
                                                <input type="email" id="forgotPasswordEmail" class="form-control" placeholder="Enter your Email">
                                             </div>
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" id="forgotPasswordBtn" data-bs-dismiss="modal" class="btn btn-primary">Reset Password</button>
                                    </div>
                                 </div>
                              </div>
                           </div>


  <script src="vendor/jquery/jquery.min.js"></script>
	<script src="<?= BASE_URL ?>/dist/js/app.js"></script>
  <script src="assets/js/toastr.js"></script>
  <script src="vendor/jquery-toast/src/jquery.toast.js"></script>
  <script src="assets/js/login.js"></script>
  <script src="assets/js/reset-password.js"></script>
  <script src="assets/js/sha512.min.js"></script>


</body>
</html>