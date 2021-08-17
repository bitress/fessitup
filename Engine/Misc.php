<?php

    class Misc {

        public function __construct(){
            $this->db = Database::getInstance();
        }
        
        /**
     * Generate key used for confession unique id.
     * @return string Generated key.
     */

    public static function generateUniqueID($length = UNIQUE_ID_LENGTH){
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($length / 2));
          } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
          } else {
            throw new Exception("no cryptographically secure random function available");
          }
          return substr(bin2hex($bytes), 0, $length);
    }
    
        
     /**
     * Generate key used for token.
     * @return string Generated key.
     */
    public static function _generateKey() {
    
    $uniquekey = self::_generateLoginString();
    
        return md5(time() . $uniquekey . time());
    }
        

    public static function getUserIpAddr() {
      if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
      } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      } else {
        $ip = $_SERVER['REMOTE_ADDR'];
      }
      return $ip;
    }
        
        /**
     * Generate string that will be used as fingerprint. 
     * This is actually string created from user's browser name and user's IP 
     * address, so if someone steal users session, he won't be able to access.
     * @return string Generated string.
     */
    public static function _generateLoginString() {
        $userIP = self::getUserIpAddr();
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
        $loginString = hash('sha512',$userIP . $userBrowser);
        return $loginString;
    }
    

  public static function _filterString($str, $slash = false){
    $add = ($slash) ? '/' : '' ;
        $invalid_characters = array("$", "%", "#", "<", ">", "|", $add);
        $str = str_replace($invalid_characters, "", $str);
        return $str;
  }

  public static function relativeDate($datetime) {
      $now = strtotime(date('M j, Y'));

      $relativeDay = ($datetime - $now) / 86400;

        if ($relativeDay >= 0 && $relativeDay < 1) {
            return 'Today ' . date('h:i A', $datetime);
        }

       if ($relativeDay >= -1 && $relativeDay < 0) {
            return 'Yesterday '. date('h:i A', $datetime);
       }

       if (abs($relativeDay) > 2) {
         
          return date('l, j F, Y h:i A', $datetime);
       }
  }
        
	public static function timeAgo($time) {
    $current_time = date('Y-m-d h:i:s');
    $time_difference = strtotime($current_time) - strtotime($time);

    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
  
 } 
 
 public static function upload_file($file)  {  
      if(isset($file))  
      {  
           $extension = explode('.', $file['name']);  
           $new_name = self::generateUniqueID() . '.' . $extension[1];  
           $destination = '../uploads/' . $new_name;  
           move_uploaded_file($file['tmp_name'], $destination);  
           return $new_name;  
      }  
 }  

    
    }
?>