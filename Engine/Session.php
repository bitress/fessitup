<?php
	class Session {

	  public static function _startSession(){
      session_name('fessItUp');
     ini_set('session.use_only_cookies', 1);
     $cookeParams = session_get_cookie_params();
          session_set_cookie_params(
            $cookeParams['lifetime'],
            $cookeParams['path'],
            $cookeParams['domain'],
            false,
            true
          );
      session_start();
  }

    /**
     * Destroy session.
    */
    public static function destroySession() {
      $_SESSION = array();

      $params = session_get_cookie_params();

          setcookie(session_name(),
            '',
            time() - 42000, 
            $params['path'], 
            $params['domain'], 
            $params['secure'], 
            $params['httponly']
    );
    session_destroy();
}

		
 		 public static function set($index, $value) {

           $_SESSION[$index] = $value;
        
  }
  
  	  public static function get($key, $default = null) {
        if (isset($_SESSION[$key])) {
          return $_SESSION[$key];
        } else {
         return $default;
        }
      }
    
    public static function check($key) {
      if(isset($_SESSION[$key])) {
        return true;
      }
    }

 
  		public static function destroy($key) {
    if (isset($_SESSION[$key]))
      unset($_SESSION[$key]);
  }
  
    
		
		}
