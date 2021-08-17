<?php
	
	class Database extends PDO{      
      
      private static $_instance;


      
   // Constructor
          public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS)
    {
        try {
            parent::__construct($DB_TYPE.':host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8', $DB_USER, $DB_PASS);
            $this->exec('SET CHARACTER SET utf8mb4');

            // comment this line if you don't want error reporting
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        } catch (PDOException $e) {
            die ( 'Connection failed: ' . $e->getMessage() );
        }
    }
      
		public static function getInstance() {
        // create instance if doesn't exist
        if ( self::$_instance === null )
            self::$_instance = new self(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

        return self::$_instance;
    }

        private function __clone(){}
    
      // Magic method clone is empty to prevent duplication of connection

         /**
        * Select
        * @param $sql An SQL string
        * @param array $array Paramters to bind
        * @param int $fetchMode A PDO Fetch mode
        * @return array
        */

        public function select($sql, $array = array()) {
                 $db = self::getInstance();

            $stmt = $db->prepare($sql);
            foreach ($array as $key => $value) {
            $stmt->bindValue(":$k­ey", $value);
             }
            
            $stmt->execute();
                     $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
             
            return $res;			          
           }

        /**
        * insert
        * @param string $table A name of table to insert into
        * @param string $data An associative array
        */

        public function insert($table, $data) {
            $db = self::getInstance();

            ksort($data);

            $fieldNames = implode('`, `', array_keys($data));
            $fieldValues = ':' . implode(', :', array_keys($data));

            $stmt = $db->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

                foreach ($data as $key => $value) {
                $stmt->bindValue(":$k­ey", $value);
                }

             $stmt->execute();
             return true;
        }

  }
