<?php
include 'Engine/E.php';
$user = ($login->_isLoggedIn()) ? $row['user_id'] : Misc::getUserIpAddr();
$vote = new Vote();
$cfs = new Confession();
$comments = new Comment();

$confession_id = Misc::_filterString($_GET['id'], true);

$fess = $cfs->getConfessionByID($confession_id);

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
				<div class="container">

					<h1 class="h3 mb-3">Blank Page</h1>

					<div class="row">
						<div class="col-md-8">

                        <?php
if (!empty($fess)):

	
	$title = 	$encryption->decryptString($fess['title']);
	$message = 	$encryption->decryptString($fess['message']);

?>

<div class="card mb-8" id="confession_<?=$fess['id'];?> confession">


<div class="card-body">
	<div class="card-actions">
		<div class="dropdown show">
			<a href="#" class="float-end m-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static">
				<i class="align-middle" data-feather="more-horizontal"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-end">
				<?php if($login->_isLoggedIn()): ?>
					<a class="dropdown-item" href="#"><i class="align-middle" data-feather="edit-2"></i> Edit</a>
					<a class="dropdown-item" href="#"><i class="align-middle" data-feather="save"></i> Save</a>
				<?php endif; ?>
					<a class="dropdown-item" href="#"><i class="align-middle" data-feather="flag"></i> Report</a>
				</div>
			</div>
		</div>
		<h2 class="card-title"><?= htmlentities($title);?></h2>			 
		<hr class="mb-2" />
			<div class="flex-grow-1 mb-2">
			<small class="float-end text-navy"><?=Misc::timeAgo($fess['date_posted']);?></small>
				<small class="text-muted"><?= Misc::relativeDate(strtotime($fess['date_posted'])); ?>  &dash; <a href="#" class="text-decoration-none"><?= $fess['category_name'] ?></a></small>
				</div>
			<p class="card-text"><?= htmlentities($message); ?></p>
			<a href="/c/<?=Misc::_filterString($fess['unique_id']);?>" class="btn btn-sm btn-primary">Read More &rarr;</a>
		</div>
		<div class="card-footer text-muted d-flex justify-content-between bg-transparent border-top-0">

			<div class="d-flex">

			<?php
		//Check if the user or ip address already voted
		if ($vote->isUserSmiled($user, $fess['id'])):
		?>
			<button class="smiled btn_<?=$fess['id'];?>" data-id="<?=$fess['id'];?>" data-score="<?=$fess['smile']?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Smiled">
			<span id="confession_<?=$fess['id'];?>"><?=$fess['smile']?></span> &nbsp; <i class="fas fas_<?=$fess['id'];?> fa-smile fa-fw fa-lg"></i>
		<!-- <label>Smiled</label> -->
			</button>
			<?php else: ?>
		<button class="smile btn_<?=$fess['id'];?>" data-id="<?=$fess['id'];?>" data-score="<?=$fess['smile']?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Put a smile">
		<span id="confession_<?=$fess['id'];?>"><?=$fess['smile']?></span> &nbsp; <i class="far far_<?=$fess['id'];?> fa-smile fa-fw fa-lg"></i> 
			<!-- <label>Put a smile</label> -->
		</button>
		<?php endif;?>

		<span class="text-muted" id="vote<?=$fess['id'];?>"></span>


		</div>

		<div class="ml-auto">
		<span>12</span><button> <i class="far fa-comments"></i></button>
		</div>
		</div>
		</div>
                              <?php

endif;
?>

			<h3 class="mb-4 font-weight-light">Comments</h3>

	<?php 
	if(User::_isLoggedIn()):
	?>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<textarea name="comment" class="form-control" cols="5" id="comment"></textarea>
			<input type="hidden" name="confession_id" value="<?php echo $fess['id']; ?>">
			<input type="hidden" name="parent_id" value="NULL">
			<input type="submit" name="submit_btn">
		</form>
	<?php
 else:
	?>

<div class="justify-content bg-info d-flex">
<span>Login or Signup to comment</span>
<button class="btn btn-success b-4">Login</button>
<button class="btn btn-success ml-2">Sign Up</button>
</div>


	<?php 
	endif;
	?>
</div>

						<div class="col-md-4">
							<div class="card text-left">
								<img class="card-img-top" src="holder.js/100px180/" alt="">
								<div class="card-body">
								  <h4 class="card-title">Title</h4>
								  <p class="card-text">Body</p>
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