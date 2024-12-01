<?php
include 'session_check.php';

// Check if the diamond ID is provided in the URL
if (!isset($_GET['id'])) {
    echo "Error: ID no proporcionado.";
    exit();
}

// Get the diamond ID
$diamond_id = $_GET['id'];

// Fetch current diamond data
$query = "SELECT pp.*, e.Nombre_Estado AS Estado FROM piedras_preciosas pp 
          JOIN estado_pp e ON pp.ID_Estado = e.ID_Estado 
          WHERE pp.ID_PP = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $diamond_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Error: Diamante no encontrado.";
    exit();
}

// Fetch the data of the selected diamond
$diamante = $result->fetch_assoc();

// Fetch states
$states_result = [];
$states_query = "SELECT Nombre_Estado FROM estado_pp";
$states_result = $conn->query($states_query);



//Fetch all the rows in result set diamantes.
$query = "SELECT pp.*, e.Nombre_Estado AS Estado FROM piedras_preciosas pp JOIN estado_pp e ON pp.ID_Estado = e.ID_Estado WHERE pp.Cat_PP = 'Diamante GIA'";
$result = mysqli_query($conn, $query);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form inputs
    $tipo_certificado = $_POST['tipo_certificado'];
    $numero_certificado = $_POST['numero_certificado'];
    $forma = $_POST['forma'];
    $peso = $_POST['peso'];
    $dimensiones = $_POST['dimensiones'];
    $color = $_POST['color'];
    $claridad = $_POST['claridad'];
    $corte = $_POST['corte'];
    $pulido = $_POST['pulido'];
    $simetria = $_POST['simetria'];
    $fluorescencia = $_POST['fluorescencia'];
    $tratamiento = $_POST['tratamiento'];
    $comentarios = $_POST['comentarios'];
    $ubicacion = $_POST['ubicacion'];
    $subtotal = $_POST['subtotal'];
    $total = $_POST['total'];
    $estado = $_POST['estado'];

    // Prepare the SQL statement to update the diamond record
    $stmt = $conn->prepare("UPDATE piedras_preciosas SET 
                            Tipo_Certificado = ?, 
                            N°_Certificado = ?, 
                            Forma = ?, 
                            Peso_CT = ?, 
                            Dimensiones_MM = ?, 
                            Color = ?, 
                            Claridad = ?, 
                            Corte = ?, 
                            Pulido = ?, 
                            Simetría = ?, 
                            Fluorescencia = ?, 
                            Tratamiento = ?, 
                            Comentarios = ?, 
                            Ubicación = ?, 
                            SubTotal_USD = ?, 
                            Total_USD = ?, 
                            ID_Estado = (SELECT ID_Estado FROM estado_pp WHERE Nombre_Estado = ?)
                            WHERE ID_PP = ?");
    
    // Bind parameters
    $stmt->bind_param("ssssssssssssssssss", $tipo_certificado, $numero_certificado, $forma, $peso, $dimensiones, $color, $claridad, $corte, $pulido, $simetria, $fluorescencia, $tratamiento, $comentarios, $ubicacion, $subtotal, $total, $estado, $diamond_id);

    // Execute the statement
    if ($stmt->execute()) {
        //header("Location: admin_menu.php"); // Redirect to the diamonds list page
        echo json_encode(['status' => 'success', 'message' => 'Se modifico exitosamente.']);
        exit();
    } else {
        echo "Error al modificar el diamante: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Diamante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>
 
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-xl-4">
                <div class="container">
                    <h3>Modificar Diamante</h3>
                    <form id="formModificarDiamante" action="modificar_diamante.php?id=<?php echo $diamond_id; ?>" method="POST" class="p-3 border rounded">
                        <div class="form-group mb-3">
                            <label for="tipo_certificado" class="form-label">Tipo de Certificado:</label>
                            <input type="text" name="tipo_certificado" id="tipo_certificado" class="form-control" value="<?php echo htmlspecialchars($diamante['Tipo_Certificado']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="numero_certificado" class="form-label">N° Certificado:</label>
                            <input type="text" name="numero_certificado" id="numero_certificado" class="form-control" value="<?php echo htmlspecialchars($diamante['N°_Certificado']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="forma" class="form-label">Forma:</label>
                            <input type="text" name="forma" id="forma" class="form-control" value="<?php echo htmlspecialchars($diamante['Forma']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="peso" class="form-label">Peso (CT):</label>
                            <input type="text" name="peso" id="peso" class="form-control" value="<?php echo htmlspecialchars($diamante['Peso_CT']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="dimensiones" class="form-label">Dimensiones (MM):</label>
                            <input type="text" name="dimensiones" id="dimensiones" class="form-control" value="<?php echo htmlspecialchars($diamante['Dimensiones_MM']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="color" class="form-label">Color:</label>
                            <input type="text" name="color" id="color" class="form-control" value="<?php echo htmlspecialchars($diamante['Color']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="claridad" class="form-label">Claridad:</label>
                            <input type="text" name="claridad" id="claridad" class="form-control" value="<?php echo htmlspecialchars($diamante['Claridad']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="corte" class="form-label">Corte:</label>
                            <input type="text" name="corte" id="corte" class="form-control" value="<?php echo htmlspecialchars($diamante['Corte']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="pulido" class="form-label">Pulido:</label>
                            <input type="text" name="pulido" id="pulido" class="form-control" value="<?php echo htmlspecialchars($diamante['Pulido']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="simetria" class="form-label">Simetría:</label>
                            <input type="text" name="simetria" id="simetria" class="form-control" value="<?php echo htmlspecialchars($diamante['Simetría']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="fluorescencia" class="form-label">Fluorescencia:</label>
                            <input type="text" name="fluorescencia" id="fluorescencia" class="form-control" value="<?php echo htmlspecialchars($diamante['Fluorescencia']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tratamiento" class="form-label">Tratamiento:</label>
                            <input type="text" name="tratamiento" id="tratamiento" class="form-control" value="<?php echo htmlspecialchars($diamante['Tratamiento']); ?>" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="comentarios" class="form-label">Comentarios:</label>
                            <input type="text" name="comentarios" id="comentarios" class="form-control" value="<?php echo htmlspecialchars($diamante['Comentarios']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="ubicacion" class="form-label">Ubicación:</label>
                            <input type="text" name="ubicacion" id="ubicacion" class="form-control" value="<?php echo htmlspecialchars($diamante['Ubicación']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="subtotal" class="form-label">SubTotal_USD:</label>
                            <input type="text" name="subtotal" id="subtotal" class="form-control" value="<?php echo htmlspecialchars($diamante['SubTotal_USD']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="total" class="form-label">Total_USD:</label>
                            <input type="text" name="total" id="total" class="form-control" value="<?php echo htmlspecialchars($diamante['Total_USD']); ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="estado" class="form-label">Estado:</label>
                            <select name="estado" id="estado" class="form-select" required>
                                <option value="">Seleccione un estado</option>
                                <?php
                                $states_query = "SELECT Nombre_Estado FROM estado_pp";
                                $states_result = $conn->query($states_query);

                                if ($states_result->num_rows > 0) {
                                    while ($row = $states_result->fetch_assoc()) {
                                        // Marca como seleccionado el estado actual
                                        $selected = ($diamante['ID_Estado'] == $row['Nombre_Estado']) ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($row['Nombre_Estado']) . "' $selected>" . htmlspecialchars($row['Nombre_Estado']) . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Modificar Diamante</button>
                    </form>
                </div>
            </div>
            <!-- DataTable Section -->
            <div class="col-12 col-xl-8">
                <div class="table-section bg-white p-3">
                <h5>Lista de Diamantes</h5>
                <br>
                    <div class="table-responsive">
                        <table id="diamantesTable" class="display display table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Categoría</th>
                                    <th>Tipo</th>
                                    <th>Tipo de Certificado</th>
                                    <th>N° Certificado</th>
                                    <th>Forma</th>
                                    <th>Peso (CT)</th>
                                    <th>Dimensiones (MM)</th>
                                    <th>Color</th>
                                    <th>Claridad</th>
                                    <th>Corte</th>
                                    <th>Pulido</th>
                                    <th>Simetría</th>
                                    <th>Fluorescencia</th>
                                    <th>Tratamiento</th>
                                    <th>Comentarios</th>
                                    <th>Ubicación</th>
                                    <th>SubTotal (USD)</th>
                                    <th>Total (USD)</th>
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
                                        <td><?php echo $row['Color']; ?></td>
                                        <td><?php echo $row['Claridad']; ?></td>
                                        <td><?php echo $row['Corte']; ?></td>
                                        <td><?php echo $row['Pulido']; ?></td>
                                        <td><?php echo $row['Simetría']; ?></td>
                                        <td><?php echo $row['Fluorescencia']; ?></td>
                                        <td><?php echo $row['Tratamiento']; ?></td>
                                        <td><?php echo $row['Comentarios']; ?></td>
                                        <td><?php echo $row['Ubicación']; ?></td>
                                        <td><?php echo $row['SubTotal_USD']; ?></td>
                                        <td><?php echo $row['Total_USD']; ?></td>
                                        <td><?php echo $row['Estado']; ?></td>
                                        <td>
                                            <a href="modificar_diamante.php?id=<?php echo $row['ID_PP']; ?>" class="LoadModificarDiamante">Modificar</a>
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
    <script src="js/ajax_modificar_diamante.js"></script> 
</body>
</html>
