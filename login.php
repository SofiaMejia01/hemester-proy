<?php
session_start(); // Start the session
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Nombre_Usuario = $_POST['Nombre_Usuario']; // Username input
    $Password_Usuario = $_POST['Password_Usuario']; // Password input

    // Prepare and execute the SQL statement to verify credentials
    $stmt = $conn->prepare("SELECT ID_Usuario, ID_Estado, ID_Perfil FROM usuario WHERE Nombre_Usuario = ? AND Password_Usuario = ? AND ID_Estado = 1");
    $stmt->bind_param("ss", $Nombre_Usuario, $Password_Usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user was found
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check the user's session state using the Nombre_Usuario
        $sessionStmt = $conn->prepare("SELECT Cod_Estado FROM sesion_usuario WHERE ID_Usuario = (SELECT Nombre_Usuario FROM usuario WHERE Nombre_Usuario = ?)");
        $sessionStmt->bind_param("s", $Nombre_Usuario);
        $sessionStmt->execute();
        $sessionResult = $sessionStmt->get_result();

        if ($sessionResult->num_rows > 0) {
            $session = $sessionResult->fetch_assoc();

            // Check if the Cod_Estado is 0 (allowed)
            if ($session['Cod_Estado'] == 0) {
                $_SESSION['username'] = $Nombre_Usuario; // Store username in session
               // Update Cod_Estado to 1 after successful login
                $updateStmt = $conn->prepare("UPDATE sesion_usuario SET Cod_Estado = 1, Fecha_Registro = NOW() WHERE ID_Usuario = (SELECT Nombre_Usuario FROM usuario WHERE Nombre_Usuario = ?)");
                $updateStmt->bind_param("s", $Nombre_Usuario);
                $updateStmt->execute();
                $updateStmt->close();

                // Redirect based on user profile
                switch ($user['ID_Perfil']) {
                    case 1: // Assuming 1 is for 'Administrador'
                        header("Location: admin_menu.php"); // Redirect to admin menu page
                        break;
                    case 2: // Assuming 2 is for 'Operador'
                        header("Location: operador_menu.php"); // Redirect to operator menu (you'll need to create this page)
                        break;
                    default:
                        echo "No existe el rol.";
                        break;
                }
                exit();
            } else {
                echo "Usuario no permitido. Estado de sesión no permitido.";
            }
        } else {
            echo "No se encontró la sesión del usuario.";
        }
    } else {
        echo "Usuario o contraseña inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">
        <h1 class="login-title">Bienvenido al sistema</h1>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" name="Nombre_Usuario" id="usuario" placeholder="Ingrese su usuario" required/>
            </div>
            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="Password_Usuario" id="contraseña" placeholder="Ingrese su contraseña" required />
            </div>
            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>