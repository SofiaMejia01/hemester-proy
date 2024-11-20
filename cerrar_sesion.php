<?php
session_start(); // Start the session
include 'connection.php'; // Include your database connection file

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Get the username from the session
    $nombre_usuario = $_SESSION['username'];

    // Update Cod_Estado to 0 in the sesion_usuario table based on the Nombre_Usuario
    $updateStmt = $conn->prepare("UPDATE sesion_usuario SET Cod_Estado = 0 WHERE ID_Usuario = (SELECT Nombre_Usuario FROM usuario WHERE Nombre_Usuario = ?)");
    $updateStmt->bind_param("s", $nombre_usuario);
    $updateStmt->execute();
    $updateStmt->close();

    // Unset all session variables and destroy the session
    session_unset();
    session_destroy();
}

// Redirect to the login page
header("Location: login.php");
exit();
?>