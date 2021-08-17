<?php
include 'Engine/E.php';

if (!$login->_isLoggedIn()) {
    header('Location: /');
}
$user = ($login->_isLoggedIn()) ? $row['user_id'] : Misc::getUserIpAddr();
$settings = new Settings();
$cfs = new Confession();

$msg = new Message();

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

	<title>Messages | FessItUp</title>

	<link href="<?=BASE_URL?>/dist/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=BASE_URL?>/assets/css/style.css">
    <script>
    //User ID
    var user = '<?php echo $user; ?>';
  </script>
</head>

<body>
	<div class="wrapper">

		<?php include 'includes/header.inc.php';?>

        <main class="content">
				<div class="container-fluid p-0">

					<div class="mb-3">
						<h1 class="h3 d-inline align-middle">Messages</h1>
					</div>

					<div class="card">
						<div class="row g-0">
							<div class="col-12 col-lg-5 col-xl-3 border-end">

								<div class="px-4 d-none d-md-block">
									<div class="d-flex align-items-center">
										<div class="flex-grow-1">
											<input type="text" class="form-control my-3" placeholder="Search...">
										</div>
									</div>
								</div>

								<?php

$userMessages = $msg->getUserAllMessages($user);

foreach ($userMessages as $mes):
    $name = (!empty($mes['first_name'] && !empty($mes['last_name']))) ? $mes['first_name'] . ' ' . $mes['last_name'] : $mes['username'];

    ?>

							<a href="/messages.php?id=<?=$mes['user_id'];?>" class="list-group-item list-group-item-action border-0">
										<div class="badge bg-success float-end">5</div>
										<div class="d-flex align-items-start">
											<img src="<?=BASE_URL?>/uploads/<?=$mes['profile_image'];?>" class="rounded-circle me-1" alt="Vanessa Tucker" width="40" height="40">
											<div class="flex-grow-1 ms-3">
												<?=$name;?>
												<div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
											</div>
										</div>
									</a>

									<?php endforeach;?>


								<hr class="d-block d-lg-none mt-1 mb-0" />
							</div>
							<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if (isset($id)):

    $og = $login->getUserByID($id);

    $username = (!empty($og['first_name'] && !empty($og['last_name']))) ? $og['first_name'] . ' ' . $og['last_name'] : $og['username'];

    ?>
								<div class="col-12 col-lg-7 col-xl-9">
									<div class="py-2 px-4 border-bottom d-none d-lg-block">
										<div class="d-flex align-items-center py-1">
											<div class="position-relative">
												<img src="<?=BASE_URL?>/uploads/<?=$og['profile_image'];?>" class="rounded-circle me-1" alt="Sharon Lessman" width="40" height="40">
											</div>
											<div class="flex-grow-1 ps-3">
												<strong><?=$username;?></strong>
												<div class="text-muted small"><em>Typing...</em></div>
											</div>
											<div>
												<button class="btn btn-primary btn-lg me-1 px-3"><i class="feather-lg" data-feather="phone"></i></button>
												<button class="btn btn-info btn-lg me-1 px-3 d-none d-md-inline-block"><i class="feather-lg"
														data-feather="video"></i></button>
												<button class="btn btn-light border btn-lg px-3"><i class="feather-lg" data-feather="more-horizontal"></i></button>
											</div>
										</div>
									</div>

									<div class="position-relative">
										<div class="chat-messages p-4">

										<?php

    $messages = $msg->getMessage($id, Session::get('user_login'));

    foreach ($messages as $mes):

        $name = (!empty($mes['first_name'] && !empty($mes['last_name']))) ? $mes['first_name'] . ' ' . $mes['last_name'] : $mes['username'];

        ?>

											<?php

        if ($mes['sender'] == $id):

        ?>


										<div class="chat-message-left pb-4">
													<div>
														<img src="<?=BASE_URL?>/uploads/<?=$mes['profile_image'];?>" class="rounded-circle me-1" alt="Sharon Lessman" width="40" height="40">
														<div class="text-muted small text-nowrap mt-2"><?=Misc::relativeDate(strtotime($mes['date_created']));?></div>
													</div>
													<div class="flex-shrink-1 bg-light rounded py-2 px-3 ms-3">
														<div class="font-weight-bold mb-1"><?=$name;?></div>
														<?=$mes['message']?>
													</div>
												</div>


												<?php else: ?>

												<div class="chat-message-right pb-4">
												<div>
													<img src="<?=BASE_URL?>/uploads/<?=$mes['profile_image'];?>" class="rounded-circle me-1" alt="Chris Wood" width="40" height="40">
													<div class="text-muted small text-nowrap mt-2"><?=Misc::relativeDate(strtotime($mes['date_created']));?></div>
												</div>
												<div class="flex-shrink-1 bg-light rounded py-2 px-3 me-3">
													<div class="font-weight-bold mb-1"><?=$name;?></div>
													<?=$mes['message']?>
												</div>
											</div>



											<?php
endif;
endforeach;

?>



									</div>
								</div>

								<div class="flex-grow-0 py-3 px-4 border-top">
									<div class="input-group">
									<input type="hidden" id="og" value="<?= $id; ?>">

										<textarea rows="3" class="form-control" id="messageForm"></textarea>
									</div>
									<button class="btn btn-primary" type="button" id="send_btn">Send</button>
								</div>

							</div>

							<?php

endif;

?>

						</div>
					</div>
				</div>
			</main>

			<?php
include 'includes/footer.inc.php';
?>
		</div>
	</div>

	<script src="<?=BASE_URL?>/dist/js/app.js"></script>
    <script src="<?=BASE_URL?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?=BASE_URL?>/assets/js/confession.js"></script>
	<script src="<?=BASE_URL?>/assets/js/message.js"></script>

</body>

</html>