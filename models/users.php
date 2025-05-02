<?php
    include_once __DIR__ . '/../controllers/utils.php'; // Include utility functions

    class Users {
        private $db_conn;
        private $table = "users_login_inf";

        public $id;
        public $username;
        public $password;

        public function __construct($db) {
            $this->db_conn = $db;
            $this->utils = new Utils(); // Initialize utility functions
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

        // add user
        public function AddUser($username, $password): bool {
            $q = "insert into " . $this->table . " (id, username, password) values (:id, :username, :password)";
            $sql = $this->db_conn->prepare($q);
            $sql->bindParam(':id', $this->utils->SetUniqueIntID()); // bind unique ID
            $sql->bindParam(':username', $username);
            $sql->bindParam(':password', password_hash($password, PASSWORD_BCRYPT)); // hash password
            return $sql->execute(); // return execution result
        }
    }
?>