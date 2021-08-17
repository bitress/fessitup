<?php
include 'Engine/E.php';
CSRF::generate();
if (!$login->_isLoggedIn()) {
	header('Location: /');
}
$cfs = new Confession();


$birthyear = date('Y', strtotime($row['birthdate']));
$birthmonth = date('n', strtotime($row['birthdate']));
$birthday = date('j', strtotime($row['birthdate']));

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
      <meta name="author" content="AdminKit">
      <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
      <link rel="shortcut icon" href="img/icons/icon-48x48.png" />
      <title>Settings | FessItUp</title>
      <link href="<?=BASE_URL?>/dist/css/app.css" rel="stylesheet">
      <link rel="stylesheet" href="<?=BASE_URL?>/assets/css/style.css">
      <link rel="stylesheet" href="<?= BASE_URL ?>/vendor/jquery-toast/src/jquery.toast.css">
      <style>
/* 
         #qrcode {
            height: 160px;
            width: 160px;
            margin-top: 15px;
         } */

      </style>
   </head>
   <body>
      <div class="wrapper">
         <?php
            include 'includes/header.inc.php';
            ?>
         <main class="content">
            <div class="container-fluid p-0">
               <h1 class="h3 mb-3">Settings</h1>
               <div class="row">
                  <div class="col-md-3 col-xl-2">
                     <div class="card">
                        <div class="card-header">
                           <h5 class="card-title mb-0">Profile Settings</h5>
                        </div>
                        <div class="list-group list-group-flush" role="tablist">
                           <a class="list-group-item list-group-item-action active" data-bs-toggle="tab" data-bs-target="#accounttab" role="tab"> 
                           Account</a>
                           <a class="list-group-item list-group-item-action" data-bs-toggle="tab" data-bs-target="#passwordtab" role="tab">
                           Password
                           </a>
                           <a class="list-group-item list-group-item-action" data-bs-toggle="tab" data-bs-target="#privacytab" role="tab">
                           Privacy and Security
                           </a>
                           <a class="list-group-item list-group-item-action" data-bs-toggle="tab" data-bs-target="#notificationtab" role="tab">
                           Notifications
                           </a>
                           <a class="list-group-item list-group-item-action" data-bs-toggle="tab" data-bs-target="#" role="tab">
                           Delete account
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-9 col-xl-10">
                     <div class="tab-content">
                        <div class="tab-pane fade show active" id="accounttab" role="tabpanel">
                           <div class="card">
                              <div class="card-header">
                                 <h5 class="card-title mb-0">Public info</h5>
                                 <small>This is shown to other users, unless you permit them.</small>
                              </div>
                              <div class="card-body">
                                 <form id="publicInfoForm" enctype="multipart/form-data">
                                    <div class="row">
                                       <div class="col-md-8">
                                          <div class="mb-3">
                                             <label class="form-label" for="inputUsername">Username</label>
                                             <input type="text" class="form-control-plaintext" id="inputUsername" value="<?=htmlentities($row['username']);?>" placeholder="Username" readonly>
                                             <small id="usernamehelpLine" class="text-muted">
                                             Username cannot be changed.
                                             </small>
                                          </div>
                                          <div class="mb-3">
                                             <label class="form-label" for="inputUsername">Biography</label>
                                             <textarea rows="2" class="form-control" name="bio" id="bio" placeholder="Tell something about yourself"><?=htmlentities($row['bio'])?></textarea>
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="mb-3">
                                             <div class="text-center">
                                                <img alt="<?=htmlentities($row['first_name'] . ' ' . $row['last_name']);?>" src="<?= BASE_URL ?>/uploads/<?= $row['profile_image']; ?>" class="rounded-circle img-responsive mt-2" width="128" height="128" />
                                                <div class="mt-2">
                                 <form ></form>
                                 <input type="file" class="form-control" name="avatar" id="avatar">
                                 </div>
                                 </div>
                                 </div>
                                 </div>
                                 </div>
                                 <button type="submit" id="public_info_btn" class="btn btn-primary">Save changes</button>
                                 <!-- <input type="submit" id="public_info_btn" class="btn btn-primary" value="Save changes"> -->
                                 </form>
                              </div>
                           </div>
                           <div class="card">
                              <div class="card-header">
                                 <h5 class="card-title mb-0">Private info</h5>
                                 <small>This is optional. You may not enter all your private informations.</small>
                              </div>
                              <div class="card-body">
                                 <form>
                                    <input type="hidden" name="token" id="PItoken" value="<?= Session::get('csrf'); ?>">
                                    <div class="row">
                                       <div class="mb-3 col-md-6">
                                          <label class="form-label" for="inputFirstName">First name</label>
                                          <input type="text" name="first_name" class="form-control" id="firstname" value="<?=htmlentities($row['first_name'])?>" placeholder="First name">
                                       </div>
                                       <div class="mb-3 col-md-6">
                                          <label class="form-label" for="inputLastName">Last name</label>
                                          <input type="text" name="last_name" class="form-control" id="lastname" value="<?=htmlentities($row['last_name'])?>" placeholder="Last name">
                                       </div>
                                    </div>
                                    <div class="row">
                                       <label for="birthday">Birthdate</label>
                                       <div class="mb-3 col-md-4">
                                          <select name="birth_month" id="birthmonth" class="form-control">
                                             <?php for( $m=1; $m<=12; ++$m ): $month_label = date('F', mktime(0, 0, 0, $m, 1)); $current = date('n');?>
                                             <option value="<?= $m; ?>"<?= $birthmonth == $m ? ' selected' : ''?>><?php echo $month_label; ?></option>
                                             <?php endfor; ?>
                                          </select>
                                       </div>
                                       <div class="mb-3 col-md-2">
                                          <select name="birth_day" id="birthday" class="form-control">
                                             <?php 
                                                for( $j=1; $j<=31; $j++ ): ?>
                                             <option value="<?= $j; ?>"<?= $birthday == $j ? ' selected' : ''?>><?= $j; ?></option>
                                             <?php endfor;?>
                                          </select>
                                       </div>
                                       <div class="mb-3 col-md-2">
                                          <select name="birth_year" id="birthyear" class="form-control">
                                             <?php $year = 2004; $min = $year - 60;$max = $year;for( $i=$max; $i>=$min; $i-- ):?>
                                             <option value="<?= $i; ?>"<?= $birthyear == $i ? ' selected' : ''?>><?= $i; ?></option>
                                             <?php endfor; ?>
                                          </select>
                                       </div>
                                    </div>
                                    <button type="submit" id="private_info_btn" class="btn btn-primary">Save changes</button>
                                 </form>
                              </div>
                           </div>
                           <div class="card">
                              <div class="card-header">
                                 <h5 class="card-title mb-0">Email info</h5>
                                 <small>This is for your contact informations.</small>
                              </div>
                              <div class="card-body">
                                 <form>
                                    <input type="hidden" name="token" id="emailtoken" value="<?= Session::get('csrf') ?>">
                                    <div class="mb-3">
                                       <label class="form-label" for="inputEmail4">Email</label>
                                       <input type="email" class="form-control" id="email" value="<?= htmlentities($row['email']) ?>" placeholder="Email">
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label" for="inputPasswordCurrent">Confirm password</label>
                                       <input type="password" class="form-control" id="password">
                                       <small><a href="#">Forgot your password?</a></small>
                                    </div>
                                    <button type="submit" id="email_info_btn" class="btn btn-primary">Save changes</button>
                                 </form>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="passwordtab" role="tabpanel">
                           <div class="card">
                              <div class="card-body">
                                 <h5 class="card-title">Password</h5>
                                 <form method="POST">
                                    <input type="hidden" id="psktoken" name="token" value="<?= Session::get('csrf'); ?>">
                                    <div class="mb-3">
                                       <label class="form-label" for="inputPasswordCurrent">Current password</label>
                                       <input type="password" class="form-control" id="currentpassword">
                                       <small><a href="#">Forgot your password?</a></small>
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label" for="inputPasswordNew">New password</label>
                                       <input type="password" class="form-control" id="newpassword">
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label" for="inputPasswordNew2">Verify password</label>
                                       <input type="password" class="form-control" id="confirmpassword">
                                    </div>
                                    <button type="submit" id="change_password_btn" class="btn btn-primary">Save changes</button>
                                 </form>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="privacytab" role="tabpanel">
                           <div class="card">
                              <div class="card-body">
                                 <h5 class="card-title">Privacy and Security</h5>
                                 <form>
                                    <div class="row">
                                       <div class="col-6">
                                          <div class="form-check">
                                             <input class="form-check-input" type="checkbox"  id="public_confession" <?=$row['confession_public'] == '1' ? 'checked' : '';?>>
                                             <label class="form-check-label" for="flexCheckDefault">
                                             Do you want the public to see your confessions?
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <input class="form-check-input" type="checkbox"  id="commentable_confession" <?=$row['confession_commentable'] == '1' ? 'checked' : '';?>>
                                             <label class="form-check-label" for="flexCheckDefault">
                                             Do you want other people comment on your confession?
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <input class="form-check-input" type="checkbox"  id="confession_searchable" <?=$row['searchable_confession'] == '1' ? 'checked' : '';?>>
                                             <label class="form-check-label" for="flexCheckDefault">
                                             Do you want other people search your confession?
                                             </label>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <div class="form-check">
                                             <input class="form-check-input" type="checkbox"  id="public_profile" <?=$row['visitable_profile'] == '1' ? 'checked' : '';?>>
                                             <label class="form-check-label" for="flexCheckDefault">
                                             Is your profile visitable?
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <input class="form-check-input" type="checkbox"  id="searchable_profile" <?=$row['searchable_profile'] == '1' ? 'checked' : '';?>>
                                             <label class="form-check-label" for="flexCheckDefault">
                                             Do you want your profile searchable?
                                             </label>
                                          </div>
                                       </div>
                                    </div>
                                    <button type="button" id="privacyNsecurity_btn" class="btn btn-primary">Save changes</button>
                                 </form>
                              </div>
                           </div>

                           <div class="card">
                              <div class="card-body">
                                 <h5 class="card-title">Advanced Security</h5>
                                 <form>
                                    <div class="row">
                                       <div class="col-6">
                                          <?php if ($row['is_2fa'] == '1'): ?>
                                          <div class="form-group">
                                            <button type="button" class="btn btn-danger">Disable two-factor authentication</button>
                                          </div>
                                          <?php else: ?>
                                          <div class="form-group">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#validatePass">Use two-factor authentication</button>
                                          </div>
                                          <?php endif; ?>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                           </div>

                        </div>
                        <div class="tab-pane fade" id="notificationtab" role="tabpanel">
                           <div class="card">
                              <div class="card-body">
                                 <form>
                                    <div class="row">
                                       <div class="col-6">
                                          <div class="card-text mb-2">Activity</div>
                                          <div class="form-check">
                                             <input class="form-check-input" type="checkbox"  id="">
                                             <label class="form-check-label" for="flexCheckDefault">
                                             Smiles on your posts
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <input class="form-check-input" type="checkbox"  id="">
                                             <label class="form-check-label" for="flexCheckDefault">
                                             Comments on your posts
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <input class="form-check-input" type="checkbox"  id="">
                                             <label class="form-check-label" for="flexCheckDefault">
                                             Replies on your comments
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <input class="form-check-input" type="checkbox"  id="">
                                             <label class="form-check-label" for="flexCheckDefault">
                                             New followers
                                             </label>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <div class="card-text mb-2">Messages</div>
                                          <div class="form-check">
                                             <input class="form-check-input" type="checkbox"  id="" >
                                             <label class="form-check-label" for="flexCheckDefault">
                                             Chat messages
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <input class="form-check-input" type="checkbox"  id="" >
                                             <label class="form-check-label" for="flexCheckDefault">
                                             Chat requests
                                             </label>
                                          </div>
                                       </div>
                                    </div>
                                    <button type="button" id="notification_btn" class="btn btn-primary">Save changes</button>
                                 </form>
                              </div>
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
      <!-- Modal -->
         <div class="modal fade" id="validatePass" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Set up two-factor authentication</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body m-3">
													<p class="mb-0">To continue, please enter your password for verification.</p>
                                       <div class="form-group">
                                                <input type="password" id="2fapasswordverify" class="form-control" placeholder="Enter your Password">
                                             </div>
												</div>
												<div class="modal-footer">
													<button type="button" id="verifyPassBtn" data-bs-dismiss="modal" class="btn btn-primary">Confirm</button>
												</div>
											</div>
										</div>
									</div>

         <div class="modal fade" id="2FASetup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Set up two-factor authentication</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body m-3">
													<p class="mb-0">Now, Let's get started.</p>
                                      <div class="form-group">
                                         <label for="secretKey">This is your secret key</label>
                                      <input type="text" readonly class="form-control-plaintext" id="secretKey" value="">
                                      </div>
                                       <div class="mb-3" id="qrcode"></div>
                                       <div class="form-group">
                                          <input type="number" class="form-control" name="6digitcode" id="6digitcode" placeholder=" Digit Verification Code">
                                             </div>
												</div>
												<div class="modal-footer">
													<button type="button" id="confirmSetup" class="btn btn-primary">Confirm</button>
												</div>
											</div>
										</div>
									</div>
      <script src="<?=BASE_URL?>/dist/js/app.js"></script>
      <script src="<?=BASE_URL?>/vendor/jquery/jquery.min.js"></script>
      <script src="<?= BASE_URL ?>/assets/js/toastr.js"></script>
      <script src="<?= BASE_URL ?>/vendor/jquery-toast/src/jquery.toast.js"></script>
      <script src="<?= BASE_URL ?>/vendor/qrcodejs/qrcode.min.js"></script>
      <script src="<?= BASE_URL ?>/assets/js/settings.js"></script>
      <script src="<?= BASE_URL ?>/assets/js/semanticdate.js"></script>
      <script src="<?= BASE_URL ?>/assets/js/sha512.min.js"></script>
   </body>
</html>