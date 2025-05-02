<?php
    class Utils {
        private $utils;

        public static function Redirect($url) {
            if ($url == "" || $url == null) {
                print_r("URL is empty or null. Redirecting to index.php.");
                $url = "index.php"; // Default redirect URL
            }
            else {
                header("Location: $url");
            }
            exit();
        }

        public static function ValidateEmail($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
        }

        public static function ValidatePassword($password) {
            return strlen($password) >= 8; // Example: password must be at least 8 characters long
        }

        public static function ConvertToRupiah($amount) {
            return "Rp " . number_format($amount, 2, ',', '.');
        }

        // Function to set unique int ID for a table
        public static function SetUniqueIntId($db_conn, $table_name) {
            $q = "SELECT MAX(id) as max_id FROM $table_name";
            $sql = $db_conn->prepare($q);
            $sql->execute();
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            return $result['max_id'] + 1; // Increment max ID by 1
        }

        // Function to set unique ID for products
        public static function SetUniqueProductId($category) {
            $prefix = strtoupper(substr($category, 0, 3)); // Get first 3 letters of category
            $uniqueId = $prefix . "-" . uniqid(); // Generate unique ID
            return $uniqueId; // Return unique ID
        }
    }
?>