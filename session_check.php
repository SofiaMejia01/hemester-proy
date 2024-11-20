<?php
session_start(); // Start the session
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Get the username from the session
$nombreUsuario = $_SESSION['username'];

// Fetch the user's details from the database
$stmt = $conn->prepare("SELECT ID_Usuario, ID_Estado, ID_Perfil FROM usuario WHERE Nombre_Usuario = ?");
$stmt->bind_param("s", $nombreUsuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $userId = $user['ID_Usuario'];
    $userProfile = $user['ID_Perfil'];

    // Check the user's session state using the Nombre_Usuario
    $sessionStmt = $conn->prepare("SELECT Cod_Estado FROM sesion_usuario WHERE ID_Usuario = (SELECT Nombre_Usuario FROM usuario WHERE Nombre_Usuario = ?)");
    $sessionStmt->bind_param("s", $nombreUsuario);
    $sessionStmt->execute();
    $sessionResult = $sessionStmt->get_result();

    if ($sessionResult->num_rows > 0) {
        $session = $sessionResult->fetch_assoc();

        // Check if the Cod_Estado is 0 (allowed)
        if ($session['Cod_Estado'] != 1) {
            echo "Usuario no permitido. Estado de sesión no permitido.";
            exit();
        }
    } else {
        echo "No se encontró la sesión del usuario.";
        exit();
    }
} else {
    echo "Usuario no encontrado.";
    exit();
}
?>