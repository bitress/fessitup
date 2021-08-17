<?php
include 'Engine/E.php';

if (!$login->_isLoggedIn()) {
    header('Location: /');
}
// $user = ($login->_isLoggedIn()) ? $row['user_id'] : Misc::getUserIpAddr();
$settings = new Settings();
$cfs = new Confession();


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

					<h1 class="h3 mb-3">Notifications</h1>

					<div class="row">
						<div class="col-md-8 col-xl-10">

						<table class="table table-hover">
						<tbody>
						<?php
							
							if (!empty($notification)):
								foreach ($notification as $notif):								  
						?>
							<tr class="notification" data-href="confession.php?id=<?= $notif['unique_id']; ?>" data-notif="<?= $notif['id']; ?>">
							<td><?= $notif['message']; ?></td>
							<td><?= Misc::timeAgo($notif['datetime']); ?></td>
							</tr>
						<?php endforeach; endif; ?>
						</tbody>
						</table>

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