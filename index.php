<?php
include 'Engine/E.php';

$user = ($login->_isLoggedIn()) ? $row['user_id'] : Misc::getUserIpAddr();
$vote = new Vote();
$cfs = new Confession();

CSRF::generate();

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="admin kit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<title>Home | FessItUp</title>

	<link href="<?= BASE_URL ?>/dist/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <script>
    //User ID
    var user = '<?php echo $user; ?>';
  </script>
  <style>

 .loading-skeleton h1, .loading-skeleton h2, .loading-skeleton h3, .loading-skeleton h4, .loading-skeleton h5, .loading-skeleton h6, .loading-skeleton p, .loading-skeleton li, .loading-skeleton .btn, .loading-skeleton label, .loading-skeleton .form-control, .loading-skeleton .c {
	 color: transparent !important;
	 appearance: none;
	 -webkit-appearance: none;
	 background-color: #eee;
	 border-color: #eee;
}
 .loading-skeleton h1::placeholder, .loading-skeleton h2::placeholder, .loading-skeleton h3::placeholder, .loading-skeleton h4::placeholder, .loading-skeleton h5::placeholder, .loading-skeleton h6::placeholder, .loading-skeleton p::placeholder, .loading-skeleton li::placeholder, .loading-skeleton .btn::placeholder, .loading-skeleton label::placeholder, .loading-skeleton .form-control::placeholder {
	 color: transparent;
}
 @keyframes loading-skeleton {
	 from {
		 opacity: 0.4;
	}
	 to {
		 opacity: 1;
	}
}
 .loading-skeleton {
	 pointer-events: none;
	 animation: loading-skeleton 1s infinite alternate;
}
 .loading-skeleton img {
	 filter: grayscale(100) contrast(0%) brightness(1.8);
}
 
  </style>
</head>

<body>
	<div class="wrapper">
		
        <?php include 'includes/header.inc.php'; ?>

			<main class="content">
				<div class="container">

					<h1 class="h3 mb-3"><?php echo Misc::greetUser(!empty($row['username']) ? $row['username'] : 'Stranger');?> </h1>

					<div class="row">
						<div class="col-md-8">

			

						<!-- <div class="d-flex align-items-start pb-2 border border-dark">
						
							<img src="<?= BASE_URL ?>/uploads/<?= $row['profile_image']; ?>" width="50" height="50" class="rounded-circle mr-2 border-dark" alt="" srcset="">
							<div class="flex-grow-1">
							<div class="p-2 form-group">
								<input type="text" name="post" class="form-control" placeholder="Create a post" style="border-radius: 1rem;" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="post">
							</div>
							</div>
						</div> -->

						
			<div class="central-meta">
				<div class="new-postbox">
					<div class="newpst-input">

					<div class="mb-3">
						<input type="text" id="cfs_title" class="form-control" placeholder="Confession Title" input type="text" onclick="window.location.href = '/submit';">
					</div>           
					</div>
				</div>
				</div>

		

			<?php
			
			$settings = new Settings();
			$confession = $cfs->getAllConfessions();
			if (!empty($confession)):
			foreach ($confession as $fess):

				$title = 	$encryption->decryptString($fess['title']);
				$message = 	$encryption->decryptString($fess['message']);
				
			// if($cfs->isUrl($fess['unique_id'])):
?>

					<!-- TEXT  -->
			<div class="card mb-8" id="confession_<?=$fess['id'];?> confession">


				<div class="card-body">
					<div class="card-actions">
						<div class="dropdown show">
							<a href="#" class="float-end m-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static">
								<i class="align-middle c" data-feather="more-horizontal"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-end">
							<?php if($cfs->isConfessionOwned($fess['user'], $user)): ?>
								<a class="dropdown-item" href="#"><i class="align-middle" data-feather="edit-2"></i> Edit</a>
								<a class="dropdown-item" href="#"><i class="align-middle" data-feather="save"></i> Save</a>
							<?php endif; ?>
								<a class="dropdown-item" href="#"><i class="align-middle" data-feather="flag"></i> Report</a>
							</div>
						</div>
					</div>
					<h2 class="card-title"><?= htmlentities($title);?></h2>			 
					<hr class="mb-2 c" />
					<div class="flex-grow-1 c mb-2">
					<small class="float-end text-navy c"><?=Misc::timeAgo($fess['date_posted']);?></small>
						<small class="text-muted c"><?= Misc::relativeDate(strtotime($fess['date_posted'])); ?>  &dash; <a href="#" class="text-decoration-none c"><?= $fess['category_name'] ?></a></small>
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
					<button class="c smiled btn_<?=$fess['id'];?>" data-id="<?=$fess['id'];?>" data-score="<?=$fess['smile']?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Smiled">
					<span id="confession_<?=$fess['id'];?>"><?=$fess['smile']?></span> &nbsp; <i class="fas fas_<?=$fess['id'];?> fa-smile fa-fw fa-lg"></i>
				<!-- <label>Smiled</label> -->
					</button>
					<?php else: ?>
				<button class="c smile btn_<?=$fess['id'];?>" data-id="<?=$fess['id'];?>" data-score="<?=$fess['smile']?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Put a smile">
				<span id="confession_<?=$fess['id'];?>"><?=$fess['smile']?></span> &nbsp; <i class="far far_<?=$fess['id'];?> fa-smile fa-fw fa-lg"></i> 
					<!-- <label>Put a smile</label> -->
				</button>
				<?php endif;?>

				<span class="c text-muted" id="vote<?=$fess['id'];?>"></span>


				</div>

				<div class="c ml-auto">
				<span>12</span><button> <i class="far c fa-comments"></i></button>
				</div>
			</div>
			</div>
			<?php

				
				endforeach;
				endif;
				?>
	
			
				</div>


				<div class="col-md-4">
					<div class="card text-left">
					<div class="card-header">
								ADVERTISEMENT
							</div>
						<img class="card-img-top" src="/sample/1.jpg" alt="">
						<!-- <div class="card-body">
							<h4 class="card-title">Advertisement</h4>
							<p class="card-text">Body</p>
						</div> -->
						</div>

						<div class="card text-left">
						<img class="card-img-top" src="holder.js/100px180/" alt="">
						<div class="card-body">
							<h4 class="card-title">Advertisement</h4>
							<p class="card-text">Body</p>
						</div>
						</div>

						<div class="card text-left">
						<img class="card-img-top" src="holder.js/100px180/" alt="">
						<div class="card-body">
							<h4 class="card-title">Advertisement</h4>
							<p class="card-text">Body</p>
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
	<script src="<?= BASE_URL ?>/assets/js/login.js"></script>
	<script src="<?= BASE_URL ?>/assets/js/sha512.min.js"></script>		
</body>

</html>