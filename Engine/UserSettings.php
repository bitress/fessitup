<?php

class Settings {

    public function __construct() {
        $this->db = Database::getInstance();
    }
    /**
     * Check the username
     * @param string $loggedIn Username of logged In user
     * @param string $username Username in the url
     * @return boolean TRUE if matched, FALSE Otherwise
     */
    public function checkUsername($loggedIn, $username){
        if ($loggedIn == $username){
            return true;
        }
    }
    
    // public function isConfessionPublic($user){

    //     // if (User::_isLoggedIn())
    //     //     return true;

    //     $sql = "SELECT * FROM users_settings WHERE user = :u";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->bindParam(':u', $user, PDO::PARAM_INT);
    //     $stmt->execute();
    //     $res = $stmt->fetch();
    //         if ($res['confession_public'] == "1") {
    //             return true;
    //         }
    // }

    public function isConfessionCommentable($user){

        $sql = "SELECT * FROM users_settings WHERE user = :u";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':u', $user, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch();
            if ($res['confession_commentable'] == "1") {
                return true;
            }

    }

    public function isConfessionSearchable($user){

        $sql = "SELECT * FROM users_settings WHERE user = :u";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':u', $user, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch();
            if ($res['searchable_confession'] == "1") {
                return true;
            }

    }

    public function isProfilePublic($user){
        $sql = "SELECT * FROM users_settings WHERE user = :u";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':u', $user, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch();
            if ($res['visitable_profile'] == "1") {
                return true;
            }
    }

    public function isProfileSearchable($user){
        $sql = "SELECT * FROM users_settings WHERE user = :u";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':u', $user, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch();
            if ($res['searchable_profile'] == "1") {
                return true;
            }
    }


}