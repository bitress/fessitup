<?php
/**
 * CSRF Protection
 */

class CSRF {

        protected static $doOriginCheck = false;

        /**
         * Generate CSRF token for security
         * @return string $csrf_token The generated csrf token
         */
        public static function generate(){

            $extra = self::$doOriginCheck ? Misc::_generateLoginString() : '';

            $token = base64_encode(time() . $extra . self::_random());
            
             return Session::set('csrf', 'csrf_'. $token);
        }

        public static function check($key){

            $csrf_token = Session::get('csrf');

            if ($key != $csrf_token) 
               return true;
 
        }

        // public static function _generate(){
        //     $input = '';
        //     return $input;
        // }

        protected static function enableOrigin(){
            self::$doOriginCheck = true;
        }

        private static function _random(){
            return Misc::_generateKey();
        }


    
}