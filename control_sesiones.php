<?php include 'session_check.php'; 
$sql = "SELECT * FROM sesion_usuario" ;
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Sesiones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- DataTables CSS -->
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

                    <div class="table-section bg-white">
                        <h5>Listado de Sesiones</h5>
                        <table id="listSessiones" class="display table table-striped">
                            <thead>
                                <tr>
                                <th>ID</th>
                                <th>ID Usuario</th>
                                <th>Estado</th>
                                <th>Fecha de Registro</th>
                                <th>Acciones</th>
                                </tr>
                            </thead>                            
                            <?php
                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['ID_Sesion']}</td>
                                            <td>{$row['ID_Usuario']}</td>
                                            <td>{$row['Cod_Estado']}</td>
                                            <td>{$row['Fecha_Registro']}</td>
                                            <td>
                                                <a href='eliminar_sesion.php?id={$row['ID_Sesion']}' onclick='return confirmDelete();'>Eliminar Sesión</a>
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
    <script>
    function confirmDelete() {
        return confirm("¿Estás seguro de que deseas cerrar esta sesión?");
    }
    </script>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>