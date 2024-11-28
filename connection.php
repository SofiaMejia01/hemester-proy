<?php
// db_connect.php

$servername = "localhost"; // Usually localhost
$username = "root"; // Default username for XAMPP
$password = "mysql"; // Default password is empty for XAMPP
$dbname = "hemester_marco"; // The name of your database


// db de Sofia hemenster_marco
// pswd sofia mysql
//db de Marco hemenster_bd_users
//pswd marco ""


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


//comentario nuevo dwq3dwqdqw

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "";
?>