<?php 
include 'session_check.php'; 


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

            <main class="col-12 col-md-12">

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