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
    $userController = new UserCnt($db_conn); // Create a new instance of the User controller
    $utils = new Utils(); // Create a new instance of the utility functions

    // Check if the user not an admin, if not redirect to login page
    if ($_SESSION['role'] != 'admin') {
        header('Location: index.php'); // Redirect to login page
        exit();
    }

    if (!isset($_GET['prod_id'])) {
        die("INVALID PRODUCT ID");
    }

    $prd_id = strval($_GET['prod_id']);
    $product = $productController->GetProductByID($prd_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['edit_prod'])) {
            $productController->EditProduct($_POST, $_FILES);
            header('Location:admin.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<style>
    .container { 
        width: 80%;
        margin:  auto;
    }

    table { 
        border-collapse: collapse; 
        width: 100%; 
        margin-top: 20px; 
    }

    th, td { 
        border: 1px solid #ddd; 
        padding: 8px; 
        text-align: left; 
    }

    th { 
        background-color: #f2f2f2; 
    }

    .form-group { 
        margin-bottom: 15px; 
    }

    .alert { 
        padding: 10px; 
        margin: 10px 0; 
    }

    .success { 
        background-color: #dff0d8; 
        border-color: #d6e9c6; 
        color: #3c763d; 
    }

    .error { 
        background-color: #f2dede; 
        border-color: #ebccd1; 
        color: #a94442; 
    }

</style>
<body>
    <div class="container">
        <!-- button to go back to admin page -->
        <a href="admin.php" class="btn btn-primary">back to admin page</a>
    </div>

    <div class="container">
        <h2>Edit Product Data</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert success"><?php echo $_SESSION['success'];
                                        unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert error"><?php echo $_SESSION['error'];
                                        unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <?php if ($product):?>
            <input type="text" name="prod_id" value="<?php echo isset($product) ? $product['id'] : ''; ?> ">
            <input type="text" name="current_image" value="<?php echo isset($product) ? $product['prod_img'] : ''; ?>">
        <?php endif;?>

            <!-- product name -->
            <div class="form-group">
                <label>Product Name:</label>
                <input type="text" name="prod_name" required
                    value="<?php echo isset($product) ? $product['prod_name'] : ''; ?>" class="form-control">
            </div>

            <!-- product price -->
            <div class="form-group">
                <label>Product Price:</label>
                <input type="text" name="prod_price" required
                    value="<?= $product['prod_price'] ?? ''; ?>" class="form-control">
            </div>

            <!-- product quantity -->
            <div class="form-group">
                <label>Product Quantity:</label>
                <input type="text" name="prod_qty" required
                    value="<?php echo isset($product) ? $product['prod_qty'] : ''; ?>" class="form-control">
            </div>

            <!-- product category -->
            <div class="form-group">
                <label>Product Category:</label>
                <input type="text" name="prod_category" required
                    value="<?php echo isset($product) ? $product['prod_category'] : ''; ?>" class="form-control">
            </div>

            <!-- product description -->
            <div class="form-group">
                <label>Product Description:</label>
                <textarea id="prod_description" name="prod_description" required class="form-control"><?= $product['prod_desc'] ?? ''; ?></textarea>
            </div>

            <!-- product img -->
            <div class="form-group">
                <label>Product Image:</label>
                <input type="file" name="prod_img"
                    class="form-control">
            </div>

            <!-- submit button -->
            <div class="form-group">
                <button type="submit" name="edit_prod" class="btn btn-success">Edit Product</button>
            </div>
        </form>
    </div>
</body>
</html>