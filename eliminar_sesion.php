<?php
session_start(); // Start the session
include 'connection.php'; // Include your database connection file

// Check if the session ID is provided in the URL
if (isset($_GET['id'])) {
    $id_sesion = $_GET['id'];

    // Prepare the SQL statement to update Cod_Estado to 0
    $stmt = $conn->prepare("UPDATE sesion_usuario SET Cod_Estado = 0 WHERE ID_Sesion = ?");
    $stmt->bind_param("i", $id_sesion);

    if ($stmt->execute()) {
        // Redirect to the control_sesiones.php page after successful update
        header("Location: control_sesiones.php");
        exit();
    } else {
        echo "Error updating session: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "No session ID provided.";
}

$conn->close(); // Close the database connection
?>