<?php
include 'Engine/E.php';

if (!$login->_isLoggedIn()) {
    header('Location: /');
}
// $user = ($login->_isLoggedIn()) ? $row['user_id'] : Misc::getUserIpAddr();
$settings = new Settings();
$cfs = new Confession();

if (isset($_GET['username'])):
	$uriUsername = $_GET['username'];
else:
	$uriUsername = $row['username'];
endif;

if ($settings->checkUsername($row['username'], $uriUsername)) {
   $res = $login->_getUserDetails(Session::get('token'));
} else {
	if ($settings->isProfilePublic($login->_getID($uriUsername))) {
		$res = $login->getUserData($uriUsername);
	}
	// $res = $login->_getUserDetails(Session::get('token'));
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<title>Confession | FessItUp</title>

	<link href="<?= BASE_URL ?>/dist/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <script>
    //User ID
    var user = '<?php echo $user; ?>';
  </script>
</head>

<body>
	<div class="wrapper">
	
		<?php include 'includes/header.inc.php'; ?>

		<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Profile</h1>

					<div class="row">
						<div class="col-md-4 col-xl-3">
							<div class="card mb-3">
								<div class="card-header">
									<h5 class="card-title mb-0">Profile Details</h5>
								</div>
								<div class="card-body text-center">
									<img src="<?= BASE_URL ?>/uploads/<?= $row['profile_image']; ?>" alt="<?=htmlentities($row['first_name'] . ' ' . $row['last_name']);?>" class="img-fluid rounded-circle mb-2" width="128" height="128" />
									<?php if (!empty($res['first_name'] && $res['last_name'])): ?>
									<h5 class="card-title mb-0"><?= $res['first_name'] .' '. $res['last_name'] ?></h5>
									<div class="text-muted mb-2">@<?= $res['username'] ?></div>
									<?php else: ?>
										<h5 class="card-title mb-0">@<?= $res['username'] ?></h5>
									<?php 
								endif; 
								
								if (!$settings->checkUsername($row['username'], $uriUsername)):
								?>
									<div>
										<a class="btn btn-primary btn-sm" href="#">Follow</a>
										<a class="btn btn-primary btn-sm" href="#"><span data-feather="message-square"></span> Message</a>
									</div>
									<?php endif; ?>
								</div>
								<hr class="my-0" />
								<div class="card-body">
									<h5 class="h6 card-title">Bio</h5>
								<div class="card-text text-md-center"><?= htmlentities($res['bio']); ?></div>
								</div>
								<hr class="my-0" />
								<div class="card-body">
									<h5 class="h6 card-title">About</h5>
									<ul class="list-unstyled mb-0">
									<?php if ($res['birthdate'] != '0000-00-00'): ?>
										<li class="mb-1"><span data-feather="gift" class="feather-sm mr-1"></span> Born on <a href="#" class="text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= htmlentities(User::_getAge($res['birthdate'])); ?> years old"><?= htmlentities(date('F j, Y', strtotime($res['birthdate']))); ?></a></li>
										<?php endif; ?>
										<li class="mb-1"><span class="mr-1"><i class="fas fa-birthday-cake"></i></span> Cake day <a href="#" class="text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= Misc::timeAgo($res['date_created']); ?>"><?= htmlentities(date('F j, Y', strtotime($res['date_created']))); ?></a></li>
									</ul>
								</div>
							</div>
						</div>


						<div class="col-md-8 col-xl-9">
							<div class="card">
								<div class="card-header">

									<h5 class="card-title mb-0">My Activities</h5>
								</div>
								<div class="card-body h-100">

								<?php 
								
								$confession = $cfs->getConfessionByUser($res['user_id']);

										if (!empty($confession)):
											foreach($confession as $fess):

												$fess['title'] = 	$encryption->decryptString($fess['title']);
												$fess['message'] = 	$encryption->decryptString($fess['message']);
												
											
								?>
									<div class="d-flex align-items-start">
										<img src="/dist/img/avatars/avatar.jpg" width="36" height="36" class="rounded-circle mr-2" alt="Charles Hall">
										<div class="flex-grow-1">
											<small class="float-right text-navy"><?=Misc::timeAgo($fess['date_posted']);?></small>
											<strong><?= htmlentities($res['first_name'] . ' '. $res['last_name']); ?></strong> posted <?= htmlentities($fess['title']); ?><br />
											<small class="text-muted"><?= Misc::relativeDate(strtotime($fess['date_posted'])); ?></small>

											<div class="text-sm text-muted p-2 mt-1">
												<?= htmlentities($fess['message']); ?>
												</div>

											<a href="#" class="btn btn-sm btn-danger mt-1"><i class="feather-sm" data-feather="heart"></i> Like</a>
										</div>
									</div>

									<hr />

									<?php endforeach; endif;?>
								
									<a href="#" class="btn btn-primary btn-block">Load more</a>
								</div>
							</div>
						</div>
					</div>

				</div>
			</main>

			
			<?php
			include 'includes/footer.inc.php';
		?>
		</div>
	</div>

	<script src="<?= BASE_URL ?>/dist/js/app.js"></script>
    <script src="<?= BASE_URL ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/confession.js"></script>
	<script src="<?= BASE_URL ?>/assets/js/sha512.min.js"></script>

</body>

</html>