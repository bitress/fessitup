<?php 
include_once 'Engine/E.php';

if (!isset($_GET['key'])) {
    header('Location: /');
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

	<title>Messages | FessItUp</title>

	<link href="<?=BASE_URL?>/dist/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=BASE_URL?>/assets/css/style.css">
   
</head>

<body>
<div class="container">
            <div class="modal" id="confirm-modal">
                <div class="modal-dialog" >
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>FessItUp</h3>
                        </div>
                        <div class="modal-body">
                            <div class="well">
                                <?php 

                                $key = $_GET['key'];

                                $db = Database::getInstance();
                            $sql = "SELECT * FROM users WHERE confirmation_key = :key";
                                    $stmt = $db->prepare($sql);
                                    $stmt->bindParam(':key', $key, PDO::PARAM_STR);
                                    $stmt->execute();
                                        if ($stmt->rowCount() == 1) {
                                            $sql = "UPDATE users SET status = '1' WHERE confirmation_key = :key";
                                            $stmt = $db->prepare($sql);
                                            $stmt->bindParam(':key', $key, PDO::PARAM_STR);
                                            if($stmt->execute()) {

                                                echo '<p>Thank you for registering, you account has been activated.
                                                <br> Click <a href="/login">here</a> to login.
                                            </p>';

                                            } else {
                                                echo ' There must be an error confirming your account!';
                                            }
                                        } else {
                                            echo ' <p>Oops! Sorry, the key with this user does not exists.</p>';

                                        }

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


	<script src="<?=BASE_URL?>/dist/js/app.js"></script>
    <script src="<?=BASE_URL?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?=BASE_URL?>/assets/js/confession.js"></script>
	<script src="<?=BASE_URL?>/assets/js/message.js"></script>
    
    <script>
        var myModal = new bootstrap.Modal(document.getElementById('confirm-modal'),
         {
        keyboard: false,
        backdrop: 'static'
        })
        myModal.show()
    </script>

</body>

</html>