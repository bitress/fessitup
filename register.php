<?php 
  include 'Engine/E.php';

if ($login->_isLoggedIn()) 
	header('Location: /');  
$register = new Register();
$register->_mathCaptcha();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="<?= BASE_URL ?>/dist/css/app.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor/jquery-toast/src/jquery.toast.css">
    <script src="vendor/font-awesome/fontawesome-all.min.js"></script>
   
</head>
<body class="my-login-page">

<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="logo" width="100">
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Register</h1>
							<form method="POST" novalidate="">

<div id="alert_box"></div>

<div class="form-group">
<label for="name">Username</label>
<input id="username" type="text" class="form-control" name="name" required autofocus>
<div class="invalid-feedback">
	What's your name?
</div>
</div>

<div class="form-group">
<label for="email">Email</label>
<input id="email" type="email" class="form-control" name="email" required>
<div class="invalid-feedback">
	Your email is invalid
</div>
</div>

<div class="form-group">
<label for="password">Password</label>
<input id="password" type="password" class="form-control" name="password" required data-eye>
<div class="invalid-feedback">
	Password is required
</div>
</div>

<div class="form-group">
<label for="password">Confirm Password</label>
<input id="confirm_password" type="password" class="form-control" name="confirm_password" required data-eye>
<div class="invalid-feedback">
	Password is required
</div>
</div>

<div class="form-group">
<label for="password">What is <?= Session::get('first_num') . ' + '. Session::get('second_num'); ?></label>
<input id="math_captcha" type="number" class="form-control" min="0" max="50" name="math_captcha" required>
</div>

<div class="form-group">
<div class="custom-checkbox custom-control">
	<input type="checkbox" name="agree" id="agree" class="custom-control-input" required="">
	<label for="agree" class="custom-control-label">I agree to the <a href="#">Terms and Conditions</a></label>
	<div class="invalid-feedback">
		You must agree with our Terms and Conditions
	</div>
</div>
</div>

<div class="form-group m-0">
<button type="button" name="signup" id="signup" class="btn btn-primary">
	Register
</button>
</div>

<div class="card-footer py-3 border-0">
							<div class="text-center">
							Already have an account? <a href="login.php">Login</a>
							</div>
						</div>
</form>
						</div>
					
						
					</div>
					<div class="text-center mt-5 text-muted">
						Copyright &copy; 2017-2021 &mdash; Your Company 
					</div>
				</div>
			</div>
		</div>
	</section>





	<script src="<?= BASE_URL ?>/dist/js/app.js"></script>
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/jquery-toast/src/jquery.toast.js"></script>
  <script src="assets/js/toastr.js"></script>
  <script src="assets/js/register.js"></script>
  <script src="assets/js/sha512.min.js"></script>
</body>
</html>