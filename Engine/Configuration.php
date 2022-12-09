<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('DB_HOST', "localhost"); 
define('DB_TYPE', "mysql"); 
define('DB_USER', "root");  
define('DB_PASS', ""); 
define('DB_NAME', "fessitup"); 

// define('BASE_URL', 'http://192.168.43.160');
 define('BASE_URL', 'http://localhost:8080');
//define('BASE_URL','http://'. $_SERVER['HTTP_HOST'].'/fessitup');

define('SITE_NAME', 'FessItUp');

define('CHALLENGE_URL', BASE_URL . '/challenge.php');
define('EMAIL_CONFIRMATION', true); 

define('REGISTER_CONFIRM', BASE_URL .'/confirm.php');
define('PASSWORD_RESET', BASE_URL .'/reset-password.php');


define('MAILER', "smtp"); 

define('SMTP_HOST', "smtp.gmail.com"); 

define('SMTP_PORT', 465); 

define('SMTP_USERNAME', "itscyanne@gmail.com"); 

define('SMTP_PASSWORD', "@c1y2a0n1n0e2@"); 

define('SMTP_ENCRYPTION', "ssl"); 


define('MAX_LOGIN_ATTEMPTS', 12);

define('ENCRYPTION_KEY','xjE,-z_@FA>dmc5XKSjs!ck&QQF\W}A)');
define('UNIQUE_ID_LENGTH', rand(7, 18)); //Confession unique id length
define('BLANK_PASSWORD',
'cf83e1357eefb8bdf1542850d66d8007d620e4050b5715dc83f4a921d36ce9ce47d0d13c5d85f2b0ff8318d2877eec2f63b931bd47417a81a538327af927da3e'); //SHA512 blank hash

define('DEFAULT_LANGUAGE', "en");

date_default_timezone_set('Asia/Manila');