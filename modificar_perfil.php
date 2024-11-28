<?php 
include 'session_check.php'; 
//include 'accesos.php';

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
        // Return success response with the URL to load
        echo json_encode(['status' => 'success', 'redirectUrl' => 'perfiles.php']);
    } else {
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
     <!-- Contenido principal -->
            <div class="container-fluid">
                <div class="row"> 
                     <!-- Formulario para actualizar un perfil -->                    
                    <div class="col-12 col-xl-4">
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
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-pen-to-square"></i>&nbsp;Actualizar Perfil</button>
                                </div>
                            </form> 
                        </div>
                    </div>

                   
                    <!-- <div class="divider"></div> -->

                    <!-- Tabla de perfiles -->
                     <div class="col-12 col-xl-8">
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
                                                <a href='modificar_perfil.php?id={$row['ID_Perfil']}' class='LoadModificarPerfil' >Modificar</a>
                                                
                                                <a href='eliminar_perfil.php?id={$row['ID_Perfil']}' class='LoadEliminarPerfil' onclick='return confirmDelete();'>Eliminar</a>
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
    <script src="js/index.js"></script>
    <script src="js/ajax_modificarperfil.js"></script>
    <script>
    function confirmDelete() {
        return confirm("¿Estás seguro de que deseas eliminar este perfil?");
    }
    </script>
</body>
</html>