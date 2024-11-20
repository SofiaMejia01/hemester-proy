<?php 
include 'session_check.php'; 

// Fetch the profile to modify
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM perfiles_usuario WHERE ID_Perfil = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('Perfil no encontrado.'); window.location.href='perfiles.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID de perfil no proporcionado.'); window.location.href='perfiles.php';</script>";
    exit();
}

// Handle form submission for updating the profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombrePerfil = $_POST['nombre_perfil'];
    $descripcionPerfil = $_POST['descripción_perfil'];

    $stmt = $conn->prepare("UPDATE perfiles_usuario SET Nombre_Perfil = ?, Descripción_Perfil = ? WHERE ID_Perfil = ?");
    $stmt->bind_param("ssi", $nombrePerfil, $descripcionPerfil, $id);
    
    if ($stmt->execute()) {
        // Return success response
        echo json_encode(['status' => 'success']);
    } else {
        // Return error response
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    $stmt->close();
    exit();

}


$result = $conn->query("SELECT * FROM perfiles_usuario");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>
    <!-- Barra de arriba -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary px-3 navbar-divider">
        <div class="container-fluid">
            <!-- Logo -->
            <a href="admin_menu.php"> <img src="img/logoHemenster.png" alt="Logo" style="width: 100px; height: 100px; object-fit: cover;"></
                <img src="img/logoHemenster.png" alt="Logo o Imagen" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
            </a>

            <!-- Espacio flexible -->
            <div class="d-flex ms-auto align-items-center">
                <!-- Texto "Hola, usuario" -->
                <span class="navbar-text text-light me-3" style="font-size: 24px;">
                    Hola, <?php echo htmlspecialchars($nombreUsuario); ?>
                </span>
                <!-- Botón "Cerrar Sesión" -->
                <form action="cerrar_sesion.php" method="POST">
                    <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </nav>

 <!-- Barra de la izquierda -->   
    <div class="container-fluid">
        <div class="row vh-100">
            <nav class="col-12 col-md-2 bg-primary text-light p-3 vh-100">
                <ul class="nav flex-column">                    
                    <li class="nav-item sidebar-item py-2">
                        <a class="nav-link text-light" href="mantenimiento_usuarios.php">Gestión de Usuarios</a>
                    </li>
                    <li class="nav-item sidebar-item py-2">
                        <a class="nav-link text-light" href="perfiles.php">Perfiles</a>
                    </li>
                    <li class="nav-item sidebar-item py-2">
                        <a class="nav-link text-light" href="control_sesiones.php">Control de Sesiones</a>
                    </li>
                </ul>
            </nav>
            <main class="col-12 col-md-10">
                <div class="content-row">                    
                    <div class="col-4">
                        <div class="container">
                            <br>
                            <h3 class="mb-4">Modificar Perfil</h3>
                            <form id="updateProfileForm" action="modificar_perfil.php?id=<?php echo $row['ID_Perfil']; ?>" method="POST" class="p-3 border rounded">
                                <div class="form-group mb-3">
                                    <label for="nombre_perfil" class="form-label">Nombre del Perfil:</label>
                                    <input type="text" name="nombre_perfil" id="nombre_perfil" class="form-control" value="<?php echo htmlspecialchars($row['Nombre_Perfil']); ?>" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="descripción_perfil" class="form-label">Descripción del Perfil:</label>
                                    <input type="text" name="descripción_perfil" id="descripción_perfil" class="form-control" value="<?php echo htmlspecialchars($row['Descripción_Perfil']); ?>" required>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary px-4">Modificar</button>
                                </div>
                            </form> 
                        </div>
                    </div>

                   
                    <div class="divider"></div>

                   
                    <div class="table-section bg-white">
                        <h5>Listado de Perfiles</h5>
                        <table id="listRole" class="display table table-striped">
                            <thead>
                                <tr>
                                <th>ID</th>
                                <th>Nombre del Perfil</th>
                                <th>Descripción del Perfil</th>
                                <th>Acciones</th>
                                </tr>
                            </thead>                            
                            <?php
                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['ID_Perfil']}</td>
                                            <td>{$row['Nombre_Perfil']}</td>
                                            <td>{$row['Descripción_Perfil']}</td>
                                            <td>
                                                <a href='modificar_perfil.php?id={$row['ID_Perfil']}'>Modificar</a>
                                                <a href='eliminar_perfil.php?id={$row['ID_Perfil']}' onclick='return confirmDelete();'>Eliminar</a>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No hay perfiles registrados</td></tr>";
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
    <script src="js/ajax_modificarperfil.js"></script>
    <script>
    function confirmDelete() {
        return confirm("¿Estás seguro de que deseas eliminar este perfil?");
    }
    </script>
</body>
</html>