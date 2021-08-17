<?php

class Notification {

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Count the unseen notification
     * @param int $userid User ID
     * @return string Return the count of unseen notification
     */
    public function _countUnseen(){
        $userid = Session::get('user_login');
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM notification WHERE status = '0' AND user_id = :u");
        $stmt->execute(array(":u" => $userid));
        $row = $stmt->fetchColumn();
        
        return $row;
    }

    public function _getAllNotification(){
        $user = Session::get('user_login');
        $sql = "SELECT notification.type, notification.message, notification.status, confessions.unique_id, confessions.id, notification.datetime FROM notification JOIN confessions On confessions.id = notification.type_id WHERE notification.user_id = :u ORDER BY notification.datetime DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":u", $user, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row;
    }

    public function _getLatestNotification(){
        $user = Session::get('user_login');
        $sql = "SELECT notification.type, notification.message, notification.status, confessions.unique_id, confessions.id, notification.datetime FROM notification JOIN confessions On confessions.id = notification.type_id WHERE (notification.datetime >= NOW() - INTERVAL 5 DAY AND notification.datetime < NOW()) AND notification.user_id = :u AND notification.status = '0' ORDER BY notification.datetime DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":u", $user, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row;
    }

    /**
     * Get the id of the user, who'll see the notification
     * @param int $unique_id ID of the confession
     * @param string $type Type of notification
     * @return int ID of the user
     */

    public function notifyWho($unique_id, $type){
        
        if ($type == 'smile') {
            return $this->_isConfession($unique_id);
        }

        // if ($type == 'comment') {
        //     return $this->_isComment($unique_id);
        // }

    }
    
    /**
     * Notify the user who created the post 
     * @param int $toNotify The user who created the post, to be notified
     * @param int $typeid ID of the confession/comment/whatever
     * @param string $type The type of notification, to put
     * @param string $message Message to be seen by $toNotify
     * @return boolean TRUE if executed, FALSE otherwise
     */

    public function notify($toNotify, $typeid, $type, $message){
    
        if ($toNotify != Session::get('user_login')) {
        $date = date('Y-m-d h:i:s');
        $sql = "INSERT INTO notification (user_id, type, type_id, message, datetime) VALUES (:u, :t, :ti, :m, :dt)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':u', $toNotify, PDO::PARAM_INT);
            $stmt->bindParam(':t', $type, PDO::PARAM_STR);
            $stmt->bindParam(':ti', $typeid, PDO::PARAM_INT);
            $stmt->bindParam(':m', $message, PDO::PARAM_STR);
            $stmt->bindParam(':dt', $date, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    return true;
                }
        }
    }

    /**
     * Update if user already seen the notification
     * @var int $userid Id of the user who has the notification
     * @param string $typeid Id of the notification(post/comment)
     * @return boolean TRUE if the user successfullly seen the notification
     */
    public function seenNotif($typeid){
        Session::_startSession();
        $userid = Session::get('user_login');
        $sql = "UPDATE notification SET status = '1' WHERE user_id = :u AND type_id = :ti";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':u', $userid, PDO::PARAM_INT);
        $stmt->bindParam(':ti', $typeid, PDO::PARAM_INT);
            if($stmt->execute()) {
                return true;
            }

    }
    

    /**
     * Get the notification message
     * @param string $type Notification type
     * @return string Notification message
     */
    public static function notifyMessage($type){
        
        switch ($type) {

            case 'smile':
                $message = "Someone smiled on your confession!";
                return $message;

                break;
            case 'comment':
                $message = "Go see the new commented on your confession!";
                return $message;

                break;
            
            default:
                # code...
                break;
        }
    }

    /**
     * Check the notification type to show on dropdown
     * @param string $type Type of notification
     * @return boolean TRUE if match
     */

    public static function _notificationType($type){
        switch ($type) {
            case 'smile':
                return true;
                break;
            
            case 'value':
                # code...
                break;
            
            default:
                # code...
                break;
        }
    }

    /**
     * Get the user id of who confess from the unique id of confession
     * @param int $unique_id ID of the confession
     * @return int ID of the user
     */
    private function _isConfession($unique_id){
        $sql = "SELECT * FROM confessions WHERE id = :u";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':u', $unique_id);
        $stmt->execute();
        $res = $stmt->fetch();

        return $res['user'];
    }

}