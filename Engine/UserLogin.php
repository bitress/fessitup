<?php

   class Login {

        private $db;

        private $encrypt;

     
    
     public function __construct(){
      	 $this->db = Database::getInstance();
         $this->encrypt = new Encrypt();
     }


    /**
    * Login user with the provided email and password
    * @param string $email User's email or username
    * @param string $password User's password
    * @return boolean TRUE if login is successfull, FALSE if email or username is not found or password is incorrect
    */
    public function userLogin($email, $password, $csrf_token, $remember) {
        

        if(empty($email)){
            echo "Username or email is required.";
            return;
        }

        if($password == strval(BLANK_PASSWORD)){
            echo "Please enter your password.";
            return;
        }

      #  REMOVED DUE TO BUG
        if(CSRF::check($csrf_token)) {
            echo "Invalid Login Token.";
            return;
        }

        
        $sql = "SELECT * FROM users WHERE username = :u OR email = :u";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":u", $email, PDO::PARAM_STR);
                if($stmt->execute()) {
                    if($stmt->rowCount() == 1) {
                        if($row = $stmt->fetch()) {                            
                            $psk = $row['password'];
                            $id = $row['user_id'];
                            $usertoken = $row['token'];
                            $username = $row['username'];
                            $is_2fa = ($row['is_2fa'] != '1') ? true : false ;
                            $secret_key = $row['secret_key'];

                            $token = $this->encrypt->encryptString($usertoken);
                            
                            $hashed_id = $this->encrypt->encryptString($id);

                            if ($this->_isBruteForce()) {
                                echo "You have exceeded the maximum login attempts. Try again tomorrow.";
                                return false;
                            }

                            if ($row['status'] == '0') {
                                echo "You're account has not been activated yet. Please confirm your account.";
                                return false;
                            }

                             
                         
                  

                            if ($this->verifyPassword($password, $psk)) {   
                                
                                    Session::set('secret_key', $secret_key);

                                    if (!empty($remember)) {
                                        Cookie::_set('user', ($token));
                                    }
                                    if ($is_2fa OR $this->_checkSessionFingerprint($id)) {
                                        # If User Turned on 2FA run this code
                                        Session::set('user_login', $id);
                                        Session::set('fingerprint', Misc::_generateLoginString());
                                        Session::set('token', ($token));
                                        Cookie::_set('cu', $hashed_id);
                                        Session::set('erfcy', base64_encode($username));
                                        $this->_updateUserSession($id);
                                        return true;
                                    } else {
                                        # Run this, otherwise
                                       $arr = array('user_login' => $id,
                                                    'fingerprint' =>  Misc::_generateLoginString(),
                                                    'token'=> $token,
                                                    'cu' => $hashed_id,
                                                    'erfcy' => base64_encode($username));
                                        Session::set('why', $arr);
                                        Session::set('challenge', true);
                                        echo "no";
                                    }

                               

                            } else {
                                echo "The passsword you've entered was incorrect. ";
                                $this->increaseLoginAttempts();
                            }
                        }
                        
                    } else {
                        echo "The email or username you&#39;ve entered doesn&#39;t match any account.";
                        return;
                    }
                } else {
                    echo "Oopps! Something went wrong. Please try again later.";
                }

    }

  

    /**
     * Increase users login attempt when password entered is wrong
     */

    private function increaseLoginAttempts() {
        $date = date('Y-m-d');
        $user_ip = Misc::getUserIpAddr();
        $login_attempts = $this->_getLoginAttempts();

        if ($login_attempts > 0) {
            $stmt = $this->db->prepare('UPDATE login_attempts SET attempt = attempt + 1 WHERE ip_address = :ip AND date = :d');
            // $stmt->execute([$user_ip,$date]);
            $stmt->bindParam(':ip', $user_ip, PDO::PARAM_STR);
            $stmt->bindParam(':d', $date, PDO::PARAM_STR);
            $stmt->execute();
        } else {
            $stmt = $this->db->prepare("INSERT INTO login_attempts (ip_address, date) VALUES (:ip, :d)");
            $stmt->bindParam(':ip', $user_ip, PDO::PARAM_STR);
            $stmt->bindParam(':d', $date, PDO::PARAM_STR);
            $stmt->execute();
        }

        
    }

    public function _getLoginAttempts() {
        $date = date('Y-m-d');
        $user_ip = Misc::getUserIpAddr();

        $sql = "SELECT * FROM login_attempts WHERE ip_address = :ip AND date = :d";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':ip', $user_ip, PDO::PARAM_STR);
        $stmt->bindParam(':d', $date, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch();
        if ($stmt->rowCount() == 0) {
            return 0;
        } else {
            return intval($res['attempt']);
        }
    }

    private function _isBruteForce(){
        $login_attempts = $this->_getLoginAttempts();

        if ($login_attempts > MAX_LOGIN_ATTEMPTS)  {
            return true;
        } else {
            return false;
        } 
        
    }

    public function _updateUserSession($user_id) {
        $date = date('Y-m-d h:i:s');
        $currentFingerprint = Misc::_generateLoginString();
        $userSession = $this->_checkSessionFingerprint($user_id);

        
        $sql = 'SELECT * FROM login_sessions WHERE user_id = :u';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':u', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch();
        // $userFingerprint = $res['fingerprint']; 
        if (!empty($res['fingerprint'])) {
            $userFingerprint = $res['fingerprint'];
        }



        if ($userSession) {
            $stmt = $this->db->prepare('UPDATE login_sessions SET datetime = :d WHERE fingerprint = :fp AND user_id = :u');
            // $stmt->execute([$user_ip,$date]);
            $stmt->bindParam(':fp', $userFingerprint, PDO::PARAM_STR);
            $stmt->bindParam(':u', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':d', $date, PDO::PARAM_STR);
            $stmt->execute();
        } else {
            $stmt = $this->db->prepare("INSERT INTO login_sessions (user_id, fingerprint, datetime) VALUES (:u, :fp, :d)");
            $stmt->bindParam(':fp', $currentFingerprint, PDO::PARAM_STR);
            $stmt->bindParam(':u', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':d', $date, PDO::PARAM_STR);
            $stmt->execute();
        }

    }

    /**
     * Check user session in database
     * @param int $user_id ID of user
     * @return boolean TRUE 
     */
    private function _checkSessionFingerprint($user_id) {

        $currentFingerprint = Misc::_generateLoginString();

        $sql = 'SELECT * FROM login_sessions WHERE user_id = :u AND fingerprint = :fp';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':u', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':fp', $currentFingerprint, PDO::PARAM_STR);
        if($stmt->execute()) {
            $res = $stmt->fetch();

            // $userFingerprint = $res['fingerprint'];
            // $currentFingerprint = Misc::_generateLoginString();

            if ($stmt->rowCount() == 0) {
                return false;
            } else {
                return true;
            }

        }
        
        
    }

    public function verifyPassword($password, $hash){

        if(password_verify($password, $hash)){
            return true;
        }
    }

     
   }