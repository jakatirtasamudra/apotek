<?php


    define('DB_SERVER', '127.0.0.1');
    define('DB_PORT', '3306');
    define('DB_DATABASE', 'Klinik');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');

    class __Database
    {
        private $connection;

        public function __construct() 
        {
            $this->connect();   
        }

        private function connect() 
        {
            $dsn = "mysql:host=" . DB_SERVER . ";port=" . DB_PORT . ";dbname=" . DB_DATABASE . ";charset=utf8";

            try {

                $this->connection = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection->setAttribute(PDO::ATTR_TIMEOUT, 90);

            } catch ( PDOException $e ) {

                echo "Connection failed: " . $e->getMessage();
                
            }
        }

        public function prepare($query)
        {
            return $this->connection->prepare($query);
        }

        public function beginTransaction()
        {
            $this->connection->beginTransaction();
        }

        public function commit()
        {
            $this->connection->commit();
        }

        public function rollback()
        {
            $this->connection->rollBack();
        }

        public function lastInsertId()
        {
            return $this->connection->lastInsertId();
        }

        public function __destruct() 
        {
            $this->connection = null;
        }
    }