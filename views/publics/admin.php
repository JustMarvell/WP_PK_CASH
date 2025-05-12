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

// add, edit, and delete product
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['add_new_prod'])) {
            $productController->AddNewProduct($_POST, $_FILES); // Call method to add new product
        } elseif (isset($_POST['delete'])) {
            $productController->DeleteProduct($_POST); // Call method to delete product
        } elseif (isset($_POST['edit'])) {
            // $utils->Redirect('admin_edit_prod.php'); // Redirect to edit product page
        }
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
    <link rel="stylesheet" href="css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Stalinist+One&display=swap" rel="stylesheet">
</head>

<body>
    <div class="admin-bar">
        <img src="image/logo_transparent.png" class="welcome-admin-image" alt="Login">
        <span class="site-name">Nebula</span>
    </div>
    <div class="container">
        <h2>Admin Page</h2>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert success"><?php echo $_SESSION['success'];
                                        unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert error"><?php echo $_SESSION['error'];
                                        unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <?php if (isset($current_data)): ?>
                <input type="hidden" name="id" value="<?php echo $current_data['id']; ?>">
                <input type="hidden" name="gambar_lama" value="<?php echo $current_data['gambar']; ?>">
            <?php endif; ?>

            <!-- product name -->
            <div class="form-group">
                <label>Product Name:</label>
                <input type="text" name="prod_name" required
                    value="<?php echo isset($current_data) ? $current_data['prod_name'] : ''; ?>" class="form-control">
            </div>

            <!-- product price -->
            <div class="form-group">
                <label>Product Price:</label>
                <input type="text" name="prod_price" required
                    value="<?php echo isset($current_data) ? $current_data['prod_price'] : ''; ?>" class="form-control">
            </div>

            <!-- product quantity -->
            <div class="form-group">
                <label>Product Quantity:</label>
                <input type="text" name="prod_qty" required
                    value="<?php echo isset($current_data) ? $current_data['prod_qty'] : ''; ?>" class="form-control">
            </div>

            <!-- product category -->
            <div class="form-group">
                <label>Product Category:</label>
                <input type="text" name="prod_category" required
                    value="<?php echo isset($current_data) ? $current_data['prod_category'] : ''; ?>" class="form-control">
            </div>

            <!-- product description -->
            <div class="form-group">
                <label>Product Description:</label>
                <textarea name="prod_desc" required class="form-control"><?php echo isset($current_data) ? $current_data['prod_desc'] : ''; ?></textarea>
            </div>

            <!-- product img -->
            <div class="form-group">
                <label>Product Image:</label>
                <input type="file" name="prod_img" required
                    value="<?php echo isset($current_data) ? $current_data['nama'] : ''; ?>" class="form-control">
                <?php if (isset($current_data) && $current_data['prod_img']): ?>
                    <br><img src="uploads/<?php echo $current_data['prod_img']; ?>" class="img-prw">
                <?php endif; ?>
            </div>

            <!-- submit button -->
            <div class="form-group">
                <?php if (isset($current_data)) : ?>
                    <button type="submit" name="update" class="btn btn-primary">Update Data</button>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-secondary">Cancel</a>
                <?php else: ?>
                    <button type="submit" name="add_new_prod" class="btn btn-success">Add New Product</button>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Product Card to display all products -->
    <?php
    $products = $productController->GetProducts();
    if (empty($products)) {
        echo "<div style='padding:24px;text-align:center;'>No products found</div>";
    }
    ?>
    <div class='container'>
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
                    <div class="prod-actions">
                        <form method="GET" action="admin_edit_prod.php" style="display:inline;">
                            <input type="hidden" name="prod_id" value="<?php echo $product['id']; ?>" />
                            <button type="submit" class="edit-btn" name="edit">Edit</button>
                        </form>
                        <form method="POST" action="" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            <input type="hidden" name="prod_id" value="<?php echo $product['id']; ?>" />
                            <button type="submit" name="delete" class="delete-btn">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="container">
        <a href="index.php" class="btn btn-primary">Back to Login</a>
    </div>
</body>

</html>