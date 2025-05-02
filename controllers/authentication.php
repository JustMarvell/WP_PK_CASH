<?php
    include_once __DIR__ . '/../models/database_connector.php';

    class authentication {
        private $db_conn;

        // constructor to initialize db connection
        public function __construct($db) {
            $this->db_conn = $db;
        }

        public function login() {
            // Check if the request method is POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = trim($_POST['username']); // Remove whitespace
                $password = $_POST['password'];

                // Check credentials in the database
                $q = "SELECT * FROM users WHERE username = :username";
                $sql = $this->db_conn->prepare($q);
                $sql->bindParam(':username', $username);
                $sql->execute();

                if ($sql->rowCount() > 0) {
                    // Fetch user data
                    $user = $sql->fetch(PDO::FETCH_ASSOC);

                    // Debugging: display user information
                    error_log(print_r($user, true)); // Display user information
                    
                    // Verify password with hash from database
                    if (password_verify($password, $user['password'])) {
                        // Store user information in session
                        $_SESSION['user_id'] = $user['id']; // Store user ID
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['role'] = $user['role'];

                        // Redirect based on role
                        if ($user['role'] === 'admin') {
                            header("Location: admin.php");
                        } else {
                            header("Location: welcome.php");
                        }
                        exit();
                    } else {
                        error_log("Password does not match for user: $username"); // Add log
                        return "Login failed. Please try again."; // Return error message
                    }
                } else {
                    error_log("User not found: $username"); // Add log
                    return "Login failed. Please try again."; // Return error message
                }
            }
            
            return null; // Return null if no error
        }
    }
?>