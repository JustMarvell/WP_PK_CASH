<?php
    include_once __DIR__ . '/../models/database_connector.php'; // Include database connection file
    include_once __DIR__ . '/../models/products.php'; // Include Product model

    class ProductController {
        private $db_conn;
        private $productModel;

        public function __construct($db) {
            $this->db_conn = $db; // Initialize database connection
            $this->productModel = new Products($db); // Initialize Product model
        }

        // Function to get all products
        public function GetProducts() {
            return $this->productModel->GetAllProducts(); // Call method from Product model to get all products
        }

        // Function to delete product by ID
        public function DeleteProduct($id) {
            return $this->productModel->DeleteProductById($id); // Call method from Product model to delete product by ID
        }

        // Function to add product
        public function AddProduct($name, $quantity, $description, $image, $price, $category) {
            return $this->productModel->AddProduct($name, $quantity, $description, $image, $price, $category); // Call method from Product model to add product
        }

        // Function to edit product
        public function EditProduct($id, $name, $quantity, $description, $image, $price, $category) {
            return $this->productModel->EditProduct($id, $name, $quantity, $description, $image, $price, $category); // Call method from Product model to edit product
        }

        // Function to get product by ID
        public function GetProductByID($id) {
            return $this->productModel->GetProductById($id); // Call method from Product model to get product by ID
        }

        // Function to upload image
        public function UploadImage($img) {
            return $this->productModel->UploadImage($img); // Call method from Product model to upload image
        }

        // Function to update quantity
        public function UpdateQuantity($id, $new_qty) {
            return $this->productModel->UpdateProductQty($id, $new_qty); // Call method from Product model to update quantity
        }

        // Function to search product
        public function SearchProduct($search) {
            return $this->productModel->SearchProduct($search); // Call method from Product model to search product
        }
    }
?>
