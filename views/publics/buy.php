<?php
    session_start();

    include_once '../../models/database_connector.php'; // Include database connection file
    include_once '../../controllers/prods_con.php'; // Include Product controller file
    include_once '../../controllers/utils.php'; // Include utility functions
    include_once '../../controllers/usrs_con.php'; // Include User controller file
    include_once '../../controllers/purch_con.php'; // Include purchase controller file

    $db = new DatabaseConnector(); // Create a new instance of the database connection
    $db_conn = $db->GetConnection(); // Get the database connection
    $productController = new ProductController($db_conn); // Create a new instance of the Product controller
    $utils = new Utils(); // Create a new instance of the utility functions
    $userController = new UserCnt($db_conn); // Create a new instance of the User controller
    $purchaseController = new PurchCon($db_conn); // Create a new instance of the purchase controller

    if (!isset($_GET['prod_id'])) {
        die("INVALID PRODUCT ID");
    }

    $prd_id = strval($_GET['prod_id']);
    $product = $productController->GetProductByID($prd_id);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $receipt = $purchaseController->CreateReceipt($product['prod_name'], $_POST['ord_qty'], $product['prod_price']);

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="receipt.txt"');
        echo $receipt;
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Product</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Script JS untung nda error hehe kl error nti bilang -->
    <script>

        // Function to update total price based on order quantity
        function UpdateTotalPrice() {
            const quantity = document.getElementById('ord_qty').value;
            const itemPrice = <?php echo $product['prod_price'];  ?>;
            const total = quantity * itemPrice;
            const formatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total);
            document.getElementById('prc_total').textContent = formatted;
        }

    </script>
    </head>
<body>
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Other detail here -->
    <div class='container'>
        <h1>PRODUCT DETAILS</h1>
    </div>

    <!-- Product detail here -->
    <div class='container'>
        <img src="<?php echo htmlspecialchars($product['prod_img'])?>" alt="" style="width:350px; height:350px">
        <h4>Name : <?php echo htmlspecialchars($product['prod_name']) ?></h4>
        <p>Category : <?php echo htmlspecialchars($product['prod_category']) ?></p>
        <p>Description : <?php echo htmlspecialchars($product['prod_desc']) ?></p>
        <p>In Stock : <?php echo htmlspecialchars($product['prod_qty']) ?></p>
        <p>Price : <?php echo htmlspecialchars($utils->ConvertToRupiah($product['prod_price'])); ?></p>

        <!-- Buy button -->
        <form action="" method="post">
            <div class='form-group'>
                <label for="ord_qty">Order Quantity:</label>
                <input type="number" name="ord_qty" id="ord_qty" max="<?php echo $product['prod_qty'] ?>" value="1" required min="1" oninput="UpdateTotalPrice()">
                <br>
                Total Price :
                <span id="prc_total">

                </span>
            </div>

            <button class="btn btn-success" type="submit" name="buy">BUY</button>
        </form>

        <script>UpdateTotalPrice()</script>
    </div>

    <!-- Other product list here -->
    <div class='container'>
        
    </div>
</body>
</html>