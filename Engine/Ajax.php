<?php
include_once 'E.php';

    if (isset($_POST['action']) && !empty($_POST['action'])) {
        $action = $_POST['action'];
    switch ($action) {
        case 'test':
            $con = new Confession;
                $con->_test();
            
            break;

        // case 'postLink':
        //     $con = new Confession;
        //         $con->postLink($_POST['link']);
        //     break;
        case 'smile':
            $con = new Vote;
                $con->makeSmile($_POST['id'], $_POST['user']);
            break;
        case 'delSmile':
            $con = new Vote;
                $con->deleteSmile($_POST['id'], $_POST['user']);
            break;  
        case 'userLogin':
            $con = new Login;
                $login = $con->userLogin($_POST['un'], $_POST['pw'], $_POST['token'], $_POST['remember']);
                    if($login === true){
                        echo "true";
                    }
            break;
        case 'userRegister':
            $con = new Register;
                $register = $con->userRegister($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm_password'], $_POST['math_captcha']);
            
            break;
        case 'updatePassword':
            $con = new User;
            $update = $con->changePassword($_POST['oldpass'], $_POST['newpass'], $_POST['confirmpass'], $_POST['_token']);
                if ($update === true) {
                    echo "true";
                }
            break;
        case 'PasswordReset':
            $con = new PasswordReset;
            $reset = $con->RequestResetPassword($_POST['email']);
                if ($reset === true) {
                    echo "true";
                }
            break;
        case 'changePasswordbyReset':
            $con = new PasswordReset;
            $reset = $con->resetPassword($_POST['password'], $_POST['retype_password'], $_POST['reset_key']);
                if ($reset === true) {
                    echo "true";
                }
            break;
        case 'updateEmail':
            $con = new User;
            $update = $con->updateEmail($_POST['email'], $_POST['pass'], $_POST['_token']);
                if ($update === true) {
                    echo "true";
                }
            break;
        case 'UpdatePrivateDetails':
            $con = new User;
            $update = $con->updatePrivateUserDetails($_POST['firstname'], $_POST['lastname'], $_POST['birthdate'], $_POST['token']);
                if ($update === true) {
                   echo "true";
                }
            break;
        case 'UpdatePublicDetails':
            $con = new User;
            $avatar = !empty($_FILES['avatar']) ? $_FILES['avatar'] : '';
            $update = $con->updatePublicUserDetails($avatar, $_POST['bio'] );
                if ($update === true) {
                    echo "true";
                }
            break; 
        case 'UserPrivacySecurity':
            $con = new User;
               $update = $con->updateUserPrivacySettings($_POST['pc'], $_POST['cc'], $_POST['cs'], $_POST['pp'], $_POST['sp']);
            if ($update === true) {
                echo "true";
            }
            break; 
        case '2FAChallenge':
            $con = new TwoFactorAuthentication;
               $login = $con->_2faLogin($_POST['code']);
            if ($login === true) {
                Session::destroy('why');
                Session::destroy('challenge');
                echo "true";
            }
            break; 
        case 'verifyUser':
            $con = new TwoFactorAuthentication;
               $con->verifyUser($_POST['password']);
            break; 
        case '2FA':
            $con = new TwoFactorAuthentication();
               $con->_2FA();
            break; 
        case 'verifySecretKey':
            $con = new TwoFactorAuthentication();
               $con->enable2FA($_POST['secretKey'], $_POST['code']);
            break; 

        case 'Disable2FA':
             $con = new TwoFactorAuthentication();
              $con->disable2FA();
            break; 
        case 'markAsRead':
            $con = new Notification;
                $con->seenNotif($_POST['id']);
            break; 
        case 'sendMessage':
            $con = new Message;
                $con->sendMessage($_POST['receiver'], $_POST['msg']);
            break; 

        default:
            # code...
            break;
    }
}
?>