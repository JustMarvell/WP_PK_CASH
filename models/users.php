<?php
    class Users {
        private $db_conn;
        private $table = "users_login_inf";

        public $id;
        public $username;
        public $password;

        public function __construct($db) {
            $this->db_conn = $db;
        }

        // get all users
        public function GetAllUsers(): array {
            $q = "select * from " . $this->table;
            $sql = $this->db_conn->prepare($q);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); // return all users
        }

        // delete user by id
        public function DeleteUserById($id): bool {
            $q = "delete from " . $this->table . " where id = :id";
            $sql = $this->db_conn->prepare($q);
            $sql->bindParam(':id', $id);
            return $sql->execute(); // return execution result
        }
    }
?>