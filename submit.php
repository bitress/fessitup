<?php
include 'Engine/E.php';



$user = ($login->_isLoggedIn()) ? $row['user_id'] : Misc::getUserIpAddr();

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

					<h1 class="h3 mb-3">Submit</h1>

					<div class="row">
						<div class="col-md-12 col-xl-10">

                        <div class="tab">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" href="#text-tab" data-bs-toggle="tab" role="tab">
											<i class="align-middle" data-feather="file-text"></i> Text
										</a>
									</li>
									<!-- <li class="nav-item">
										<a class="nav-link" href="#image-tab" data-bs-toggle="tab" role="tab">
											<i class="align-middle" data-feather="image"></i> Image
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#video-tab" data-bs-toggle="tab" role="tab">
											<i class="align-middle" data-feather="video"></i> Video
										</a>
									</li> -->
									<li class="nav-item">
										<a class="nav-link" href="#link-tab" data-bs-toggle="tab" role="tab">
											<i class="align-middle" data-feather="link"></i> Link
										</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="text-tab" role="tabpanel">

                                        

											<div class="form-group mb-3">
											  <input type="text" class="form-control" name="title" id="cfs_title" aria-describedby="helpId" placeholder="Some title">
											</div>

											<div class="form-group mb-3">
											  <textarea class="form-control" name="post" id="cfs_content" rows="5" placeholder="Your post"></textarea>
											</div>

											<div class="form-group mb-3">
												<select class="form-control" id="category">
												<option selected disabled>Choose category</option>
												<?php $categories = $cfs->getCategoryList();
												foreach($categories as $category):
												?>
												<option value="<?= $category['category_id']; ?>"><?= $category['category_name']; ?></option>
												<?php endforeach; ?>
												</select>
											</div>

											<div class="form-group">
												<button class="btn btn-info" type="button" id="cfs_btn">Submit</button>
												<div class="err"></div>
											</div>


									</div>
									<!-- <div class="tab-pane" id="image-tab" role="tabpanel">
										<form>
											
											<div class="form-group">
											  <input type="text" name="title" id="title" class="form-control" placeholder="Some title" aria-describedby="helpId">
											</div>
										
										</form>
									</div> -->

									<div class="tab-pane" id="link-tab" role="tabpanel">
										
										<form>

											<div class="form-group">
												<label for=""></label>
												<input type="text" class="form-control" name="link" id="link" aria-describedby="helpId" placeholder="Enter the url">
											</div>
												
												<div class="form-group">
											<button type="button" id="link_btn" class="btn btn-primary">Submit</button>
											</div>

											<div id="err"></div>
											</form>
										

									</div>
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

	<script src="<?=BASE_URL?>/dist/js/app.js"></script>
    <script src="<?=BASE_URL?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?=BASE_URL?>/assets/js/confession.js"></script>
	<script src="<?=BASE_URL?>/assets/js/sha512.min.js"></script>

</body>

</html>