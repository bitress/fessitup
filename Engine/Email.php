<?php

    class Email {

        function sendEmailConfirmation($email, $key) {
            require_once '../vendor/phpmailer/PHPMailerAutoload.php';

            $mail = $this->_getMailer();

            $mail->addAddress($email);
    
            $link = REGISTER_CONFIRM . "?key=" . $key;
    
            $body = file_get_contents('../templates/confirmation-mail.php');
    
            $body = str_replace('{{website_name}}','FessItUp', $body);
            $body = str_replace('{{link}}',$link, $body);
    
            $mail->Subject = "FessItUp - Email Confirmation";
            $mail->Body    = $body;
    
            if( ! $mail->send() ) {
                echo 'Message could not be sent. ';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                exit;
            }
        }



         /**
     * Create and instance of PHPMailer class and prepare it for sending emails.
     * @return PHPMailer Instance of PHPMailer class.
     */
    private function _getMailer() {
        $mail = new PHPMailer;

        // if MAILER constant from config file is set to SMTP
        // configure mailer to send email via SMTP
        if ( MAILER == 'smtp' )
        {
            // $mail->isSMTP();

            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USERNAME;
            $mail->Password   = SMTP_PASSWORD;
            $mail->SMTPSecure = SMTP_ENCRYPTION;
        }

        // tell mailer that we are sending HTML email
        $mail->isHTML(true);

        $mail->From     = 'noreply@' . BASE_URL;
        $mail->FromName = 'FessItUp';
        $mail->addReplyTo('noreply@' . BASE_URL. 'FessItUp');

        return $mail;
    }

    }