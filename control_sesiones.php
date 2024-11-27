<?php 
include 'session_check.php'; 


// Query to fetch all sessions
$sql_sessions = "SELECT * FROM sesion_usuario";
$result_sessions = $conn->query($sql_sessions);

// Query to fetch all users (only the worker names)
$sql_users = "SELECT Nombre_Trabajador FROM usuario";
$result_users = $conn->query($sql_users);

$users = [];
if ($result_users->num_rows > 0) {
    while ($row = $result_users->fetch_assoc()) {
        $users[] = $row['Nombre_Trabajador']; // Add worker names to the array
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Sesiones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>

<!-- Contenido principal -->
<div class="container-fluid">
    <div class="row">
      <div class="col-12 col-xl-12">

            <div class="table-section bg-white p-3">
                <br>
                <h5>Listado de Sesiones</h5>
                <div class="table-responsive">
                <table id="listSessiones" class="display table table-striped">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>ID Usuario</th>
                        <th>Nombre del Trabajador</th>
                        <th>Estado</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                        </tr>
                    </thead>                            
                    <?php
                    if ($result_sessions->num_rows > 0) {
                        // Initialize a counter for user names
                        $userIndex = 0;
                        $userCount = count($users); // Get the total number of users

                        while ($row = $result_sessions->fetch_assoc()) {
                            // Get the worker name from the users array
                            $nombre_trabajador = $userCount > 0 ? $users[$userIndex % $userCount] : 'Sin Nombre'; // Use modulo to cycle through user names
                            echo "<tr>
                                    <td>{$row['ID_Sesion']}</td>
                                    <td>{$row['ID_Usuario']}</td> <!-- Display ID_Usuario from sesion_usuario -->
                                    <td>{$nombre_trabajador}</td> <!-- Display Nombre_Trabajador from usuario -->
                                    <td>{$row['Cod_Estado']}</td>
                                    <td>{$row['Fecha_Registro']}</td>
                                    <td>
                                        <a href='#' class='delete-session' data-id='{$row['ID_Sesion']}'>Eliminar Sesión</a>
                                    </td>
                                </tr>";
                            $userIndex++; // Increment index for the next session
                        }
                    } else {
                        echo "<tr><td>No hay sesiones registradas</td></tr>";
                    }
                    ?>                            
                </table>
                </div>
               
            </div> 
       </div>
    </div>

</div>


           
       


  
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="js/ajax_sesiones.js"></script>
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