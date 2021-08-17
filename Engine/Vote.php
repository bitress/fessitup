<?php

    class Vote {

        /**
         * @var Notification
         */
        private $notification;

        /**
         * @var Database
         */
        private $db;

        public function __construct() {
        $this->db = Database::getInstance();
        $this->notification = new Notification;
    }

    /**
     * Insert vote to database
     * @param int $cfs_id ID of the confession
     * @param int $user Id or Ip address of the user who upvoted the confession
     * @param string $type Type of vote
     * @return boolean TRUE if user not yet upvoted, FALSE otherwise throw an alert on page
    **/
    public function makeSmile($cfs_id, $user, $type = 'smile') {

        //Get user ip address
        $ip = Misc::getUserIpAddr();

        // Check if user upvoted
        if($this->checkUserIfSmiled($user, $cfs_id)){
             echo "no";
         } else {
            
            $query = "INSERT INTO smile (confession_id, user_id, type, ip) VALUES (:c, :u, :t, :i)";
            //Insert vote into the database with confession id, user id and vote type
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':c', $cfs_id, PDO::PARAM_INT);
            $stmt->bindParam(':u', $user, PDO::PARAM_STR);
            $stmt->bindParam(':t', $type, PDO::PARAM_STR);
            $stmt->bindParam(':i', $ip, PDO::PARAM_STR);
            if ($stmt->execute()) {
                //Update total upvotes in database
                $this->updateSmile($cfs_id);
                $this->notification->notify($this->notification->notifyWho($cfs_id, $type), $cfs_id,  $type, Notification::notifyMessage($type));
                }
        }
    }


    /**
     * Update total upvote in database
     * @param int $confession_id Id of the confession that will be incremented
     * @return boolean TRUE
     */
    private function updateSmile($confession_id){
        // SQL query
        $query = "UPDATE confessions SET smile = smile + 1 WHERE id = :c";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':c', $confession_id, PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        }

    }

      /**
     * Remove upvote
     * @param int $cfs_id Confession ID
     * @param int $user User's ID
     * @return boolean TRUE if upvoted successfully
     */
    public function deleteSmile($cfs_id, $user) {

        $query = "DELETE FROM smile WHERE user_id = :u AND confession_id = :c";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':u', $user, PDO::PARAM_INT);
        $stmt->bindParam(':c', $cfs_id, PDO::PARAM_INT);
         if ($stmt->execute()) {
                
            //Update confession downvotes
            $query = "UPDATE confessions SET smile = smile - 1 WHERE id = :i";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':i', $cfs_id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    return true;
                }

            }
    }
    
    /**
    * Check if user upvoted or not
    * @param int $user_id Id of the user who will upvote
    * @param int $confession_id Id of the the confession that will be upvoted
    * @param string $type Type of vote
    * @return boolean TRUE if user not yet upvoted, FALSE otherwise
    */

   public function isUserSmiled($user_id, $confession_id, $type = 'smile') {
       $stmt = $this->db->prepare("SELECT * FROM smile WHERE user_id = :u AND type = :t AND confession_id = :c");
       $stmt->bindParam(':u', $user_id, PDO::PARAM_STR);
       $stmt->bindParam(':c', $confession_id, PDO::PARAM_INT);
       $stmt->bindParam(':t', $type, PDO::PARAM_STR);
       $stmt->execute();
           if($stmt->rowCount() > 0){
               return true;
           }

       return false;
   }


    /**
     * Check if user voted
     * @param int $user Id of the user
     * @param $cfs_id String ID of the confession
     * @return boolean TRUE if user didnt voted yet, OTHERWISE FALSE
     */

    public function checkUserIfSmiled($user, $cfs_id) {

        $query = "SELECT * FROM smile WHERE user_id = :u AND confession_id = :c";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":c", $cfs_id, PDO::PARAM_STR);
        $stmt->bindParam(":u", $user, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
    }  
}
