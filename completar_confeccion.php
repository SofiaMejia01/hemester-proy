<?php
include 'session_check.php'; // Include your session check

// Check if the ID is provided in the URL
if (isset($_GET['id'])) {
    $id_pedido = $_GET['id'];

    // Prepare the SQL statement to update Estado_Pedido to "Completo"
    $stmt = $conn->prepare("UPDATE agenda_confección SET Estado_Pedido = 'Completo' WHERE ID_Pedido = ?");
    $stmt->bind_param("i", $id_pedido);

    if ($stmt->execute()) {
        // Redirect to admin_menu.php after successful update
        header("Location: admin_menu.php");
        exit();
    } else {
        echo "Error updating pedido: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "No pedido ID provided.";
}

$conn->close(); // Close the database connection
?>