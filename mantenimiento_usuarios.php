<?php
include 'session_check.php';

// Fetch users from the usuario table
$sql = "SELECT u.ID_Usuario, u.Nombre_Trabajador, u.Nombre_Usuario, u.Password_Usuario, e.Nombre_Estado AS Estado, p.Nombre_Perfil AS Perfil 
        FROM usuario u 
        JOIN estado_usuario e ON u.ID_Estado = e.ID_Estado 
        JOIN perfiles_usuario p ON u.ID_Perfil = p.ID_Perfil";
$result = $conn->query($sql);

// Initialize variables for roles and states
$roles_result = [];
$states_result = [];

// Fetch existing roles
$roles_query = "SELECT ID_Perfil, Nombre_Perfil FROM perfiles_usuario";
$roles_result = $conn->query($roles_query);

// Fetch states
$states_query = "SELECT ID_Estado, Nombre_Estado FROM estado_usuario";
$states_result = $conn->query($states_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $password_usuario = $_POST['password_usuario'];
    $id_perfil = $_POST['perfil'];
    $id_estado = $_POST['estado'];
    $nombre_trabajador = $_POST['nombre_trabajador']; // New line to get the worker's name

    // Insert new user into the database
    $insert_stmt = $conn->prepare("INSERT INTO usuario (ID_Estado, ID_Perfil, Nombre_Usuario, Password_Usuario, Nombre_Trabajador) VALUES (?, ?, ?, ?, ?)");
    $insert_stmt->bind_param("iisss", $id_estado, $id_perfil, $nombre_usuario, $password_usuario, $nombre_trabajador); // Update binding

    if ($insert_stmt->execute()) {
        // Prepare a response for AJAX
        $response = [
            'status' => 'success',
            'newUserId' => $conn->insert_id,
            'nombre_trabajador' => $nombre_trabajador,
            'nombre_usuario' => $nombre_usuario,
            'password_usuario' => $password_usuario, // You might not want to show this
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => $insert_stmt->error,
        ];
    }
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="css/menu.css">
    
</head>
<body class="">

  <!-- Contenido principal -->
  <div class="container-fluid">
    <div class="row">
        <!-- Formulario para agregar un nuevo usuario -->
        <div class="col-12 col-xl-4">
            <div class="container">
                <br>
                <h3>Agregar Nuevo Usuario</h3>
                <form id="addUserForm" action="mantenimiento_usuarios.php" method="POST" class="p-3 border rounded">
                    <div class="form-group mb-3">
                        <label for="nombre_trabajador">Nombre del Trabajador</label>
                        <input type="text" class="form-control" id="nombre_trabajador" name="nombre_trabajador" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nombre_usuario">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password_usuario">Contraseña</label>
                        <input type="password" class="form-control" id="password_usuario" name="password_usuario" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="perfil">Perfil</label>
                        <select class="form-select" id="perfil" name="perfil" required>
                            <?php while ($row = $roles_result->fetch_assoc()): ?>
                                <option value="<?php echo $row['ID_Perfil']; ?>"><?php echo $row['Nombre_Perfil']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="estado">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <?php while ($row = $states_result->fetch_assoc()): ?>
                                <option value="<?php echo $row['ID_Estado']; ?>"><?php echo $row['Nombre_Estado']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Usuario</button>
                </form>
            </div>
        </div>

        <!-- Tabla de usuarios -->
        <div class="col-12 col-xl-8">
            <div class="table-section bg-white p-3">
                <br>
                <h5>Listado de Usuarios</h5>
                <br>
                <div class="table-responsive">
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
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
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
                                echo "<tr><td colspan='6'>No se encontraron usuarios</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
   
  </div>
                           
  <!-- Scripts -->
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="js/ajax_usuarios.js"></script>
  <script src="js/index.js"></script>

 
</body>
</html>
