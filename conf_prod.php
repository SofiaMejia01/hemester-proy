<?php
include 'session_check.php';

// Fetch clients from the cliente table for the combobox
$clients_result = $conn->query("SELECT ID_Cliente, Nombre_Cliente, Apellido_Cliente FROM cliente");

// Fetch precious stones from the piedras_preciosas table for the combobox
$piedras_result = $conn->query("SELECT ID_PP, Tipo_PP FROM piedras_preciosas");

// Fetch jewelry from the joya table for the combobox
$joyas_result = $conn->query("SELECT ID_Joya, Modelo_Joya FROM joya");

// Query to fetch data from agenda_confección with related names
$query = "SELECT 
        ac.ID_Pedido, 
        c.Nombre_Cliente AS Cliente, 
        pp.Tipo_PP AS Piedra_Preciosa, 
        j.Modelo_Joya AS Joya, 
        t.Nombre_Joya AS Tipo_Joya, 
        ac.Fecha_Compra_AC, 
        ac.Especificaciones_AC, 
        ac.Grabado_AC, 
        ac.Diseño3D_AC, 
        ac.Fecha_Entrega_Taller_AC, 
        ac.Fecha_Entrega_Cliente_AC, 
        ac.Precio_AC, 
        ac.A_Cuenta_AC,
        ac.Estado_Pedido,
        ac.Saldo_AC 
    FROM 
        agenda_confección ac
    JOIN 
        cliente c ON ac.ID_Cliente = c.ID_Cliente
    JOIN 
        piedras_preciosas pp ON ac.ID_PP = pp.ID_PP
    JOIN 
        joya j ON ac.ID_Joya = j.ID_Joya
    JOIN 
        tipo_joya t ON j.ID_TipoJoya = t.ID_TipoJoya;";

$result = $conn->query($query);



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $id_cliente = $_POST['id_cliente']; // This will be set from the combobox in the future
    $id_pp = $_POST['id_pp']; // This will be set from the combobox in the future
    $id_joya = $_POST['id_joya']; // This will be set from the combobox in the future
    $fecha_compra = $_POST['fecha_compra'];
    $especificaciones = $_POST['especificaciones'];
    $grabado = $_POST['grabado'];
    $diseño3d = $_POST['diseño3d'];
    $fecha_entrega_taller = $_POST['fecha_entrega_taller'];
    $fecha_entrega_cliente = $_POST['fecha_entrega_cliente'];
    $precio = $_POST['precio'];
    $a_cuenta = $_POST['a_cuenta'];
    $saldo = $_POST['saldo'];

    // Prepare the SQL statement to insert the new record
    $stmt = $conn->prepare("INSERT INTO agenda_confección (ID_Cliente, ID_PP, ID_Joya, Fecha_Compra_AC, Especificaciones_AC, Grabado_AC, Diseño3D_AC, Fecha_Entrega_Taller_AC, Fecha_Entrega_Cliente_AC, Precio_AC, A_Cuenta_AC, Saldo_AC) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Bind the parameters to the SQL query
    $stmt->bind_param("iiissssssddd", $id_cliente, $id_pp, $id_joya, $fecha_compra, $especificaciones, $grabado, $diseño3d, $fecha_entrega_taller, $fecha_entrega_cliente, $precio, $a_cuenta, $saldo);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        //header("Location: admin_menu.php"); // Redirect to the agenda list page
        echo json_encode(['status' => 'success', 'message' => 'Agregado exitosamente.']);
        exit();
    } else {
        echo "Error al agregar el pedido: " . $stmt->error; // Display error message if insertion fails
    }
    $stmt->close(); // Close the prepared statement
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valoracion de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>

<h1 class="text-center">Configuracion de Produccion</h1>
<div class="container-fluid">
    <div class="row">
        <!-- Formulario para agregar una nueva joya -->
        <div class="col-12 col-xl-4">
            <div class="container">
                <h5>Agregar Nuevo Item para la Agenda</h5>
                <form id="formAgregarConfProd" action="conf_prod.php" method="POST" class="p-3 border rounded">
                    <div class="form-group mb-3">
                        <label for="id_cliente">Cliente</label>
                        <select class="form-select" id="id_cliente" name="id_cliente" required>
                            <?php while ($row = $clients_result->fetch_assoc()): ?>
                                <option value="<?php echo $row['ID_Cliente']; ?>"><?php echo $row['Nombre_Cliente'] . ' ' . $row['Apellido_Cliente']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="id_pp">Piedra Preciosa</label>
                        <select class="form-select" id="id_pp" name="id_pp" required>
                            <?php while ($row = $piedras_result->fetch_assoc()): ?>
                                <option value="<?php echo $row['ID_PP']; ?>"><?php echo $row['Tipo_PP']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="id_joya">Joya</label>
                        <select class="form-select" id="id_joya" name="id_joya" required>
                            <?php while ($row = $joyas_result->fetch_assoc()): ?>
                                <option value="<?php echo $row['ID_Joya']; ?>"><?php echo $row['Modelo_Joya']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="fecha_compra">Fecha de Compra</label>
                        <input type="date" class="form-control" id="fecha_compra" name="fecha_compra" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="especificaciones">Especificaciones</label>
                        <textarea class="form-control" id="especificaciones" name="especificaciones" required></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="grabado">Grabado</label>
                        <input type="text" class="form-control" id="grabado" name="grabado" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="diseño3d">Diseño 3D</label>
                        <input type="text" class="form-control" id="diseño3d" name="diseño3d" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="fecha_entrega_taller">Fecha Entrega Taller</label>
                        <input type="date" class="form-control" id="fecha_entrega_taller" name="fecha_entrega_taller" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="fecha_entrega_cliente">Fecha Entrega Cliente</label>
                        <input type="date" class="form-control" id="fecha_entrega_cliente" name="fecha_entrega_cliente" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="precio">Precio</label>
                        <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="a_cuenta">A Cuenta</label>
                        <input type="number" step="0.01" class="form-control" id="a_cuenta" name="a_cuenta" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="saldo">Saldo</label>
                        <input type="number" step="0.01" class="form-control" id="saldo" name="saldo" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Item</button>
                </form>
            </div>
        </div>

        <!-- DataTable para listar las joyas -->
        <div class="col-12 col-xl-8">
           <div class="table-section bg-white p-3">
                <h5>Agenda de Confección</h5>
                <br>
                <div class="table-responsive">
                    <table id="joyaTable" class="display table table-striped">
                        <thead>
                            <tr>
                                <th>ID Pedido</th>
                                <th>Cliente</th>
                                <th>Piedra Preciosa</th>
                                <th>Tipo Joya</th>
                                <th>Modelo de Joya</th>                                
                                <th>Fecha Compra</th>
                                <th>Especificaciones</th>
                                <th>Grabado</th>
                                <th>Diseño 3D</th>
                                <th>Fecha Entrega Taller</th>
                                <th>Fecha Entrega Cliente</th>
                                <th>Precio</th>
                                <th>A Cuenta</th>
                                <th>Saldo</th>
                                <th>Estado Pedido</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['ID_Pedido']; ?></td>
                                    <td><?php echo $row['Cliente']; ?></td>
                                    <td><?php echo $row['Piedra_Preciosa']; ?></td>
                                    <td><?php echo $row['Tipo_Joya']; ?></td>
                                    <td><?php echo $row['Joya']; ?></td>                                    
                                    <td><?php echo $row['Fecha_Compra_AC']; ?></td>
                                    <td><?php echo $row['Especificaciones_AC']; ?></td>
                                    <td><?php echo $row['Grabado_AC']; ?></td>
                                    <td><?php echo $row['Diseño3D_AC']; ?></td>
                                    <td><?php echo $row['Fecha_Entrega_Taller_AC']; ?></td>
                                    <td><?php echo $row['Fecha_Entrega_Cliente_AC']; ?></td>
                                    <td><?php echo $row['Precio_AC']; ?></td>
                                    <td><?php echo $row['A_Cuenta_AC']; ?></td>
                                    <td><?php echo $row['Saldo_AC']; ?></td>
                                    <td><?php echo $row['Estado_Pedido']; ?></td>
                                    <td>
                                        <a href="completar_confeccion.php?id=<?php echo $row['ID_Pedido']; ?>" class="LoadCompletarPedido" onclick="return confirmCompletar();">Completar Pedido</a>
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
    <script src="js/ajax_conf_produccion.js"></script>
    <script>       
    function confirmCompletar() {
        return confirm("¿Confirmar el Pedido?");
    }
    </script>
          
</body>
</html>