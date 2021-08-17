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
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/my-login.css">
	<link rel="stylesheet" href="vendor/jquery-toast/src/jquery.toast.css">
    <script src="vendor/font-awesome/fontawesome-all.min.js"></script>
   
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="img/logo.jpg" alt="bootstrap 4 login page">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Register</h4>
							<form method="POST" novalidate="">

									<div id="error"></div>

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
									<button type="button" name="signup" id="signup" class="btn btn-primary btn-block">
										Register
									</button>
								</div>
								<div class="mt-4 text-center">
									Already have an account? <a href="login.php">Login</a>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
                    Copyright &copy; <?= date('Y'); ?> &mdash; Confessionally
                    </div>
				</div>
			</div>
		</div>
	</section>




	<script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="vendor/jquery-toast/src/jquery.toast.js"></script>
  <script src="assets/js/toastr.js"></script>
  <script src="assets/js/register.js"></script>
  <script src="assets/js/sha512.min.js"></script>
</body>
</html>