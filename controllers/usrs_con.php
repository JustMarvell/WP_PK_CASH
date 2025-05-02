<?php
    include_once __DIR__ . '/../models/database_connector.php'; // Include database connection file
    include_once __DIR__ . '/../models/users.php'; // Include User model

    class UserCnt {
        private $db_conn;
        private $userModel;

        public function __construct($db) {
            $this->db_conn = $db; // Initialize database connection
            $this->userModel = new Users($db); // Initialize User model
        }

        // Function to get all users
        public function GetUsers() {
            return $this->userModel->GetAllUsers(); // Call method from User model to get all users
        }

        // Function to delete user by ID
        public function DeleteUser($id) {
            return $this->userModel->DeleteUserById($id); // Call method from User model to delete user by ID
        }
    }
?>