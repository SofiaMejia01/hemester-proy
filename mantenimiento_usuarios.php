<?php
include 'session_check.php';

// Fetch users from the usuario table
$sql = "SELECT u.ID_Usuario, u.Nombre_Usuario, u.Password_Usuario, e.Nombre_Estado AS Estado, p.Nombre_Perfil AS Perfil 
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="css/menu.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

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
                                            <td>{$row['Nombre_Usuario']}</td>
                                            <td>{$row['Password_Usuario']}</td>
                                            <td>{$row['Perfil']}</td>
                                            <td>{$row['Estado']}</td>
                                            <td>
                                                <a href='modificar_usuario.php?id={$row['ID_Usuario']}'>Modificar</a>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="js/ajax_usuarios.js"></script>
  <script src="js/index.js"></script>

 
</body>
</html>
