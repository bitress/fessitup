<?php
    /**
     * Confession Class
     */
     class Confession {

        private $db;

        private $encryption;

        
        public function __construct() {
            $this->db = Database::getInstance();
            $this->login = new User;
            $this->encryption = new Encrypt;
        }


        /**
         *  Insert confession into database
         *  @param string $message Confession Message
         *  @param string $title Confession Title
         *  @return boolean true
         **/

        public function postConfession($message, $title, $category) {
            $user = (User::_isLoggedIn()) ? Session::get('user_login') : Misc::getUserIpAddr();
            $type = (User::_isLoggedIn()) ? 'user' : 'visitor';

            $encrypted_message = $this->encryption->encryptString($message);
            $title = $this->encryption->encryptString($title);
            
            // Generated confession unique id
            $uniqueid = Misc::generateUniqueID();
            $time = date('Y-m-d H:i:s');
                $sql = "INSERT INTO confessions (unique_id, title, category, message, user, type, date_posted) VALUES (:u, :t, :c, :m, :user, :type, :time)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':m', $encrypted_message, PDO::PARAM_STR);
            $stmt->bindParam(':t', $title, PDO::PARAM_STR);
            $stmt->bindParam(':c', $category, PDO::PARAM_INT);
            $stmt->bindParam(':user', $user, PDO::PARAM_STR);
            $stmt->bindParam(':type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':u', $uniqueid, PDO::PARAM_STR);
            $stmt->bindParam(':time', $time, PDO::PARAM_STR);
                if($stmt->execute()){
                    echo $uniqueid;
                }
        }

        /**
         * Insert link to database as a post
         * @param string $link A url
         * @return boolean TRUE if good
         */

         public function postLink($link){

            $user = (User::_isLoggedIn()) ? Session::get('user_login') : Misc::getUserIpAddr();
            $type = (User::_isLoggedIn()) ? 'user' : 'visitor';
    
            // Generated confession unique id
            $uniqueid = Misc::generateUniqueID();
            $time = date('Y-m-d H:i:s');
                $sql = "INSERT INTO confessions (unique_id, link, user, type, date_posted) VALUES (:id, :url, :user, :type, :time)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':url', $link, PDO::PARAM_STR);
            $stmt->bindParam(':user', $user, PDO::PARAM_STR);
            $stmt->bindParam(':type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':id', $uniqueid, PDO::PARAM_STR);
            $stmt->bindParam(':time', $time, PDO::PARAM_STR);
                if($stmt->execute()){
                    echo $uniqueid;
                }

         }

        /**
         * Return all confession from the database
         *  @return array Array of user confessions
         **/

        public function getAllConfessions() {

            try {
             
           
            if (User::_isLoggedIn()) 
                $res = $this->db->select("SELECT * FROM confessions 
                JOIN category ON category.category_id = confessions.category ORDER BY date_posted DESC");   
 
            else {
                $res = $this->db->select("SELECT * FROM confessions
                 LEFT JOIN users_settings
                  ON users_settings.user = confessions.user
                   INNER JOIN category
                    ON category.category_id = confessions.category
                     WHERE confessions.type = 'visitor'
                      OR users_settings.confession_public = '1'
                       ORDER BY date_posted DESC");     
 
            }

             } catch (Exception $e) {
                echo "Error: ". $e->getMessage();
            } 

            if (!empty($res)) {
                return $res;
            } 
        }

        /**
         * Return all user confession
         * @param string $user_id ID of the user
         * @return array Array of the confession
         */

        public function getConfessionByUser($user_id) {
            $sql = "SELECT * FROM confessions WHERE user = :u ORDER BY date_posted DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':u', $user_id, PDO::PARAM_STR);
            $stmt->execute();
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $res;
        }

        /**
         * Get the confession from the database by the unique id
         * @param string $id Generated unique id of the confession
         * @return array Array of the confession requested by id
         */
        public function getConfessionByID($id){

            $sql = "SELECT * FROM confessions  JOIN category ON category.category_id = confessions.category WHERE unique_id = :u LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':u', $id, PDO::PARAM_STR);
            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($res)) {
                return $res;
            } 
        }

        public function getCategoryList(){
            try {

            $res = $this->db->select("SELECT * FROM category ORDER BY category_id DESC");     
                 
            } catch (Exception $e) {
                echo "Error: ". $e->getMessage();
            }
            if (!empty($res)) {
                return $res;
            }  
        }

        public function isConfessionOwned($user, $user_id){

            if ($user == $user_id) {
                return true;
            }

            return false;
        }

        public function isUrl($id) {

            $sql = "SELECT unique_id, link FROM confessions WHERE unique_id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
                $stmt->execute();
            $res = $stmt->fetch();

                if (!empty($res['link'])) {
                    return true;
                }
        }

        public function _test() {
            $res = $this->getAllConfessions();

                foreach ($res as $row):

                    $message = $row['message'];

                $output = '
                <div class="d-flex align-items-start">
										<img src="dist/img/avatars/avatar.jpg" width="36" height="36" class="rounded-circle mr-2" alt="Charles Hall">
										<div class="flex-grow-1">
											<small class="float-right text-navy">DAte ago</small>
											<strong>Test</strong> posted Some title<br />
											<small class="text-muted">a seconf ago</small>

											<div class="text-sm text-muted p-2 mt-1">
												  '. $message .'
												</div>

											<a href="#" class="btn btn-sm btn-danger mt-1"><i class="feather-sm" data-feather="heart"></i> Like</a>
										</div>
									</div>';
                                    echo $output;
                endforeach;

               

        }

    
     }