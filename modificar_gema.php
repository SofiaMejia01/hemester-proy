<?php
include 'session_check.php'; 


// Check if the 'id' parameter is provided


if (isset($_GET['id'])) {
    $id = $_GET['id'];

  


    if($id == null) {
        echo "Gema no encontrada.";
        exit();
    }

    $gem=[];
  

    // Fetch the gem details from the database based on ID
    $query = "SELECT pp.*, e.Nombre_Estado AS Estado FROM piedras_preciosas pp JOIN estado_pp e ON pp.ID_Estado = e.ID_Estado WHERE pp.ID_PP = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the gem exists
    if ($result->num_rows > 0) {
        $gem = $result->fetch_assoc();
    } else {
        echo "Gema no encontrada.";
        exit();
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // $categoria = 'GDC IGI'; 
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

    // Update the gem details in the database
    $stmt = $conn->prepare("UPDATE piedras_preciosas SET Tipo_PP = ?, Tipo_Certificado = ?, N°_Certificado = ?, Forma = ?, Peso_CT = ?, Dimensiones_MM = ?, Tratamiento = ?, Calidad = ?, Comentarios = ?, Ubicación = ?, SubTotal_USD = ?, Total_USD = ?, ID_Estado = (SELECT ID_Estado FROM estado_pp WHERE Nombre_Estado = ?) WHERE ID_PP = ?");
    $stmt->bind_param("sssssssssssssi", $tipo, $tipo_certificado, $numero_certificado, $forma, $peso, $dimensiones, $tratamiento, $calidad, $comentarios, $ubicacion, $subtotal, $total, $estado, $id);

    if ($stmt->execute()) {
        //header("Location: admin_menu.php"); // Redirect to the GDC list page
        echo json_encode(['status' => 'success', 'message' => 'Se modifico exitosamente.']);
        exit();
    } else {
        echo "Error al modificar la gema: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch the states as before
$states_result = [];
$states_query = "SELECT Nombre_Estado FROM estado_pp";
$states_result = $conn->query($states_query);

// Fetch GDC gems (GDC IGI) from the database
$query = "SELECT pp.*, e.Nombre_Estado AS Estado FROM piedras_preciosas pp JOIN estado_pp e ON pp.ID_Estado = e.ID_Estado WHERE pp.Cat_PP = 'GDC IGI'";
$result = mysqli_query($conn, $query);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Gema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
   
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>

   


   
<div class="container-fluid">
    <div class="row">
            <div class="col-12 col-xl-4">
                <div class="container">
                    <h3>Modificar Gema de Color</h3>
                    <form id="formModificarGDC" action="modificar_gema.php?id=<?php echo $id; ?>" method="POST" class="p-3 border rounded">
                        <div class="form-group mb-3">
                            <label for="tipo" class="form-label">Tipo de Gema:</label>
                            <input type="text" name="tipo" id="tipo" class="form-control" value="<?php echo htmlspecialchars($gem['Tipo_PP']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tipo_certificado" class="form-label">Tipo de Certificado:</label>
                            <input type="text" name="tipo_certificado" id="tipo_certificado" class="form-control" value="<?php echo htmlspecialchars($gem['Tipo_Certificado']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="numero_certificado" class="form-label">N° Certificado:</label>
                            <input type="text" name="numero_certificado" id="numero_certificado" class="form-control" value="<?php echo htmlspecialchars($gem['N°_Certificado']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="forma" class="form-label">Forma:</label>
                            <input type="text" name="forma" id="forma" class="form-control" value="<?php echo htmlspecialchars($gem['Forma']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="peso" class="form-label">Peso (CT):</label>
                            <input type="text" name="peso" id="peso" class="form-control" value="<?php echo htmlspecialchars($gem['Peso_CT']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="dimensiones" class="form-label">Dimensiones (MM):</label>
                            <input type="text" name="dimensiones" id="dimensiones" class="form-control" value="<?php echo htmlspecialchars($gem['Dimensiones_MM']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tratamiento" class="form-label">Tratamiento:</label>
                            <input type="text" name="tratamiento" id="tratamiento" class="form-control" value="<?php echo htmlspecialchars($gem['Tratamiento']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="calidad" class="form-label">Calidad:</label>
                            <input type="text" name="calidad" id="calidad" class="form-control" value="<?php echo htmlspecialchars($gem['Calidad']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="comentarios" class="form-label">Comentarios:</label>
                            <input type="text" name="comentarios" id="comentarios" class="form-control" value="<?php echo htmlspecialchars($gem['Comentarios']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="ubicacion" class="form-label">Ubicación:</label>
                            <input type="text" name="ubicacion" id="ubicacion" class="form-control" value="<?php echo htmlspecialchars($gem['Ubicación']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="subtotal" class="form-label">SubTotal_USD:</label>
                            <input type="text" name="subtotal" id="subtotal" class="form-control" value="<?php echo htmlspecialchars($gem['SubTotal_USD']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="total" class="form-label">Total_USD:</label>
                            <input type="text" name="total" id="total" class="form-control" value="<?php echo htmlspecialchars($gem['Total_USD']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="estado" class="form-label">Estado:</label>
                            <select name="estado" id="estado" class="form-select" required>
                                <option value="">Seleccione un estado</option>
                                <?php
                                if ($states_result->num_rows > 0) {
                                    while ($row = $states_result->fetch_assoc()) {
                                        $selected = $row['Nombre_Estado'] == $gem['Estado'] ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($row['Nombre_Estado']) . "' $selected>" . htmlspecialchars($row['Nombre_Estado']) . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Modificar Gema</button>
                    </form>
                </div>
            </div>

             <!-- DataTable Section -->
        <div class="col-12 col-xl-8">
            <div class="table-section bg-white p-3">
                <h5>Lista de Gemas de Color</h5>
                
                    <div class="table-responsive">
                       <table id="gdcTable" class="display display table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Categoría</th>
                                    <th>Gema</th>
                                    <th>Tipo de Certificado</th>
                                    <th>N° Certificado</th>
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
                                        <td><?php echo $row['Tipo_PP']; ?></td>
                                        <td><?php echo $row['Tipo_Certificado']; ?></td>
                                        <td><?php echo $row['N°_Certificado']; ?></td>
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
                                            <a href="modificar_gema.php?id=<?php echo $row['ID_PP']; ?>" class="LoadModificarGDC">Modificar</a>
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
    <script src="js/ajax_modificarGDC.js"></script>   
    
            
</body>
</html>
