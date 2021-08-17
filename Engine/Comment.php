<?php

class Comment {

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function countComment(){
    }

    public function insertComment($comment, $comment_id, $parent, $user_id){
       
    }

    public function getCommentByConfession($id) {
        $sql = "SELECT * FROM user_comments";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cfs_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetchAll();

        return $row;
    }

    public function getParentIDByCommentID($id){
       
    }

}