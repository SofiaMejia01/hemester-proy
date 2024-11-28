<?php
include 'session_check.php';  // Include your database connection file

// Check if the ID is provided in the URL
if (isset($_GET['id'])) {
    $id_joya = $_GET['id'];

    // Prepare the SQL statement to update estado_joya to 1 (soft delete)
    $stmt = $conn->prepare("UPDATE joya SET estado_joya = 1 WHERE ID_Joya = ?");
    $stmt->bind_param("i", $id_joya);

    if ($stmt->execute()) {
        // Redirect back to gestion_productos.php after successful update
        header("Location: gestion_productos.php");
        exit();
    } else {
        echo "Error deleting jewelry: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "No jewelry ID provided.";
}

$conn->close(); // Close the database connection
?>