<!-- for logout purposes -->

<?php
    //start session
    session_start();

    // delete all session variables
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy(); // destroy session
    header("Location: index.php"); // redirect to login page
    exit(); // exit script
?>