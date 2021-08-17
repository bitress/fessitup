<?php

    class User {

      private $userID;
      private $register;
      private $encrypt;

        public function __construct() {
            $this->db = Database::getInstance();  
            $this->register = new Register(); 
            $this->userID = Session::get('user_login');
            $this->encrypt = new Encrypt();
        }
        
        /**
         * Check if user is logged in
		     * @return boolean True if user logged in, Otherwise False
         */
        public static function _isLoggedIn(){
          
          $loginString = Misc::_generateLoginString();
          $currentString = Session::get("fingerprint");
          
          if(Session::get('user_login') == null ){
              return false;
          }

          if (!Cookie::_check('cu')) {
            return false;
          }
                            
          if($currentString != null && $currentString == $loginString){
              
              return true;

          } else  {

              Session::destroySession();
              return false;
            }
           
          return true;
        }
        
        /**
         * Get user's data ny using their token
         * @param string $token User given token
         * @return array Users details
         */
        
        public function _getUserDetails($token){
          
          $userToken = $this->encrypt->decryptString($token);

          $sql = "SELECT * FROM users INNER JOIN users_settings ON users.user_id = users_settings.user INNER JOIN users_details ON users_settings.user = users_details.users_id WHERE users.token = :t";
          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':t', $userToken, PDO::PARAM_STR);
          $stmt->execute();

          $res = $stmt->fetch(PDO::FETCH_ASSOC);
          
            if(!empty($res)){
              return $res;
            }

        }

        public function getUserData($username){

          $sql = "SELECT * FROM users INNER JOIN users_settings ON users.user_id = users_settings.user INNER JOIN users_details ON users_settings.user = users_details.users_id WHERE users.username = :u";
          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':u', $username, PDO::PARAM_STR);
          $stmt->execute();

          $res = $stmt->fetch(PDO::FETCH_ASSOC);
          
            if(!empty($res)){
              return $res;
            }
        }
        
        public function _getID($username){

            $sql = "SELECT user_id FROM users WHERE username = :u";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':u', $username, PDO::PARAM_STR);
            if($stmt->execute()){
              $res = $stmt->fetch();
            }
            return $res['user_id'];
        }

        public function getUserByID($id){

          $sql = "SELECT * FROM users INNER JOIN users_settings ON users.user_id = users_settings.user INNER JOIN users_details ON users_settings.user = users_details.users_id WHERE users.user_id = :u";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':u', $id, PDO::PARAM_INT);
            if($stmt->execute()){
              $res = $stmt->fetch();
            }
            return $res;
        }

        public function updateEmail($email, $password, $token){

          $user = $this->userID;
 
          if (CSRF::check($token)) {
            echo "Invalid token!";
            return;
          }

          if(!$this->register->_isEmailValid($email)){
              echo "Please Enter a valid Email";
              return;
          }

          if($this->register->_validateEmail($email)){
            echo "Email has been taken already";
            return;
        }

        try {

          $sql = "SELECT * FROM users WHERE user_id = :i LIMIT 1";
          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':i', $user, PDO::PARAM_INT);
          $stmt->execute();
          $row = $stmt->fetch();

              $user_password = $row['password'];

            if (password_verify($password, $user_password)) {

                  $sql = "UPDATE users SET email = :e WHERE user_id = :i";
                    $stmt = $this->db->prepare($sql);
                    $stmt->bindParam(':e', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':i', $user, PDO::PARAM_INT);
                      if ($stmt->execute()) {
                        return true;
                      }

            } else {
              echo "The password you've entered is incorrect.";
              return false;
            }

        } catch (\Throwable $th) {
          throw $th;
        }

         
        }

        public function updateUserPrivacySettings($public_confession, $commentable_confession, $searchable_confession, $visitable_profile, $searchable_profile){
          $user = $this->userID;

          try {
            $sql = "UPDATE users_settings SET
            confession_public = :cp, 
            searchable_confession = :sc, 
            confession_commentable = :cc,
            visitable_profile = :vp, 
            searchable_profile = :sp
             WHERE user = :u";
           $stmt = $this->db->prepare($sql);
           $stmt->bindParam(':cp', $public_confession, PDO::PARAM_STR);
           $stmt->bindParam(':cc', $commentable_confession, PDO::PARAM_STR);
           $stmt->bindParam(':sc', $searchable_confession, PDO::PARAM_STR);
           $stmt->bindParam(':vp', $visitable_profile, PDO::PARAM_STR);
           $stmt->bindParam(':sp', $searchable_profile, PDO::PARAM_STR);
           $stmt->bindParam(':u', $user, PDO::PARAM_INT);
           if($stmt->execute()){
             return true;
           }

          } catch (\Throwable $th) {
            throw $th;
          }
            

        }

        public function updatePrivateUserDetails($firstname, $lastname, $birthdate, $token){

          $user = $this->userID;

          $birthdate = date('Y-m-d', strtotime($birthdate));

          if (CSRF::check($token)) {
            echo "Invalid token!";
            return;
          }

            $sql = "UPDATE users_details SET first_name = :firstname, last_name = :lastname, birthdate = :birthdate WHERE users_id = :u";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $stmt->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
            $stmt->bindParam(':u', $user, PDO::PARAM_INT);
              if ($stmt->execute()) {
                return true;
              }

        }


        public function updatePublicUserDetails($profile_image, $bio) {
          $user = $this->userID;

          $res = $this->_getUserDetails(Session::get('token'));
          $currentAvatar = $res['profile_image'];

          if (!empty($profile_image)) {

            if ( 0 < $profile_image['error'] ) {
              echo 'Error: ' . $profile_image['error'];
              return false;
            }
  
            $info = getimagesize($profile_image['tmp_name']);
            if ($info === FALSE) {
              echo "Unable to determine image type of uploaded file";
              return false;
            }
  
            if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
              echo "Not a gif/jpeg/png";
              return false;
            }

            $avatar = Misc::upload_file($profile_image);
          } else {
            $avatar = $currentAvatar;
          }


          $sql = "UPDATE users_details SET profile_image = :profile_image, bio = :bio WHERE users_id = :u";
          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':profile_image', $avatar, PDO::PARAM_STR);
          $stmt->bindParam(':bio', $bio, PDO::PARAM_STR);
          $stmt->bindParam(':u', $user, PDO::PARAM_INT);
          if($stmt->execute()){
            return true;
          }

          
        }


        /**
         * Change password function
         */
        public function changePassword($oldpassword, $newpassword, $confirmpassword, $token){

          $user = $this->userID;

          if (CSRF::check($token)) {
             echo "Invalid token!";
            return;
          }

           if ($this->_validatePassword($oldpassword, $newpassword, $confirmpassword)) {
            return;
          }
          
          $sql = "SELECT * FROM users WHERE user_id = :i LIMIT 1";
          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':i', $user, PDO::PARAM_INT);
          $stmt->execute();
          $row = $stmt->fetch();

              $user_password = $row['password'];

            if (password_verify($oldpassword, $user_password)) {

                $newhashedpassword = password_hash($confirmpassword, PASSWORD_BCRYPT);

                  $sql = "UPDATE users SET password = :pass WHERE user_id = :i";
                    $stmt = $this->db->prepare($sql);
                    $stmt->bindParam(':pass', $newhashedpassword, PDO::PARAM_STR);
                    $stmt->bindParam(':i', $user, PDO::PARAM_INT);
                      if ($stmt->execute()) {
                        return true;
                      }

            } else {
              echo "The password you've entered is incorrect.";
              return false;
            }

        }

        /**
         * Validate password fields
         */
        private function _validatePassword($oldpassword, $newpassword = null, $confirmpassword = null){
          
            if ($oldpassword == strval(BLANK_PASSWORD)) {
              echo "Please enter your old password";
              return true;
            } 

            if ($newpassword == strval(BLANK_PASSWORD)) {
              echo "Please enter your new password";
              return true;
            }

            if ($confirmpassword == strval(BLANK_PASSWORD)) {
              echo "Please re-enter your password";
              return true;
            }
            
            if ($newpassword != $confirmpassword) {
              echo "Password does not match.";
              return true;
            }
        }

      

      public static function _getAge($birthdate) {
        return intval(date('Y', time() - strtotime($birthdate))) - 1970; 
      }
        

      //Logout user
      public function logout(){
        Session::destroySession();
     }
    

    }