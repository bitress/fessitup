<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="#">
          <span class="align-middle">FessItUp</span>
        </a>

				<ul class="sidebar-nav">
				<li class="sidebar-item">
						<form class="d-lg-none d-xl-none d-lg-inline-block sidebar-link">
						<div class="input-group input-group-navbar">
							<input type="text" class="form-control" placeholder="Search…" aria-label="Search">
							<button class="btn" type="button">
								<i class="align-middle" data-feather="search"></i>
							</button>
						</div>
					</form>
				</li>

					<li class="sidebar-header">
						Home
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="/">
              <i class="align-middle" data-feather="home"></i> <span class="align-middle">Home</span>
            </a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="#">
              <i class="align-middle" data-feather="trending-up"></i> <span class="align-middle">Most Upvoted</span>
            </a>
					</li>


					<li class="sidebar-item">
						<a data-bs-target="#ui" data-bs-toggle="collapse" class="sidebar-link collapsed">
              <i class="align-middle" data-feather="folder"></i> <span class="align-middle">Category</span>
            </a>
						<ul id="ui" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
			<?php $categories = $cfs->getCategoryList();
					foreach($categories as $category):
					?>
					<li class="sidebar-item"><a class="sidebar-link" href="#"><?= $category['category_name']; ?></a></li>
			<?php endforeach; ?>
						</ul>
					</li>

					<li class="sidebar-header">
						Other Thingys
					</li>

					<?php
				if (Membership::isUserPremium()):
				?>
					<li class="sidebar-item">
						<a class="sidebar-link" href="#">
              <i class="align-middle" data-feather="shield"></i> <span class="align-middle">Premium</span>
            </a>
					</li>

					<?php
else:
?>

					<li class="sidebar-item">
						<a class="sidebar-link" href="#">
              <i class="align-middle" data-feather="shield"></i> <span class="align-middle">Try Premium</span>
            </a>
					</li>
					<?php
endif;
if (!$login->_isLoggedIn()):
?>

					<li class="sidebar-item">
						<a class="sidebar-link" href="/register">
              <i class="align-middle" data-feather="box"></i> <span class="align-middle">Login / Sign Up</span>
            </a>
					</li>
					<?php

endif;
?>



				</ul>

			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
					<i class="hamburger align-self-center"></i>
				</a>


				<form class="d-none d-sm-inline-block">
					<div class="input-group input-group-navbar">
						<input type="text" class="form-control" placeholder="Search…" aria-label="Search">
						<button class="btn" type="button">
              <i class="align-middle" data-feather="search"></i>
            </button>
					</div>
				</form>

				<div class="navbar-collapse">
					<ul class="navbar-nav navbar-align">
                    <?php
						if ($login->_isLoggedIn()):
						?>
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
								<div class="position-relative"> 
									<i class="align-middle" data-feather="bell"></i>
									<?php if ($notification->_countUnseen() > 0): ?>
									<span class="indicator"><?= $notification->_countUnseen(); ?></span>
									<?php endif; ?>
								</div>
							</a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
							<?php if ($notification->_countUnseen() > 0): ?>
								<div class="dropdown-menu-header">
								<?= $notification->_countUnseen(); ?> New Notifications
								</div>
								<?php else: ?>
									<div class="dropdown-menu-header">
										Notifications
								</div>
								<?php endif; ?>

								<div class="list-group">
	
									<?php
										$notification = $notification->_getAllNotification();
										    if (!empty($notification)):
												foreach ($notification as $notif):								  
										?>
									<?php if ($notif['type'] == 'smile'): ?>								  
									<a data-href="confession.php?id=<?= $notif['unique_id']; ?>" data-notif="<?= $notif['id']; ?>" class="notification list-group-item <?= ($notif['status'] == "0") ? 'bg-light' : '' ; ?>">
									<?php endif; ?>
										<div class="row g-0 align-items-center">
										<?php if (Notification::_notificationType($notif['type'])): ?>
											<div class="col-2">
												<i class="text-success" data-feather="smile"></i>
											</div>
											<?php endif; ?>
											<div class="col-10">
												<div class="text-dark">New <?= $notif['type']; ?></div>
												<div class="text-muted small mt-1"><?= $notif['message']; ?>.</div>
												<div class="text-muted small mt-1"><?= Misc::timeAgo($notif['datetime']); ?></div>
											</div>
										</div>
									</a>
									<?php endforeach; else: ?>
										<span class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-12">
												<div class="text-dark text-center">No New Notifications</div>
											</div>
										</div>
									</span>
									<?php endif; ?>
								</div>
								<div class="dropdown-menu-footer">
									<a href="/notifications.php" class="text-muted">Show all notifications</a>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
                           <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
								<img src="<?= BASE_URL ?>/uploads/<?= $row['profile_image']; ?>" class="avatar img-fluid rounded me-1" alt="" />
		       		</a>

                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
							<img src="<?= BASE_URL ?>/uploads/<?= $row['profile_image']; ?>" class="avatar img-fluid rounded me-1" alt="" />
              	  </a>
                            <div class="dropdown-menu dropdown-menu-end">
							<span class="dropdown-item-text">Hello, @<?=$row['username'];?></span>
								
								<a class="dropdown-item" href="/user/<?= htmlentities($row['username']); ?>"><i class="align-middle mr-1" data-feather="user"></i> Profile</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="/settings.php"><i class="align-middle mr-1" data-feather="settings"></i> Settings & Privacy</a>
								<a class="dropdown-item" href="#"><i class="align-middle mr-1" data-feather="help-circle"></i> Help Center</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="/logout.php">Log out</a>
							</div>
						</li>
                        <?php
else:
?>
                            <li class="nav-item">
                            <a name="login" id="login" class="btn btn-primary mr-1" href="/login" role="button">Login</a></a>
                            </li>
                            <li class="nav-item">
                            <a name="login" id="login" class="btn btn-warning ml-1" href="/register" role="button">Sign Up</a></a>
                            </li>
                        <?php
endif;
?>
					</ul>
				</div>
			</nav>