<?php
    include_once __DIR__ . '/../models/database_connector.php'; // Include database connection file
    # include_once __DIR__ . '/../models/products.php'; // Include Product model

    class ProductController {
        private $db_conn;
        private $productModel;

        public function __construct($db) {
            $this->db_conn = $db; // Initialize database connection
            # $this->productModel = new Products($db); // Initialize Product model
        }

        // Function to get all products
        public function GetProducts() {
            return $this->productModel->GetAllProducts(); // Call method from Product model to get all products
        }

        // Function to delete product by ID
        public function DeleteProduct($id) {
            return $this->productModel->DeleteProductById($id); // Call method from Product model to delete product by ID
        }
    }
?>
