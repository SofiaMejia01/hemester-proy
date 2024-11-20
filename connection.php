<?php
// db_connect.php

$servername = "localhost"; // Usually localhost
$username = "root"; // Default username for XAMPP
$password = "mysql"; // Default password is empty for XAMPP
$dbname = "hemenster_marco"; // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


//comentario nuevo dwq3dwqdqw

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "";
?>