<?php
    include_once __DIR__ . '/../models/database_connector.php'; // Include database connection file
    include_once __DIR__ . '/../models/products.php'; // Include Product model
    include_once __DIR__ . '/../controllers/buy.php'; // Include utility functions

    class BuyCnt {
        private $db_conn;
        private $utils; // Utility functions

        public function __construct($db) {
            $this->db_conn = $db; // Initialize database connection
            $this->productModel = new Products($db); // Initialize Product model
            $this->utils = new Utils(); // Initialize utility functions
        }
    }
?>