<?php

function getDatabaseConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "getflixdb";

    // Create connection
    $connection = new mysqli($servername, $username, $password, $database); 
    if ($connection->connect_error) {
        die("Error failed to connect to MYSQL: ". $connection->connect_error);
    }
    return $connection;
}