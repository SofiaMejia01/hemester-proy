<?php
// db_connect.php

$servername = "localhost"; // Usually localhost
$username = "root"; // Default username for XAMPP
$password = ""; // Default password is empty for XAMPP
$dbname = "hemenster_bd_users"; // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "";
?>