<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = 'getflixdb';

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "DB Connected successfully";
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
