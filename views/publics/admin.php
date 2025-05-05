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

    $err_msg = ''; // Initialize error message variable
    $success_msg = ''; // Initialize success message variable

    // add, edit, and delete product
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            if (isset($_POST['add_new_prod'])) {
                $productController->AddNewProduct($_POST, $_FILES); // Call method to add new product
            }
            // elseif (isset($_POST['edit'])) {
            //     // Edit product logic
            //     // Similar to add product logic but with edit functionality
            // } 
            // elseif (isset($_POST['delete'])) {
            //     // Delete product logic
            //     // Similar to add product logic but with delete functionality
            // }
            break;
        case 'GET':
            break; // Handle GET requests if needed
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
        <h2>Admin Page</h2>
        
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <?php if(isset($current_data)): ?>
                <input type="hidden" name="id" value="<?php echo $current_data['id']; ?>">
                <input type="hidden" name="gambar_lama" value="<?php echo $current_data['gambar']; ?>">
            <?php endif; ?>
            
            <!-- product name -->
            <div class="form-group">
                <label>product name:</label>
                <input type="text" name="prod_name" required 
                    value="<?php echo isset($current_data) ? $current_data['nama'] : ''; ?>" class="form-control">
            </div>

            <!-- product price -->
            <div class="form-group">
                <label>product price:</label>
                <input type="text" name="prod_price" required 
                    value="<?php echo isset($current_data) ? $current_data['nama'] : ''; ?>" class="form-control">
            </div>
            
            
        </form>
    </div>
</body>
</html>