<?php
include 'session_check.php'; 
 
$query = "SELECT pp.*, e.Nombre_Estado AS Estado FROM piedras_preciosas pp JOIN estado_pp e ON pp.ID_Estado = e.ID_Estado";
$result = mysqli_query($conn, $query);  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valoracion de Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>

    <h1 class="text-center">Gestion de Inventario</h1>

    <div class="container my-4">
        <div class="row">
            <div class="col text-start">
                <a href="admin_menu.php" class="btn btn-primary">Listado General</a>
            </div>
            <div class="col text-center">
                <a href="mantenimiento_diamantes.php" class="btn btn-secondary">Diamantes GIA</a>
            </div>
            <div class="col text-end">
                <a href="mantenimiento_gdc.php" class="btn btn-success">Gemas de Color</a>
            </div>
        </div>
    </div>
    <br>
    <hr>    
    <div class="container-fluid">
        <div class="row">           
            <!-- DataTable para listar las joyas -->
            <div class="col-12">
                <div class="table-section bg-white p-3">
                    <h5>Lista de Joyas</h5>
                    <br>
                    <div class="table-responsive">
                        <table id="ppTable" class="display table table-striped w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Categoría Piedra Preciosa</th>
                                    <th>Tipo de Piedra Preciosa</th>
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
                                    <th>Calidad</th>
                                    <th>Comentarios</th>
                                    <th>Ubicación</th>
                                    <th>Subtotal (USD)</th>
                                    <th>Total (USD)</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
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
                                        <td><?php echo $row['Calidad']; ?></td>
                                        <td><?php echo $row['Comentarios']; ?></td>
                                        <td><?php echo $row['Ubicación']; ?></td>
                                        <td><?php echo $row['SubTotal_USD']; ?></td>
                                        <td><?php echo $row['Total_USD']; ?></td>
                                        <td><?php echo $row['Estado']; ?></td>
                                        <td>
                                            <a href="eliminar_piedra.php?id=<?php echo $row['ID_PP']; ?>">Eliminar</a>
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
          




</body>
</html>