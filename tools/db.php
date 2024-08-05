<?php 
// Database configuration
$dsn = 'mysql:host=localhost;dbname=getflixdb';
$dbusername = "root";
$dbpassword = "";

try {
// Create and check connection
$pdo = new PDO($dsn, $dbusername, $dbpassword);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
exit();
}