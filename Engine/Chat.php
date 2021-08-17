<?php

class Chat {

    private $db;
    private $encrypt;


   public function __construct() {
       $this->db = Database::getInstance();
       $this->encrypt = new Encrypt;
   }

   public function sendMessage($sender, $receiver, $message) {
       
       $encryptedMessage = $this->encrypt->encryptString($message);
   }
    
}