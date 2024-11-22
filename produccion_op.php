<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operador Producción</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/navegacion.css">
</head>

<body>
    <!-- Barra de arriba -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary px-3 navbar-divider">
            <div class="container-fluid">
                <!-- Logo -->
                <a href="operador_menu.php">
                    <img src="img/logoHemenster.png" alt="Logo o Imagen" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                </a>

                <!-- Espacio flexible -->
                <div class="d-flex ms-auto align-items-center">
                    <!-- Texto "Hola, usuario" -->
                    <span class="navbar-text text-light me-3" style="font-size: 24px;">
                        Hola, <?php echo htmlspecialchars($nombreTrabajador); ?>
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
                        <a class="nav-link text-light" href="proc_preparacion_op.php">Proceso de Preparación</a>
                    </li>
                   
                </ul>
            </nav>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="js/index.js"></script>
</body>
</html>