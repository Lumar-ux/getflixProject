<?php
session_start(); // Start the session

// Clear all session variables
$_SESSION = array();

// If using cookies, delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Redirect to the homepage or login page
header("Location: index.php"); // or header("Location: login.php");
exit;