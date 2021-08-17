<?php

   class Register {
	 
		private $db = null;

		private $mailer;
	
	
		public function __construct(){
			$this->db = Database::getInstance();

			$this->mailer = new Email;
		}
			
		/**
		 * Register user with the provided credentials
		* @param string $username Users provided username6
		* @param string $email Users provided email
		* @param string $password Users provided hashed password
		* @param string $confirm_password Users confirrmed hashed password
		* @return boolean TRUE if registration if successfully, FALSE if username or email already exists
		*/
	 	public function userRegister($username, $email, $password, $confirm_password, $math_captcha){
				
				// if($this->_validateFields($username, $email, $password, $confirm_password, $math_captcha)){
				// 	return false;																							
				// }

				$errors = $this->_validateFields($username, $email, $password, $confirm_password, $math_captcha);

				if (count($errors) == 0) {
					

				$status = (EMAIL_CONFIRMATION === true) ? '0' : '1' ;
     	
                //hash password before sending to database
                $hashed_password = password_hash($password, PASSWORD_ARGON2ID);

                $token = Misc::_generateKey();

				$key = md5(Misc::generateUniqueID());
                $sql = "INSERT INTO users (username, email, password, token, confirmation_key, status) VALUES (:u, :e, :p, :t, :key, :status)";
                $stmt = $this->db->prepare($sql);
                    $stmt->bindParam(":u", $username, PDO::PARAM_STR);
                    $stmt->bindParam(":e", $email, PDO::PARAM_STR);
                    $stmt->bindParam(":p", $hashed_password, PDO::PARAM_STR);
                    $stmt->bindParam(":t", $token, PDO::PARAM_STR);
                    $stmt->bindParam(":status", $status, PDO::PARAM_STR);
                    $stmt->bindParam(":key", $key, PDO::PARAM_STR);
                    if ($stmt->execute()) {
						$user_id = $this->db->lastInsertId();
						$this->_userSettings($user_id);
						$this->_userDetails($user_id);
                        	if (EMAIL_CONFIRMATION) {
								$this->mailer->sendEmailConfirmation($email, $key);
								$msg = "Registration successful. Please check your email.";
							} else {
								$msg = "Registration successful. You may now login!";
							}

							$result = array(
								"status" => "true",
								"msg"    => $msg
							);			
							echo json_encode($result);		
				    }
				} else {

					$result = array(
						"status" => "false",
						"errors" => $errors
					);

					echo json_encode ($result);


				}
				
		 }

		 /**
		  * Create a row on database for user's settings
		  * @param int $user_id ID of the user
		  * @return boolean TRUE if executed, FALSE otherwise
		  */
		 private function _userSettings($user_id){
			$sql = "INSERT INTO users_settings (user) VALUES (:u)";
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(':u', $user_id, PDO::PARAM_INT);
			$stmt->execute();

			return true;
		 }
		 /**
		  * Create a row for user's details
		  * @param int $user_id ID of the user
		  * @return boolean TRUE if executed, FALSE otherwise
		  */
		 private function _userDetails($user_id){
			$sql = "INSERT INTO users_details (users_id) VALUES (:u)";
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(':u', $user_id, PDO::PARAM_INT);
			$stmt->execute();

			return true;
		 }

		/**
		 * Validate The Form Fields
		 * @param string $username Users username to be validated
		 * @param string $email User's email
		 * @param string $password User's password
		 * @param string $confirm_password User's re typed password
		 * @return boolean TRUE if there is an error, FALSE if there isnt.
		 */

		private function _validateFields($username, $email, $password, $confirm_password, $math_captcha, $protection = true){

			$errors = array();
			
			if (empty($username)) {
				$errors[] = "Please enter your username. ";
			} else {
				if($this->_validateUsername(strip_tags($username))){
					$errors[] =  "Username is already taken. Please choose another username.";
				}
			}

			if (empty($email)) {
				$errors[] =  "Please enter your email address";
			} else if(!$this->_isEmailValid($email)) {
				$errors[] =  "Please enter a valid email.";
			} else {
				if($this->_validateEmail(strip_tags($email))){
					$errors[] =  "Email already exists. :)";
				}
			}

			if ($password == strval(BLANK_PASSWORD)) {
				$errors[] =  "Please enter your password";
			} 

			if ($confirm_password == strval(BLANK_PASSWORD)) {
				$errors[] =  "Please re-enter your password";
			}

			if ($password != $confirm_password) {
				$errors[] =  "Password does not match.";
			}
			
			if ($protection) {
				$sum = Session::get('first_num') + Session::get('second_num');
					if ($sum != intval($math_captcha)) {
						$errors[] =  "Incorrect sum. Please check it.";
					}
			}

		return $errors;

		}

		 
		 /**
		  * Validate username, check if it doesnt exists
		  * @param string $username Users provided username to be validated
		  * @return boolean TRUE, if username doesnt exist, FALSE otherwise
		  */
         
		private function _validateUsername($username){
			
			$sql = "SELECT username FROM users WHERE username = :u ";
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":u", $username, PDO::PARAM_STR);
			if($stmt->execute()){
			if($stmt->rowCount() == 1){
				return true;
			}
		
				} else {
					echo "Oopps! Something went wrong. Please try again later,";
					}

				}
 
		 /**
		  * Validate email, check if it doesnt exists
		  * @param string $email Users provided email to be validated
		  * @return boolean TRUE, if email doesnt exist, FALSE otherwise
		  */
         
 		public function _validateEmail($email){
			
			$sql = "SELECT email FROM users WHERE email = :e";
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":e", $email, PDO::PARAM_STR);
			if($stmt->execute()){
				$res = $stmt->fetch();
			if($stmt->rowCount() == 1){
				
				return true;
				
				}
     
			} else {
			echo "Oopps! Something went wrong. Please try again later,";
				}

			}

		/**
		 * Check if email is valid
		 * @param string $email User's email
		 * @return boolean TRUE if email is valid, FALSE otherwise
		 */
		public function _isEmailValid($email){
			return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email);
		} 

		/**
		 * Math captcha
		 */
		public function _mathCaptcha(){
			Session::set('first_num', rand(1,9));
			Session::set('second_num', rand(1,9));
		}
 
	}															