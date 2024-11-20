<?php
include 'session_check.php';
include 'accesos.php';

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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $password_usuario = $_POST['password_usuario'];
    $id_perfil = $_POST['perfil'];
    $id_estado = $_POST['estado'];

    // Insert the new user into the database
    $stmt1 = $conn->prepare("INSERT INTO usuario (Nombre_Usuario, Password_Usuario, ID_Perfil, ID_Estado) VALUES (?, ?, ?, ?)");
    $stmt1->bind_param("ssii", $nombre_usuario, $password_usuario, $id_perfil, $id_estado);

    header('Content-Type: application/json');
    if ($stmt1->execute()) {
    // Preparar la respuesta JSON con todos los datos, incluyendo la contraseña
     $response = [
        "status" => "success",
        "newUserId" => $stmt1->insert_id, // El ID del nuevo usuario insertado
        "nombre_usuario" => $nombre_usuario,
        "password_usuario" => $password_usuario, // Incluir la contraseña en la respuesta
        "perfil" => $id_perfil, 
        "estado" => $id_estado
    ];
    } else {
    // En caso de error
    $response = [
        "status" => "error",
        "message" => "Error al agregar el usuario."
        ];
    }
    
    // Output JSON response without displaying the JSON in the browser
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="css/menu.css">

    
</head>
<body>
 
            <main class="col-12 col-md-10">
                <div class="content-row">                    
                    <div class="col-4">
                        <div class="container">
                            <br>
                            <h3>Agregar Nuevo Usuario</h3>
                            <form  id="addUserForm" action="mantenimiento_usuarios.php" method="POST" class="p-3 border rounded">
                                <div class="form-group mb-3">
                                    <label for ="nombre_usuario">Nombre de Usuario</label>
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

                   
                    <div class="divider"></div>

                   
                    <div class="table-section bg-white">
                        <h5>Listado de Usuarios</h5>
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
                            <?php
                            if ($result->num_rows > 0) {
                                // Output data of each row
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
                                echo "<tr><td colspan='5'>No users found</td></tr>";
                            }
                            ?>                            
                        </table>
                    </div> 
                </div>
            </main>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="js/index.js"></script>
    <script src="js/ajax_usuarios.js"></script>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>