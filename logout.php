<?php 
// Initialize the session
session_start();

// Unset of the session variables
$_SESSION = [];

// Destroy the session
session_abort();

// Redirect to the home page
header("location: index.php");