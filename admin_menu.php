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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/navegacion.css">
</head>

<body class="" style="padding-top: 65px;">
<!-- Barra de arriba -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary px-3 fixed-top">
    <div class="container-fluid">
        <button class="navbar-toggler d-block me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenuAccesos" aria-controls="sidebarMenuAccesos" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Logo -->
        <a href="admin_menu.php">
            <img src="img/logoHemenster.png" alt="Logo" style="width: 50px; height: 50px; object-fit: cover;">
        </a>

        <!-- Texto "Hola, usuario" y botón "Cerrar Sesión" -->
        <div class="d-flex align-items-center ms-auto">
            <span class="navbar-text text-light me-3" style="font-size: 16px;">
                Hola, <?php echo htmlspecialchars($nombreTrabajador); ?>
            </span>
            <form action="cerrar_sesion.php" method="POST" class="d-none d-sm-inline-block me-2">
                <button type="submit" class="btn btn-danger btn-sm">Cerrar Sesión</button>
            </form>
        </div>
    </div>
</nav>

<!-- Offcanvas Barra lateral (sin título) -->
<div class="offcanvas offcanvas-start bg-primary text-light" tabindex="-1" id="sidebarMenuAccesos" aria-labelledby="sidebarMenuAccesosLabel">
    <div class="offcanvas-header">
        <!-- Título del Offcanvas -->
        <h5 class="offcanvas-title text-light ms-3" id="sidebarMenuAccesosLabel">Menú Principal</h5>
        <!-- Botón de "X" para cerrar (color claro) -->
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>  
    </div>
    <hr>
    <div class="offcanvas-body">
        <ul class="nav flex-column">
             <!-- ----------Módulo 1: Almacen ------------->
             <li class="nav-item">
                    <a class="nav-link text-light" data-bs-toggle="collapse" href="#almacenSubMenu" role="button" aria-expanded="false" aria-controls="accesosSubMenu">
                        Almacen
                        <i class="fa-solid fa-chevron-down fa-xs"></i>
                    </a>
                    <div class="collapse" id="almacenSubMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#gestion_producto" id="loadProductos">Gestión de Productos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#gestion_inventario" id="loadInventarios">Gestión de Inventarios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#valoración_producto" id="loadValoracionProd">Valoración de Productos</a>
                            </li>
                        </ul>
                    </div>
                </li>
        
                <!-- ----------Módulo 2: Producción ------------->
                <li class="nav-item">
                    <a class="nav-link text-light" data-bs-toggle="collapse" href="#produccionSubMenu" role="button" aria-expanded="false" aria-controls="accesosSubMenu">
                        Producción
                        <i class="fa-solid fa-chevron-down fa-xs"></i>
                    </a>
                    <div class="collapse" id="produccionSubMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#configuracion_produccion" id="loadConfiProd">Configuración Producción</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#proceso_de_preparacion" id="loadProcPrep">Proceso de Preparación</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>

             <!-- ----------Módulo 3: Generacion de documentos ------------->
                <li class="nav-item">
                    <a class="nav-link text-light" data-bs-toggle="collapse" href="#documentosSubMenu" role="button" aria-expanded="false" aria-controls="accesosSubMenu">
                        Generación de Documentos
                        <i class="fa-solid fa-chevron-down fa-xs"></i>
                    </a>
                    <div class="collapse" id="documentosSubMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#contratos" id="loadContratos">Contratos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#certificados" id="loadCertificados">Certificados</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>

                <!-- ----------Módulo 4: Accesos ------------->
                <li class="nav-item">
                    <a class="nav-link text-light" data-bs-toggle="collapse" href="#accesosSubMenu" role="button" aria-expanded="false" aria-controls="accesosSubMenu">
                        Accesos
                        <i class="fa-solid fa-chevron-down fa-xs"></i>
                    </a>
                    <div class="collapse" id="accesosSubMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#mantenimiento_usuarios" id="loadUsers">Gestión de Usuarios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#perfiles" id="loadProfiles">Perfiles</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#control_sesiones" id="loadSessions">Control de Sesiones</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>

                <!-- ----------Módulo 4: Reportes ------------->
                <li class="nav-item">
                    <a class="nav-link text-light" data-bs-toggle="collapse" href="#reporteSubMenu" role="button" aria-expanded="false" aria-controls="accesosSubMenu">
                        Reportes
                        <i class="fa-solid fa-chevron-down fa-xs"></i>
                    </a>
                    <div class="collapse" id="reporteSubMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#kardex" id="loadKardex">Kardex</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#reporte_compra_venta" id="loadReporteCompraVenta">Reporte de Compras y Ventas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#reporte_valoracion_prod" id="loadReporteValProd">Reporte de Valoración de Productos</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>


            <li class="nav-item">
                <a class="nav-link text-light" href="#menu_principal" id="loadMenuPrincipal">Regresar al Menú Principal</a>
            </li>
            <li>
                <form action="cerrar_sesion.php" method="POST" class="d-inline-block d-sm-none my-2 me-2">
                    <button type="submit" class="btn btn-danger btn-sm">Cerrar Sesión</button>
                </form>
            </li>
        </ul>
    </div>
</div>
 




<!-- Layout general -->
<div class="container-fluid">
    <div class="row vh-mobil-100">

        <div id="spinner" class="text-center" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
         </div>
        

        <!-- Contenedor para el contenido principal que se cargará dinámicamente -->
        <div id="contentArea" class="col-12 col-md-12 col-lg-12">
            <!-- El contenido cargado por AJAX aparecerá aquí -->

        
        </div>
    </div>
</div>

<footer class="py-2 bg-dark color-footer mt-auto">
    <div class="container-fluid px-4 mb-1">
        <div class="d-flex align-items-center justify-content-center small text-center">
            <div class="mx-2">&copy 2024 Hemester S.A.C.  Todos los derechos reservados  | ERP Versión 1.0 |</div>
            <div><a class="mx-2 color-footer" href="#">Política de Privacidad</a></div>
            <div><a class="mx-1 color-footer" href="#">Términos &amp; Condiciones</a></div> 
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="js/index.js"></script>
<script src="js/ajax_cargar_modulos.js"></script>


<!-- Funcion para que el navbar se cierre al darle click a un modulo -->
<!-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Selecciona el offcanvas por su ID
        const offcanvasElement = document.getElementById('sidebarMenuAccesos');
        const offcanvasInstance = bootstrap.Offcanvas.getOrCreateInstance(offcanvasElement);

        // Selecciona todos los enlaces dentro del offcanvas
        const links = document.querySelectorAll('#sidebarMenuAccesos .nav-link');

        // Agrega un evento "click" a cada enlace
        links.forEach(link => {
            link.addEventListener('click', () => {
                offcanvasInstance.hide(); // Cierra el offcanvas
            });
        });
    });
</script> -->

</body>
</html>

