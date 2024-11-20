<?php 
include 'session_check.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM perfiles_usuario WHERE ID_Perfil = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Redirect back to perfiles.php after successful deletion
        header("Location: perfiles.php");
        exit();
    } else {
        // Handle the error (optional)
        header("Location: perfiles.php"); // Redirect even on error
        exit();
    }
    $stmt->close();
} else {
    // Redirect if no ID is provided
    header("Location: perfiles.php");
    exit();
}
?>