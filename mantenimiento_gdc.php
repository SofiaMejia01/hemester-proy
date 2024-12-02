<?php
include 'session_check.php'; 
// Fetch the states as before
$states_result = [];
$states_query = "SELECT Nombre_Estado FROM estado_pp";
$states_result = $conn->query($states_query);

// Fetch GDC gems (GDC IGI) from the database
$query = "SELECT pp.*, e.Nombre_Estado AS Estado FROM piedras_preciosas pp JOIN estado_pp e ON pp.ID_Estado = e.ID_Estado WHERE pp.Cat_PP = 'GDC IGI'";
$result = mysqli_query($conn, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoria = 'GDC IGI'; 
    $tipo = $_POST['tipo']; 
    $tipo_certificado = $_POST['tipo_certificado'];
    $numero_certificado = $_POST['numero_certificado'];
    $forma = $_POST['forma'];
    $peso = $_POST['peso'];
    $dimensiones = $_POST['dimensiones'];
    $tratamiento = $_POST['tratamiento'];
    $calidad = $_POST['calidad'];
    $comentarios = $_POST['comentarios'];
    $ubicacion = $_POST['ubicacion'];
    $subtotal = $_POST['subtotal'];
    $total = $_POST['total'];
    $estado = $_POST['estado'];

    // Insert the new gem into the database
    $stmt = $conn->prepare("INSERT INTO piedras_preciosas (Cat_PP, Tipo_PP, Tipo_Certificado, N°_Certificado, Forma, Peso_CT, Dimensiones_MM, Tratamiento, Calidad, Comentarios, Ubicación, SubTotal_USD, Total_USD, ID_Estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, (SELECT ID_Estado FROM estado_pp WHERE Nombre_Estado = ?))");
    $stmt->bind_param("ssssssssssssss", $categoria, $tipo, $tipo_certificado, $numero_certificado, $forma, $peso, $dimensiones, $tratamiento, $calidad, $comentarios, $ubicacion, $subtotal, $total, $estado);

    if ($stmt->execute()) {
       // header("Location: admin_menu.php"); // Redirect to the GDC list page
       echo json_encode(['status' => 'success', 'message' => 'Se agrego exitosamente.']);
        exit();
    } else {
        echo "Error al agregar la gema: " . $stmt->error;
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento de gemas de color</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="css/menu.css">
   
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Formulario para agregar un nuevo certificado -->
        <div class="col-12 col-xl-4 mb-5">
                <div class="container">
                    <h3>Agregar Nueva Gema de Color</h3>
                    <form id="formMantenimientoGDC" action="mantenimiento_gdc.php" method="POST" class="p-3 border rounded">
                        <div class="form-group mb-3">
                            <label for="tipo" class="form-label">Tipo de Gema:</label>
                            <input type="text" name="tipo" id="tipo" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tipo_certificado" class="form-label">Tipo de Certificado:</label>
                            <input type="text" name="tipo_certificado" id="tipo_certificado" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="numero_certificado" class="form-label">N° Certificado:</label>
                            <input type="text" name="numero_certificado" id="numero_certificado" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="forma" class="form-label">Forma:</label>
                            <input type="text" name="forma" id="forma" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="peso" class="form-label">Peso (CT):</label>
                            <input type="text" name="peso" id="peso" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="dimensiones" class="form-label">Dimensiones (MM):</label>
                            <input type="text" name="dimensiones" id="dimensiones" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tratamiento" class="form-label">Tratamiento:</label>
                            <input type="text" name="tratamiento" id="tratamiento" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="calidad" class="form-label">Calidad:</label>
                            <input type="text" name="calidad" id="calidad" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="comentarios" class="form-label">Comentarios:</label>
                            <input type="text" name="comentarios" id="comentarios" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="ubicacion" class="form-label">Ubicación:</label>
                            <input type="text" name="ubicacion" id="ubicacion" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="subtotal" class="form-label">SubTotal_USD:</label>
                            <input type="text" name="subtotal" id="subtotal" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="total" class="form-label">Total_USD:</label>
                            <input type="text" name="total" id="total" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="estado" class="form-label">Estado:</label>
                            <select name="estado" id="estado" class="form-select" required>
                                <option value="">Seleccione un estado</option>
                                <?php
                                if ($states_result->num_rows > 0) {
                                    while ($row = $states_result->fetch_assoc()) {
                                        echo "<option value='" . htmlspecialchars($row['Nombre_Estado']) . "'>" . htmlspecialchars($row['Nombre_Estado']) . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Agregar Gema</button>
                    </form>
                </div>
        </div>
        
            <!-- DataTable Section -->
        <div class="col-12 col-xl-8 mb-5">
             <div class="table-section bg-white p-3">
                <h5>Lista de Gemas de Color</h5>
                
                    <div class="table-responsive">
                        <table id="gdcTable" class="display display table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Categoría</th>
                                    <th>Tipo de Certificado</th>
                                    <th>N° Certificado</th>
                                    <th>Gema</th>
                                    <th>Forma</th>
                                    <th>Peso (CT)</th>
                                    <th>Dimensiones_MM</th>
                                    <th>Tratamiento</th>
                                    <th>Calidad</th>
                                    <th>Comentarios</th>
                                    <th>Ubicación</th>
                                    <th>SubTotal_USD</th>
                                    <th>Total_USD</th>
                                    <th>Estado</th>                
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?php echo $row['ID_PP']; ?></td>
                                        <td><?php echo $row['Cat_PP']; ?></td>
                                        <td><?php echo $row['Tipo_Certificado']; ?></td>
                                        <td><?php echo $row['N°_Certificado']; ?></td>
                                        <td><?php echo $row['Tipo_PP']; ?></td>
                                        <td><?php echo $row['Forma']; ?></td>
                                        <td><?php echo $row['Peso_CT']; ?></td>
                                        <td><?php echo $row['Dimensiones_MM']; ?></td>
                                        <td><?php echo $row['Tratamiento']; ?></td>
                                        <td><?php echo $row['Calidad']; ?></td>
                                        <td><?php echo $row['Comentarios']; ?></td>
                                        <td><?php echo $row['Ubicación']; ?></td>
                                        <td><?php echo $row['SubTotal_USD']; ?></td>
                                        <td><?php echo $row['Total_USD']; ?></td>
                                        <td><?php echo $row['Estado']; ?></td>
                                        <td>
                                            <a href="modificar_gema.php?id=<?php echo $row['ID_PP']; ?>"  class="LoadModificarGDC">Modificar</a>
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
        
    
    
  
   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <script src="js/ajax_gdc.js"></script> 
    
    <script src="js/index.js"></script> 
    
          




</body>
</html>