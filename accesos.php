
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menu</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/navegacion.css">
</head>

<body>
<!-- Barra de arriba -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary px-3">
    <div class="container-fluid">
        <!-- Logo -->
        <a href="admin_menu.php">
            <img src="img/logoHemenster.png" alt="Logo" style="width: 50px; height: 50px; object-fit: cover;">
        </a>

        <!-- Texto "Hola, usuario" y botón "Cerrar Sesión" -->
        <div class="d-flex align-items-center ms-auto">
            <span class="navbar-text text-light me-3" style="font-size: 16px;">
                Hola, <?php echo htmlspecialchars($nombreUsuario); ?>
            </span>
            <form action="cerrar_sesion.php" method="POST" class="d-inline-block me-2">
                <button type="submit" class="btn btn-danger btn-sm">Cerrar Sesión</button>
            </form>

            <!-- Botón hamburguesa (siempre visible en modo móvil) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</nav>

<!-- Layout general -->
<div class="container-fluid">
    <div class="row vh-100">
        <!-- Barra lateral -->
        <nav class="col-12 col-md-2 bg-primary text-light  collapse d-md-block" id="sidebarMenu">
            <ul class="nav flex-column">
                <li class="nav-item sidebar-item">
                    <a class="nav-link text-light" href="mantenimiento_usuarios.php">Gestión de Usuarios</a>
                </li>
                <li class="nav-item sidebar-item">
                    <a class="nav-link text-light" href="perfiles.php">Perfiles</a>
                </li>
                <li class="nav-item sidebar-item">
                    <a class="nav-link text-light" href="control_sesiones.php">Control de Sesiones</a>
                </li>
               
            </ul>
        </nav>


     

    
    

     <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  

</body>
</html>