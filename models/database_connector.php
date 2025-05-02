<?php
    class Database_connector {
        private $host = 'localhost';
        private $db_name = 'zzz_db';
        private $username = 'root';
        private $password = '';
        private $db_conn;

        // func to initialize the database connection
        public function GetConnection() : ?PDO {
            $this->db_conn = null;

            try {
                // Create a new PDO instance and connect to the database
                $this->db_conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                // Set the PDO error mode to exception
                $this->db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                // Handle connection error
                echo "Connection error: " . $exception->getMessage();
            }
            
            return $this->db_conn;
        }
    }
?>