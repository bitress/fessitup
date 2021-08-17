<?php

class Membership {

    public function __construct()
    {
        
    }


    public static function isUserPremium(){
            $id = Session::get('user_login');
    
        if (!empty($id)) {
         
            $sql = "SELECT * FROM users WHERE user_id = :u";

            $stmt = Database::getInstance()->prepare($sql);
            $stmt->bindParam(':u', $id, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetch();

            if($res['is_premium'] == 1){
                return true;
            }
            
        }
    }


}