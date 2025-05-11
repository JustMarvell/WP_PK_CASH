<?php
    include_once __DIR__ . '/../models/database_connector.php'; // Include database connection file
    include_once __DIR__ . '/../models/products.php'; // Include Product model
    include_once __DIR__ . '/../models/purchase.php'; // Include purchase model
    include_once __DIR__ . '/../controllers/utils.php'; // Include utility functions

    class PurchCon {
        private $db_conn;
        private $productModel;
        private $purchaseModel;
        private $utils; // Utility functions

        // pm var name
        // product_id;
        // user_id;
        // order_date;
        // order_quantity;
        // discount_value;
        // total_price;

        // Constructor
        public function __construct($db) {
            $this->db_conn = $db; // Initialize database connection
            $this->productModel = new Products($db); // Initialize Product model
            $this->purchaseModel = new Purchase($db); // Initialize Purchase model
            $this->utils = new Utils(); // Initialize utility functions
        }

        // Function to get all purchase
        public function GetPurchases() {
            return $this->purchaseModel->GetAllPurchases();
        }

        // Function to delete purchase by ID
        // still deciding on which method to use. for now just use this
        public function DeletePurchase($post) {
            $id = $post['purch_id'];
            return $this->purchaseModel->DeletePurchase($id);
        }

        // Function to add product
        // still deciding if the data will include image or not
        // for now will not
        public function AddNewPurchase($post) {
            $this->purchaseModel->product_id = $post['prod_id'];
            $this->purchaseModel->user_id = $post['usr_id'];
            $this->purchaseModel->order_date = date('Y-m-d H:i:s');
            $this->purchaseModel->order_quantity = $post['ord_qty'];

            $crtProd = $this->productModel->GetProductById($this->purchaseModel->product_id);

            // Check the quantity available
            if ($this->purchaseModel->order_quantity > $crtProd['prod_qty']) {
                return "Failed to purchase product : Not Enough Stock!";
            }

            // Create a purchase || Make a purchase oskdfj9awhefkasjfoashdkfhasidfapefsjikosef jio; jko;asdf 
            if ($this->productModel->CreatePurchase()) {
                $nQty = $crtProd['prod_qty'] - $this->purchaseModel->order_quantity;
                $this->productModel->UpdateQuantity($this->productModel->id, $nQty);
                return "Purchase is successful";
            } else {
                return "Purchase failed";
            }
        }

        public function CreateReceipt($name, $qty, $price) {
            return $this->purchaseModel->CreateReceipt($name, $qty, $price, date('Y-m-d H:i:s'));
        }
    }
?>