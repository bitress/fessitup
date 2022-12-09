<?php

use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthentication
{

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->user = new Login;
        $this->google2fa = new Google2FA();
        $this->id = Session::get('user_login');
    }

    public function _2FA()
    {
        $this->generateSecret();
        $data = array(
            'secretCode' => Session::get('shhh'),
            'QrURL' => $this->generateQrURL(),
        );

        echo json_encode($data);
    }

    public function _2faLogin($code)
    {

        $data = Session::get('why');
        $secretCode = Session::get('secret_key');

        if ($this->google2fa->verifyKey($secretCode, $code)) {

            // if (!empty($remember)) {
            //     Cookie::set('rmbrsr', Misc::_generateLoginString());
            // }

            Session::set('user_login', $data['user_login']);
            Session::set('fingerprint', Misc::_generateLoginString());
            Session::set('token', $data['token']);
            Cookie::_set('cu', $data['cu']);
            Session::set('erfcy', $data['erfcy']);
            $this->user->_updateUserSession($data['user_login']);
            return true;
        } else {
            echo "Incorrect code";
            return false;
        }

    }

    /**
     * Generate a secret key for 2FA
     */

    public function generateSecret() {

        Session::set('shhh', $this->google2fa->generateSecretKey());
    }

    /**
     * Generate OTP Url
     * @return string Return string url
     */
    public function generateQrURL()
    {

        $secret = Session::get('shhh');

        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            SITE_NAME,
            base64_decode(Session::get('erfcy')),
            $secret
        );

        return $qrCodeUrl;
    }


    /**
     * Verify user entered code by their secret key
     * @param string $code The code from the Authenticator App
     * @return boolean TRUE if code correct, FALSE OTHERWISE
     */

    public function verifyCode($code)
    {

        $secretCode = Session::get('secret_key');

        if ($this->google2fa->verifyKey($secretCode, $code)) {
            return true;
        }

    }

    /**
     * Verify secret key when turning on 2fa
     * @param string $secretCode User's secret key
     * @param string $code The code from the Authenticator App
     * @return TRUE 
     */

    public function enable2FA($secretCode, $code)
    {

        if ($this->google2fa->verifyKey($secretCode, $code)) {

            $sql = "UPDATE users SET secret_key = :key, is_2fa = '1' WHERE user_id = :u LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':key', $secretCode, PDO::PARAM_STR);
            $stmt->bindParam(':u', $this->id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                echo 'true';
            }
        }
    }

    /**

     * Disable 2Fa
     */

    public function disable2FA()
    {

        try {

            $sql = "UPDATE users SET secret_key = NULL, is_2fa = '0' WHERE user_id = :u LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':u', $this->id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                echo 'true';
            }

        } catch (Exception $e) {

            die('Oops! Theres an error');

        }

    }

    /**
     * Verify user by password
     */

    public function verifyUser($password)
    {
        $sql = "SELECT password FROM users WHERE user_id = :i";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':i', $this->id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            $userPass = $row['password'];
            if ($this->user->verifyPassword($password, $userPass)) {
                echo "lol";
            }
        }
    }

}
