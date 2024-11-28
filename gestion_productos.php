<?php
include 'session_check.php'; 

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tipo_joya = $_POST['id_tipo_joya'];
    $modelo_joya = $_POST['modelo_joya'];
    $metal_joya = $_POST['metal_joya'];
    $peso_gr_joya = $_POST['peso_gr_joya'];
    $talla_joya = $_POST['talla_joya'];
    $genero_joya = $_POST['genero_joya'];
    $comentario_joya = $_POST['comentario_joya'];
    $ubicacion_joya = $_POST['ubicacion_joya'];
    $sub_total_usd_joya = $_POST['sub_total_usd_joya'];
    $total_usd_joya = $_POST['total_usd_joya'];
    $precio_etiqueta_joya = $_POST['precio_etiqueta_joya'];

    // Insert new record into the joya table
    $insert_stmt = $conn->prepare("INSERT INTO joya (ID_TipoJoya, Modelo_Joya, Metal_Joya, PesoGr_Joya, Talla_Joya, Genero_Joya, Comentario_Joya, Ubicación_Joya, SubTotalUSD_Joya, TotalUSD_Joya, Precio_Etiqueta_Joya) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_stmt->bind_param("isssssssddd", $id_tipo_joya, $modelo_joya, $metal_joya, $peso_gr_joya, $talla_joya, $genero_joya, $comentario_joya, $ubicacion_joya, $sub_total_usd_joya, $total_usd_joya, $precio_etiqueta_joya);

    if ($insert_stmt->execute()) {
        // Optionally, you can prepare a success message
        echo "<script>alert('Joya agregada exitosamente.');</script>";
        header("Location: admin_menu.php");
        exit();
    } else {
        echo "<script>alert('Error: " . $insert_stmt->error . "');</script>";
    }
}

// Fetch existing records from the joya table
$result = $conn->query("SELECT j.*, t.Nombre_Joya FROM joya j JOIN tipo_joya t ON j.ID_TipoJoya = t.ID_TipoJoya");

// Fetch types of jewelry for the dropdown
$tipo_joya_result = $conn->query("SELECT * FROM tipo_joya");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menu</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/navegacion.css">
</head>
<body>

<h1 class="text-center">Gestion de Productos</h1>
<div class="container-fluid">
    <div class="row">
        <!-- Formulario para agregar una nueva joya -->
        <div class="col-12 col-xl-4">
            <div class="container">
                <h3>Agregar Nueva Joya</h3>
                <form action="gestion_productos.php" method="POST" class="p-3 border rounded">
                    <div class="form-group mb-3">
                        <label for="id_tipo_joya">Tipo de Joya</label>
                        <select class="form-select" id="id_tipo_joya" name="id_tipo_joya" required>
                            <?php while ($row = $tipo_joya_result->fetch_assoc()): ?>
                                <option value="<?php echo $row['ID_TipoJoya']; ?>"><?php echo $row['Nombre_Joya']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="modelo_joya">Modelo de Joya</label>
                        <input type="text" class="form-control" id="modelo_joya" name="modelo_joya" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="metal_joya">Metal de Joya</label>
                        <input type="text" class="form-control" id="metal_joya" name="metal_joya" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="peso_gr_joya">Peso (g)</label>
                        <input type="number" step="0.01" class="form-control" id="peso_gr_joya" name="peso_gr_joya" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="talla_joya">Talla de Joya</label>
                        <input type="text" class="form-control" id="talla_joya" name="talla_joya" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="genero_joya">Género</label>
                        <input type="text" class="form-control" id="genero_joya" name="genero_joya" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="comentario_joya">Comentario</label>
                        <textarea class="form-control" id="comentario_joya" name="comentario_joya" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="ubicacion_joya">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion_joya" name="ubicacion_joya" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="sub_total_usd_joya">Subtotal (USD)</label>
                        <input type="number" step="0.01" class="form-control" id="sub_total_usd_joya" name="sub_total_usd_joya" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="total_usd_joya">Total (USD)</label>
                        <input type="number" step="0.01" class="form-control" id="total_usd_joya" name="total_usd_joya" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="precio_etiqueta_joya">Precio Etiqueta (USD)</label>
                        <input type="number" step="0.01" class="form-control" id="precio_etiqueta_joya" name="precio_etiqueta_joya" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Joya</button>
                </form>
            </div>
        </div>

        <!-- DataTable para listar las joyas -->
        <div class="col-12 col-xl-8">
           <div class="table-section bg-white p-3">
                <h5>Lista de Joyas</h5>
                <br>
                <div class="table-responsive">
                    <table id="joyaTable" class="display table table-striped">
                        <thead>
                            <tr>
                                <th>ID Joya</th>
                                <th>Tipo Joya</th>
                                <th>Modelo</th>
                                <th>Metal</th>
                                <th>Peso (g)</th>
                                <th>Talla</th>
                                <th>Género</th>
                                <th>Comentario</th>
                                <th>Ubicación</th>
                                <th>Subtotal (USD)</th>
                                <th>Total (USD)</th>
                                <th>Precio Etiqueta (USD)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['ID_Joya']; ?></td>
                                    <td><?php echo $row['Nombre_Joya']; ?></td>
                                    <td><?php echo $row['Modelo_Joya']; ?></td>
                                    <td><?php echo $row['Metal_Joya']; ?></td>
                                    <td><?php echo $row['PesoGr_Joya']; ?></td>
                                    <td><?php echo $row['Talla_Joya']; ?></td>
                                    <td><?php echo $row['Genero_Joya']; ?></td>
                                    <td><?php echo $row['Comentario_Joya']; ?></td>
                                    <td><?php echo $row['Ubicación_Joya']; ?></td>
                                    <td><?php echo $row['SubTotalUSD_Joya']; ?></td>
                                    <td><?php echo $row['TotalUSD_Joya']; ?></td>
                                    <td><?php echo $row['Precio_Etiqueta_Joya']; ?></td>
                                    <td>
                                        <a href="modificar_joya.php?id=<?php echo $row['ID_Joya']; ?>" class="LoadModificarJoya">Modificar</a> | 
                                        <a href="eliminar_joya.php?id=<?php echo $row['ID_Joya']; ?>" class="LoadEliminarJoya" onclick="return confirmDelete();">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
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
    <script src="js/index.js"></script>
    <script>       
    function confirmDelete() {
        return confirm("¿Estás seguro de que deseas eliminar este perfil?");
    }
    </script>

</body>
</html>