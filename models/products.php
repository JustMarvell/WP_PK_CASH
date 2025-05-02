<?php
    include_once __DIR__ . '/../controllers/utils.php'; // Include utility functions    

    class Products {
        private $db_conn;
        private $table = "products_data";
        private $utils; // Utility functions

        public $id;
        public $name;
        public $quantity;
        public $description;
        public $image;
        public $price;
        public $category;

        public function __construct($db) {
            $this->db_conn = $db;
            $this->utils = new Utils(); // Initialize utility functions
        }

        // Get all products
        public function GetAllProducts(): array {
            $q = "SELECT * FROM " . $this->table;
            $sql = $this->db_conn->prepare($q);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); // Return all products
        }

        // Delete product by ID
        public function DeleteProductById($id): bool {
            $q = "DELETE FROM " . $this->table . " WHERE id = :id";
            $sql = $this->db_conn->prepare($q);
            $sql->bindParam(':id', $id);
            return $sql->execute(); // Return execution result
        }

        // Add product
        public function AddProduct($name, $quantity, $description, $image, $price, $category): bool {
            $q = "INSERT INTO " . $this->table . " (id, prod_name, prod_qty, prod_desc, prod_img, prod_price, prod_category) 
                  VALUES (:id, :name, :quantity, :description, :image, :price, :category)";
            
            $sql = $this->db_conn->prepare($q);
            $sql->bindParam(':id', $this->utils->SetUniqueProductId($category)); // Bind unique ID
            $sql->bindParam(':name', $name);
            $sql->bindParam(':quantity', $quantity);
            $sql->bindParam(':description', $description);
            $sql->bindParam(':image', $image);
            $sql->bindParam(':price', $price);
            $sql->bindParam(':category', $category);

            return $sql->execute(); // Return execution result
        }

        // Edit product
        public function EditProduct($id, $name, $quantity, $description, $image, $price, $category): bool {
            $q = "UPDATE " . $this->table . " SET prod_name = :name, prod_qty = :quantity, 
                  prod_desc = :description, prod_img = :image, prod_price = :price, prod_category = :category 
                  WHERE id = :id";
            
            $sql = $this->db_conn->prepare($q);
            $sql->bindParam(':id', $id);
            $sql->bindParam(':name', $name);
            $sql->bindParam(':quantity', $quantity);
            $sql->bindParam(':description', $description);
            $sql->bindParam(':image', $image);
            $sql->bindParam(':price', $price);
            $sql->bindParam(':category', $category);

            return $sql->execute(); // Return execution result
        }

        // Get product by ID
        public function GetProductById($id): array {
            $q = "SELECT * FROM " . $this->table . " WHERE id = :id";
            $sql = $this->db_conn->prepare($q);
            $sql->bindParam(':id', $id);
            $sql->execute();
            return $sql->fetch(PDO::FETCH_ASSOC); // Return product data
        }

        // Upload image
        public function UploadImage($image) {
            $target_dir = "uploads/"; // Directory to save uploaded images
            $file_name = uniqid() . "_" . basename($image["name"]); // Unique file name
            $target_file = $target_dir . $file_name; // Full path to save the image]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($image["tmp_name"]); // Check if image file is a valid image
            if ($check === false) {
                $uploadOk = 0; // Not a valid image
            }

            // Check file size (limit to 10MB)
            if ($image["size"] > 10000000) {
                $uploadOk = 0;
            }

            // Allow certain file formats
            if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                return false; // Upload failed
            } else {
                if (move_uploaded_file($image["tmp_name"], $target_file)) {
                    return $target_file; // Return the path of the uploaded image
                } else {
                    return false; // Upload failed
                }
            }
        }

        // update product qty
        public function UpdateProductQty($id, $new_quantity): bool {
            $q = "UPDATE " . $this->table . " SET prod_qty = :quantity WHERE id = :id";
            $sql = $this->db_conn->prepare($q);
            $sql->bindParam(':id', $id);
            $sql->bindParam(':quantity', $new_quantity);
            return $sql->execute(); // Return execution result
        }

        // search product by name or category
        public function SearchProduct($search): array {
            $q = "SELECT * FROM " . $this->table . " WHERE prod_name LIKE :search OR prod_category LIKE :search";
            $sql = $this->db_conn->prepare($q);
            $search = "%$search%"; // Add wildcards for search
            $sql->bindParam(':search', $search);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); // Return search results
        }
    }
?>