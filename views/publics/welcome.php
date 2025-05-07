<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if not already started
}

include_once '../../models/database_connector.php'; // Include database connection file
include_once '../../controllers/prods_con.php'; // Include Product controller file
include_once '../../controllers/utils.php'; // Include utility functions
include_once '../../controllers/usrs_con.php'; // Include User controller file

$db = new DatabaseConnector(); // Create a new instance of the database connection
$db_conn = $db->GetConnection(); // Get the database connection
$productController = new ProductController($db_conn); // Create a new instance of the Product controller
$utils = new Utils(); // Create a new instance of the utility functions

$err_msg = ''; // Initialize error message variable
$success_msg = ''; // Initialize success message variable

switch ($_SERVER['REQUEST_METHOD']) {
    // handle post request
    case 'POST':
        // TODO : check if user is requesting to buy product
        break;
    // handle get request
    case 'GET':
        // TODO : check if user is requesting to view product details
        break;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Welcome - PRODUCT LIST</title>
    <link rel="stylesheet" href="css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Stalinist+One&display=swap" rel="stylesheet">
</head>

<body>
    <div class="welcome-bar">
        <img src="image/logo_transparent.png" class="welcome-admin-image" alt="Login">
        <span class="site-name">Nebula</span>
    </div>


    <div class="container">
        <h2>Welcome To the Product List</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert success"><?php echo $_SESSION['success'];
                                        unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert error"><?php echo $_SESSION['error'];
                                        unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php
        $products = $productController->GetProducts();
        if (empty($products)) {
            echo "<div style='padding:24px;text-align:center;'>No products found</div>";
        }
        ?>
        <div class="product-list">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <span class="badge-star">Star+</span>
                    <span class="badge-discount">-83%</span>
                    <img src="<?php echo htmlspecialchars($product['prod_img']); ?>" alt="<?php echo htmlspecialchars($product['prod_name']); ?>" />
                    <div class="prod-desc">
                        <?php echo htmlspecialchars($product['prod_desc']); ?>
                    </div>
                    <div class="prod-meta">
                        <span>Category: <?php echo htmlspecialchars($product['prod_category']); ?></span>
                        <span>Qty: <?php echo htmlspecialchars($product['prod_qty']); ?></span>
                    </div>
                    <div class="prod-price">
                        <?php echo htmlspecialchars($utils->ConvertToRupiah($product['prod_price'])); ?>
                    </div>
                    <span class="prod-stock">STOK TERBATAS</span>
                    <form method="POST" action="" style="width:100%;">
                        <input type="hidden" name="prod_id" value="<?php echo $product['id']; ?>" />
                        <button type="submit" name="buy" class="buy-btn">Buy</button>
                    </form>
                </div>
            <?php endforeach; ?>
            <div class="container">
                <!-- button to go back to login page -->
                <a href="index.php" class="btn btn-primary mt-3">Back to Login</a>
            </div>
        </div>
    </div>
</body>

</html>