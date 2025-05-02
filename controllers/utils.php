<?php
    class Utils {
        public static function Redirect($url) {
            header("Location: $url");
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
    }
?>