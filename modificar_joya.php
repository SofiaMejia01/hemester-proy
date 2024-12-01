<?php
include 'session_check.php'; 

// Check if ID is provided
if (isset($_GET['id'])) {
    $id_joya = $_GET['id'];

    // Fetch the existing jewelry details
    $stmt = $conn->prepare("SELECT * FROM joya WHERE ID_Joya = ?");
    $stmt->bind_param("i", $id_joya);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $joya = $result->fetch_assoc();
    } else {
        echo "<script>alert('Joya no encontrada.'); window.location.href='gestion_productos.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID de joya no proporcionado.'); window.location.href='gestion_productos.php';</script>";
    exit();
}

// Handle form submission for updating the jewelry
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

    // Update the jewelry record
    $update_stmt = $conn->prepare("UPDATE joya SET ID_TipoJoya = ?, Modelo_Joya = ?, Metal_Joya = ?, PesoGr_Joya = ?, Talla_Joya = ?, Genero_Joya = ?, Comentario_Joya = ?, Ubicación_Joya = ?, SubTotalUSD_Joya = ?, TotalUSD_Joya = ?, Precio_Etiqueta_Joya = ? WHERE ID_Joya = ?");
    $update_stmt->bind_param("isssssssdddi", $id_tipo_joya, $modelo_joya, $metal_joya, $peso_gr_joya, $talla_joya, $genero_joya, $comentario_joya, $ubicacion_joya, $sub_total_usd_joya, $total_usd_joya, $precio_etiqueta_joya, $id_joya);

    if ($update_stmt->execute()) {
        echo "<script>alert('Joya modificada exitosamente.');</script>";
        echo json_encode(['status' => 'success', 'message' => 'Se modifico exitosamente.']);
        //header("Location: gestion_productos.php");
        exit();
    } else {
        echo "<script>alert('Error: " . $update_stmt->error . "');</script>";
    }
}

// Fetch types of jewelry for the dropdown
$tipo_joya_result = $conn->query("SELECT * FROM tipo_joya");

// Fetch existing records from the joya table
$result = $conn->query("SELECT j.*, t.Nombre_Joya FROM joya j JOIN tipo_joya t ON j.ID_TipoJoya = t.ID_TipoJoya");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Joya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>

<h1 class="text-center">Modificar Joya</h1>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-xl-4">
            <div class="container">
                <form id="formModificarJoya" action="modificar_joya.php?id=<?php echo $id_joya; ?>" method="POST" class="p-3 border rounded ">

                    <div class="mb-3">
                        <label for="id_tipo_joya" class="form-label">Tipo de Joya</label>
                        <select name="id_tipo_joya" id="id_tipo_joya" class="form-select" required>
                            <?php while ($tipo_joya = $tipo_joya_result->fetch_assoc()): ?>
                                <option value="<?php echo $tipo_joya['ID_TipoJoya']; ?>" <?php echo ($tipo_joya['ID_TipoJoya'] == $joya['ID_TipoJoya']) ? 'selected' : ''; ?>>
                                    <?php echo $tipo_joya['Nombre_Joya']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="modelo_joya" class="form-label">Modelo</label>
                        <input type="text" name="modelo_joya" id="modelo_joya" class="form-control" value="<?php echo $joya['Modelo_Joya']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="metal_joya" class="form-label">Metal</label>
                        <input type="text" name="metal_joya" id="metal_joya" class="form-control" value="<?php echo $joya['Metal_Joya']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="peso_gr_joya" class="form-label">Peso (g)</label>
                        <input type="number" name="peso_gr_joya" id="peso_gr_joya" class="form-control" value="<?php echo $joya['PesoGr_Joya']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="talla_joya" class="form-label">Talla</label>
                        <input type="text" name="talla_joya" id="talla_joya" class="form-control" value="<?php echo $joya['Talla_Joya']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="genero_joya" class="form-label">Género</label>
                        <input type="text" name="genero_joya" id="genero_joya" class="form-control" value="<?php echo $joya['Genero_Joya']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="comentario_joya" class="form-label">Comentario</label>
                        <textarea name="comentario_joya" id="comentario_joya" class="form-control" rows="3"><?php echo $joya['Comentario_Joya']; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="ubicacion_joya" class="form-label">Ubicación</label>
                        <input type="text" name="ubicacion_joya" id="ubicacion_joya" class="form-control" value="<?php echo $joya['Ubicación_Joya']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="sub_total_usd_joya" class="form-label">Subtotal (USD)</label>
                        <input type="number" step="0.01" name="sub_total_usd_joya" id="sub_total_usd_joya" class="form-control" value="<?php echo $joya['SubTotalUSD_Joya']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="total_usd_joya" class="form-label">Total (USD)</label>
                        <input type="number" step="0.01" name="total_usd_joya" id="total_usd_joya" class="form-control" value="<?php echo $joya['TotalUSD_Joya']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="precio_etiqueta_joya" class="form-label">Precio Etiqueta (USD)</label>
                        <input type="number" step="0.01" name="precio_etiqueta_joya" id="precio_etiqueta_joya" class="form-control" value="<?php echo $joya['Precio_Etiqueta_Joya']; ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Modificar Joya</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>  
    <script src="js/index.js"></script>
    <script src="js/ajax_modificar_joya.js"></script> 
    <script>       
    function confirmDelete() {
        return confirm("¿Estás seguro de que deseas eliminar esta joya?");
    }
    </script>
</body>
</html>