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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - PRODUCT LIST</title>

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
        <h2>Welcome to the Product List</h2>
        
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display products from the database
                $products = $productController->GetProducts();
                if (empty($products)) {
                    echo "<tr><td colspan='5'>No products found</td></tr>";
                } 
                ?>
                 <?php foreach ($products as $product): ?>
                <tr class="table-light">
                    <td><?php echo htmlspecialchars($product['prod_name']); ?></td>
                    <td><?php echo htmlspecialchars($utils->ConvertToRupiah($product['prod_price'])); ?></td>
                    <td><?php echo htmlspecialchars($product['prod_qty']); ?></td>
                    <td><?php echo htmlspecialchars($product['prod_category']); ?></td>
                    <td><?php echo htmlspecialchars($product['prod_desc']); ?></td>
                    <td><img src="<?php echo $product['prod_img']; ?>" class="img-prw"></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="prod_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" name="buy" class="btn btn-danger">Buy</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>    

    </div>
</body>
</html>