<?php
include 'session_check.php'; 
 

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
                <a href="#gestion_inventario" class="btn btn-primary" id="loadGestionInventario">Listado General</a>
            </div>
            <div class="col text-center">
                <a href="#gestion_diamantes" class="btn btn-secondary" id="loadGestionDiamante">Diamantes GIA</a>
            </div>
            <div class="col text-end">
                <a href="#gemas_color" class="btn btn-success" id="loadGemasColor">Gemas de Color</a>
            </div>
        </div>
    </div>

    <br>
    <hr> 

    <!-- Layout general -->
    <div class="container-fluid">
            <div class="row vh-mobil-100">


   
                <!-- Contenedor para el contenido principal que se cargará dinámicamente -->
                <div id="contentArea2" class="col-12 col-md-12 col-lg-12">
                    <!-- El contenido cargado por AJAX aparecerá aquí -->

        
                </div>
           </div>
    </div>
  
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="js/ajax_botones_inventario.js"></script>      
    <script src="js/index.js"></script> 
          




</body>
</html>