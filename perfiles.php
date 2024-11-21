<?php 
include 'session_check.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre_perfil'])) {
    $nombrePerfil = $_POST['nombre_perfil'];
    $descripcionPerfil = $_POST['descripción_perfil'];

    // Insert new profile into the database
    $stmt = $conn->prepare("INSERT INTO perfiles_usuario (Nombre_Perfil, Descripción_Perfil) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombrePerfil, $descripcionPerfil);
    
    if ($stmt->execute()) {
    $response = [
        'status' => 'success',
        'newProfileId' => $conn->insert_id,
        'nombre_perfil' => $nombrePerfil,
        'descripcion_perfil' => $descripcionPerfil,
    ];
    } else {
        $response = [
            'status' => 'error',
            'message' => $stmt->error,
        ];
    }

    // Asegúrate de establecer el tipo de contenido como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Fetch profiles from the database
$result = $conn->query("SELECT * FROM perfiles_usuario");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfiles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>

    <!-- Contenedor principal -->
    <div class="container-fluid">
        <!-- Fila que agrupa las dos secciones -->
        <div class="row">
            
            <!-- Sección para agregar un nuevo perfil (columna izquierda) -->
            <div class="col-12 col-xl-4">
                <div class="container">
                    <br>
                    <h3 class="mb-4">Agregar Nuevo Perfil</h3>
                    <form id="addProfileForm" action="perfiles.php" method="POST" class="p-3 border rounded">
                        <div class="form-group mb-3">
                            <label for="nombre_perfil" class="form-label">Nombre del Perfil:</label>
                            <input type="text" name="nombre_perfil" id="nombre_perfil" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="descripción_perfil" class="form-label">Descripción del Perfil:</label>
                            <input type="text" name="descripción_perfil" id="descripción_perfil" class="form-control" required>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary px-4">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sección para listar los perfiles (columna derecha) -->
            <div class="col-12 col-xl-8">
                <div class="table-section bg-white">
                    <h5>Listado de Perfiles</h5>
                    <!-- Agregamos table-responsive para hacer la tabla desplazable en pantallas pequeñas -->
                    <div class="table-responsive">
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
                                echo "<tr><td colspan='4'>No hay perfiles registrados</td></tr>";
                            }
                            ?>                            
                        </table>
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
    <script src="js/ajax_perfiles.js"></script>
    <script>
       


    function confirmDelete() {
        return confirm("¿Estás seguro de que deseas eliminar este perfil?");
    }
    </script>


</body>
</html>


<?php
$conn->close(); // Close the database connection
?>