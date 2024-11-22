<?php include 'session_check.php'; 
//include 'accesos.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user details based on the provided ID
    $stmt = $conn->prepare("SELECT u.ID_Usuario,u.Nombre_Trabajador, u.Nombre_Usuario, u.Password_Usuario, u.ID_Perfil, u.ID_Estado, e.Nombre_Estado AS Estado, p.Nombre_Perfil AS Perfil 
                             FROM usuario u 
                             JOIN estado_usuario e ON u.ID_Estado = e.ID_Estado 
                             JOIN perfiles_usuario p ON u.ID_Perfil = p.ID_Perfil 
                             WHERE u.ID_Usuario = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Usuario no encontrado.";
        exit();
    }
} else {
    echo "ID de usuario no proporcionado.";
    exit();
}

// Fetch existing roles and states for the dropdowns
$roles_query = "SELECT ID_Perfil, Nombre_Perfil FROM perfiles_usuario";
$roles_result = $conn->query($roles_query);

$states_query = "SELECT ID_Estado, Nombre_Estado FROM estado_usuario";
$states_result = $conn->query($states_query);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_trabajador = $_POST['nombre_trabajador'];
    $nombre_usuario = $_POST['username'];
    $password_usuario = $_POST['password'];
    $id_perfil = $_POST['rol'];
    $id_estado = $_POST['estado'];

    // Update the user details in the database
    $update_stmt = $conn->prepare("UPDATE usuario SET Nombre_Trabajador = ?, Nombre_Usuario = ?, Password_Usuario = ?, ID_Perfil = ?, ID_Estado = ? WHERE ID_Usuario = ?");
    $update_stmt->bind_param("ssssii", $nombre_trabajador, $nombre_usuario, $password_usuario, $id_perfil, $id_estado, $userId);
     // Return JSON response
    if ($update_stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $update_stmt->error]);
    }
    $update_stmt->close();
    exit();
}

$result = $conn->query("SELECT u.ID_Usuario, u.Nombre_Trabajador, u.Nombre_Usuario, u.Password_Usuario, e.Nombre_Estado AS Estado, p.Nombre_Perfil AS Perfil 
        FROM usuario u 
        JOIN estado_usuario e ON u.ID_Estado = e.ID_Estado 
        JOIN perfiles_usuario p ON u.ID_Perfil = p.ID_Perfil");
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>
    <!-- Contenido principal -->
            <div class="container-fluid">
                <div class="row">
                     <!-- Formulario para actualizar un usuario -->
                     <div class="col-12 col-xl-4">
                        <div class="container">
                            <br>
                            <h3>Modificar Usuario</h3>
                            <form id="updateUserForm" action="modificar_usuario.php?id=<?php echo $userId; ?>" method="POST" class="p-3 border rounded">
                                <div class="form-group mb-3">
                                    <label for="nombre_trabajador" class="form-label">Nombre del Trabajador:</label>
                                    <input type="text" name="nombre_trabajador" id="nombre_trabajador" class="form-control" 
                                        value="<?php echo htmlspecialchars($user['Nombre_Trabajador']); ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="username" class="form-label">Nombre de Usuario:</label>
                                    <input type="text" name="username" id="username" class="form-control" 
                                        value="<?php echo htmlspecialchars($user['Nombre_Usuario']); ?>" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password" class="form-label ">Contraseña:</label>
                                    <input type="password" name="password" id="password" class="form-control" 
                                        value="<?php echo htmlspecialchars($user['Password_Usuario']); ?>" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="rol" class="form-label">Perfil:</label>
                                    <select name="rol" id="rol" class="form-control" required>
                                        <?php while ($row = $roles_result->fetch_assoc()): ?>
                                            <option value="<?php echo $row['ID_Perfil']; ?>" 
                                                <?php echo ($row['ID_Perfil'] == $user['ID_Perfil']) ? 'selected' : ''; ?>>
                                                <?php echo $row['Nombre_Perfil']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="estado" class="form-label">Estado:</label>
                                    <select name="estado" id="estado" class="form-control" required>
                                        <?php while ($row = $states_result->fetch_assoc()): ?>
                                            <option value="<?php echo $row['ID_Estado']; ?>" 
                                                <?php echo ($row['ID_Estado'] == $user['ID_Estado']) ? 'selected' : ''; ?>>
                                                <?php echo $row['Nombre_Estado']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                            </form>
                        </div>
                    </div>

                   
                    <!-- <div class="divider"></div> -->

                   <!-- Tabla de usuarios -->
                    <div class="col-12 col-xl-8">
                    <div class="table-section bg-white">
                        <h5>Listado de Usuarios</h5>
                        <table id="listUser" class="display table table-striped">
                            <thead>
                                <tr>
                                <th>ID</th>
                                <th>Nombre del Trabajador</th>
                                <th>Nombre de Usuario</th>
                                <th>Contraseña</th>
                                <th>Perfil</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                                </tr>
                            </thead>                            
                            <?php
                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['ID_Usuario']}</td>
                                            <td>{$row['Nombre_Trabajador']}</td>
                                            <td>{$row['Nombre_Usuario']}</td>
                                            <td>{$row['Password_Usuario']}</td>
                                            <td>{$row['Perfil']}</td>
                                            <td>{$row['Estado']}</td>                                            
                                            <td>
                                                
                                                <a href='modificar_usuario.php?id={$row['ID_Usuario']}' class='LoadModificarUsuario'>Modificar</a>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No users found</td></tr>";
                            }
                            ?>                            
                        </table>
                    </div>                       
                    </div>
                  
                </div>
            </div>



           </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="js/ajax_modificarusuario.js"></script>  
    <script src="js/index.js"></script>    
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>