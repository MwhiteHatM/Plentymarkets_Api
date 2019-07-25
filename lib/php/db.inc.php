<?php

// database name 
$db_name = "db_name";
// server 
$servername = "server_name";
// user 
$user = "username";
// password 
$pass = "password";



try {
    // connection with database using PDO 
    $conn = new PDO("mysql:host=$servername;dbname=$db_name", $user, $pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully"; 
} catch (PDOException $e) {
    //echo "Connection failed: " . $e->getMessage();
}
    
