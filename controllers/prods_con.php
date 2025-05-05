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
        public function DeleteProduct($post) {
            $id = $post['prod_id']; // Get product ID from POST data
            return $this->productModel->DeleteProductById($id); // Call method from Product model to delete product
        }

        // Function to add product
        public function AddNewProduct($post, $file) {
            $this->productModel->name = $post['prod_name']; // Set product name
            $this->productModel->quantity = $post['prod_quantity']; // Set product quantity
            $this->productModel->description = $post['prod_description']; // Set product description
            $this->productModel->price = $post['prod_price']; // Set product price
            $this->productModel->category = $post['prod_category']; // Set product category

            // Handle image upload
            $target_file = $this->productModel->UploadImage($file['prod_img']); // Upload image and get target file path
            $this->productModel->image = $target_file; // Set product image path

            return $this->productModel->AddProduct(); // Call method from Product model to add product
        }

        // Function to edit product
        public function EditProduct($post, $file) {
            $this->productModel->id = $post['prod_id']; // Set product ID
            $this->productModel->name = $post['prod_name']; // Set product name
            $this->productModel->quantity = $post['prod_quantity']; // Set product quantity
            $this->productModel->description = $post['prod_description']; // Set product description
            $this->productModel->price = $post['prod_price']; // Set product price
            $this->productModel->category = $post['prod_category']; // Set product category

            // Handle image upload
            if (isset($file['prod_img']) && $file['prod_img']['error'] == UPLOAD_ERR_OK) {
                $target_file = $this->productModel->UploadImage($file['prod_img']); // Upload image and get target file path
                $this->productModel->image = $target_file; // Set product image path
            } else {
                // If no new image uploaded, keep the current image
                $this->productModel->image = $post['current_image'];
            }

            return $this->productModel->EditProduct(); // Call method from Product model to edit product
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
