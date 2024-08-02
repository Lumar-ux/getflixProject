<?php

$dsn='mysql: host=localhost;dbname=getflixdb';
$dbusername="root";
$dbpassword="";
$dbname= "getflixdb";


$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];


try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
} catch (PDOException $e) {
    echo "Connection failed". $e->getMessage();
}