<?php
// Display all PHP errors (useful for development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function getDatabaseConnection() {
    // Define database connection parameters

    $dbusername = 'root';
    $dbpassword = '';
    $dsn = 'mysql:host=127.0.0.1;dbname=getflixdb';// Use variables for flexibility
    
    try { 
        // Create a new PDO instance and set the error mode to exception
        $pdo = new PDO($dsn, $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo; // Return the PDO instance
    } catch (PDOException $e) {
        // Handle the connection error
        echo "Connection failed: " . $e->getMessage();
    exit(); // Exit the script if the connection fails
    }
}

// Example usage (optional):
$pdo = getDatabaseConnection();