<?php
require_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/Session.php';
include_once __DIR__ . '/Cookie.php';
include_once __DIR__ . '/Ajax.php';
include_once __DIR__ . '/Database.php';
include_once __DIR__ . '/Configuration.php';
include_once __DIR__ . '/CSRF.php';
include_once __DIR__ . '/Misc.php';
include_once __DIR__ . '/TwoFactorAuthentication.php';
include_once __DIR__ . '/Encrypt.php';
include_once __DIR__ . '/Email.php';
include_once __DIR__ . '/Confession.php';
include_once __DIR__ . '/Notification.php';
include_once __DIR__ . '/Vote.php';
include_once __DIR__ . '/User.php';
include_once __DIR__ . '/UserLogin.php';
include_once __DIR__ . '/PasswordReset.php';
include_once __DIR__ . '/UserRegister.php';
include_once __DIR__ . '/Membership.php';
include_once __DIR__ . '/Comment.php';
include_once __DIR__ . '/UserSettings.php';
// include_once __DIR__ . '/Messaging.php';


Session::_startSession(); //Start Session

$notification = new Notification;
$encryption = new Encrypt;

$login = new User();

if (Cookie::_check('user')) {
    $row = $login->_getUserDetails(Cookie::_get('user'));
}

if ($login->_isLoggedIn()) {
    $row = $login->_getUserDetails(Session::get('token'));
}
