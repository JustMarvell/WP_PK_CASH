<?php
    class Purchase {
        private $db_conn;
        private $table = 'order_inf';

        private $utils; // Utility functions

        public $id;
        public $product_id;
        public $user_id;
        public $order_date;
        public $order_quantity;
        public $discount_value;
        public $total_price;

        public function __construct($db) {
            $this->db_conn = $db; // Initialize database connection
            $this->utils = new Utils();
        }

        // Function to create a new purchase
        public function CreatePurchase() : bool {
            $q = "INSERT INTO " . $this->table . " (id, prod_id, usr_id, order_date, ord_qty, disc_val, total_ord_prc)
                VALUES (:id, :prod_id, :usr_id, :order_date, :ord_qty, :disc_val, :total_ord_prc)";

            $sql = $this->db_conn->prepare($q);

            // set unique ID for the purchase
            $this->id = $this->utils->SetUniqueStringID('ord' . $this->product_id);
            
            // Bind parameters
            $sql->bindParam(':id', $this->id);
            $sql->bindParam(':prod_id', $this->product_id);
            $sql->bindParam(':usr_id', $this->user_id);
            $sql->bindParam(':order_date', $this->order_date);
            $sql->bindParam(':ord_qty', $this->order_quantity);
            $sql->bindParam(':disc_val', $this->discount_value);
            $sql->bindParam(':total_ord_prc', $this->total_price);

            // Execute the query
            return $sql->execute();
        }

        // Function to get all the purchaseses
        public function GetAllPurchases() : array {
            $q = "SELECT * FROM " . $this->table;

            $sql = $this->db_conn->prepare($q);
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC); // Return all purchases
        }

        // Function to get a purchase by ID
        public function GetPurchaseByID($id) {
            $q = "SELECT * FROM " . $this->table . " WHERE id = :id";

            $sql = $this->db_conn->prepare($q);
            $sql->bindParam(':id', $id);
            $sql->execute();

            return $sql->fetch(PDO::FETCH_ASSOC); // Return purchase by ID
        }

        // Function to delete a purchase
        // still confused about this function on what to do
        // so for now just make query to delete the purchase
        public function DeletePurchase($id) {
            $q = "DELETE FROM " . $this->table . " WHERE id = :id";

            $sql = $this->db_conn->prepare($q);
            $sql->bindParam(':id', $id);

            return $sql->execute();
        }

        // Function to update a purchase
        public function UpdatePurchase($id, $order_qty) {
            $q = "UPDATE " . $this->table . " SET ord_qty = :ord_qty WHERE id = :id";

            $sql = $this->db_conn->prepare($q);
            
            $sql->bindParam(':ord_qty', $order_qty);
            $sql->bindParam(':id', $id);

            return $sql->execute(); // ekex
        }

        // Function to create purchase receipt
        public function CreateReceipt($name, $qty, $price, $ord_date) {
            $receipt = "NEBULA PURCHASE RECEIPT\n=============================\n";
            $receipt .= "Product Name : " . $name . "\n";
            $receipt .= "Order Quantity : " . $qty . "\n";
            $receipt .= "Total Price : " . $this->utils->ConvertToRupiah($price * $qty) . "\n";
            $receipt .= "Order Date : " . $ord_date . "\n";
            $receipt .= "=============================\nTHANK YOU FOR YOUR PURCHASE!\nMAY YOUR FATE SHINE BRIGHT LIKE THE STARS";

            return $receipt;
        }
    }
?>