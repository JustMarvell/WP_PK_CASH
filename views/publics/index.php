<!-- LOGIN PAGE DISINI -->

<?php
    session_start();
    include_once '../../models/database_connector.php'; // include database connection file
    include_once '../../controllers/authenticator.php'; // include authentication controller file
    include_once '../../controllers/utils.php'; // include utility functions

    // Create a new instance of the database connection
    $db = new DatabaseConnector();
    $db_conn = $db->GetConnection();

    $auth = new authentication($db_conn); // Create a new instance of the authentication controller
    $err_msg = ''; // Initialize error message variable

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Call the login function when the form is submitted
        $err_msg = $auth->login();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- custom css style -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- font google : poppins -->
    <link rel="stylesheet" href="../css/google-poppins-style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid main d-flex justify-content-center align-items-center">
        <div class="login-box text-center">
            <h1 class="mt-5 pt-5">Login</h1>
            <form method="POST" action="index.php">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <?php if ($err_msg): ?>
                    <div class="alert alert-danger"><?php echo $err_msg; ?></div>
                <?php endif; ?>
                
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
