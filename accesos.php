<?php

 include 'session_check.php'; ?>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery for AJAX -->
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
                Hola, <?php echo htmlspecialchars($nombreTrabajador); ?>
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
        <nav class="col-12 col-md-2 bg-primary text-light collapse d-md-block" id="sidebarMenu">
            <ul class="nav flex-column">
                <li class="nav-item sidebar-item">
                    <a class="nav-link text-light" href="#" id="loadUsers">Gestión de Usuarios</a>
                </li>
                <li class="nav-item sidebar-item">
                    <a class="nav-link text-light" href="#" id="loadProfiles">Perfiles</a>
                </li>
                <li class="nav-item sidebar-item">
                    <a class="nav-link text-light" href="#" id="loadSessions">Control de Sesiones</a>
                </li>
            </ul>
        </nav>

        <!-- Contenedor para el contenido principal que se cargará dinámicamente -->
        <div id="contentArea" class="col-12 col-md-10">
            <!-- El contenido cargado por AJAX aparecerá aquí -->
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Cargar la página de "Gestión de Usuarios" por defecto cuando se cargue la página
         $('#loadUsers').click(function() {
             loadPage('mantenimiento_usuarios.php');
         });
        loadPage('mantenimiento_usuarios.php');


        // Función para cargar contenido mediante AJAX
        function loadPage(page) {
            $.ajax({
                url: page,
                type: 'GET',
                success: function(response) {
                    $('#contentArea').html(response); // Cargar el contenido en el área de contenido
                }
            });
        }

        // Opciones del menú
        $('#loadProfiles').click(function() {
            loadPage('perfiles.php');
        });

        $('#loadSessions').click(function() {
            loadPage('control_sesiones.php');
        });

         // Delegación de eventos para enlaces cargados dinámicamente, para modificar*
         $('#contentArea').on('click', '.LoadModificarUsuario', function(e) {
        e.preventDefault(); // Evitar el comportamiento predeterminado del enlace
        var href = $(this).attr('href'); // Obtener la URL del enlace
        loadPage(href); // Cargar la página usando AJAX
        });

        // Delegación de eventos para enlaces cargados dinámicamente, para modificar*
        $('#contentArea').on('click', '.LoadModificarPerfil', function(e) {
        e.preventDefault(); // Evitar el comportamiento predeterminado del enlace
        var href = $(this).attr('href'); // Obtener la URL del enlace
        loadPage(href); // Cargar la página usando AJAX
        });
    });
</script>

</body>
</html>

