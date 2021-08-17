<?php

    class Message {

        private $db;

        public function __construct() {
            $this->db = Database::getInstance();
            $this->login = new User;
            $this->encryption = new Encrypt;
            $this->userID = Session::get('user_login');
        }


        /**
         * Get all messages by sender and receiver id
         * @param int $receiver ID of the receiver (incoming)
         * @param int $sender ID of the sender or me (outgoing)
         * @return array messages
         */
        public function getMessage($receiver, $sender) {

            $sql = "SELECT * FROM messages 
                LEFT JOIN users_details ON users_details.users_id = messages.sender 
                LEFT JOIN users ON users.user_id = users_details.users_id
                    WHERE (sender = :s AND receiver = :r)
                     OR (receiver = :s AND sender = :r)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':s', $sender, PDO::PARAM_INT);
            $stmt->bindParam(':r', $receiver, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                return $row;
        }

        /**
         * Get all the messages of the user for side bar
         * @param int $user ID of the user (sender), current user
         * @return array all messages
         */
        public function getUserAllMessages($user) {
        

            $sql = "SELECT * FROM users INNER JOIN users_settings ON users.user_id = users_settings.user INNER JOIN users_details ON users_settings.user = users_details.users_id WHERE NOT user_id = :u ORDER BY user_id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':u', $user, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $user_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($stmt->rowCount() > 0) {

                        return $user_data;
                    
                }

            } 
            
               
             
        }
        
        /**
         * Send message and insert to database
         * @param int $receiver id of the receiver
         * @param string $message message to be sent
         * @return boolean TRUE if success, FALSE otherwise
         */
        public function sendMessage($receiver, $message) {

            try {
                //code...
            
            $encrypted_message = $this->encryption->encryptString($message);

             $sql = "INSERT INTO messages (sender, receiver, message) VALUES (:s, :r, :m)";
             $stmt = $this->db->prepare($sql);
             $stmt->bindParam(':s', $this->userID, PDO::PARAM_INT);
             $stmt->bindParam(':r', $receiver, PDO::PARAM_INT);
             $stmt->bindParam(':m', $message, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    echo 'true';
                }

            } catch (\Throwable $th) {
                //throw $th;
            }
        }   



    }