<?php

function getDatabaseConnection(){
    $host = 'localhost';
    $dbusername = 'root';
    $dbpassword = '';
    $dbname = 'getflixdb';
    $dsn = 'mysql:host=localhost;dbname=getflixdb';

    // Create connection
    $connection = new mysqli($host, $dbusername, $dbpassword, $dbname);
    // Check connection
    if ($connection->connect_error) {
        die('Error failed to connect to MySQL: '. $connection->connect_error);
    }
    return $connection;
}
?>