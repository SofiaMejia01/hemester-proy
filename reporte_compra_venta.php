<?php
include 'session_check.php';

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Compra y Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="css/menu.css">
    
</head>
<body>
    <div class="container">
    <h1 class="text-center">Reporte de Compra y Venta</h1>
        <br>    
        <hr>
        <br>
        <div class="row">
            <div class="col-md-4">
                <div id="pieChart" style="height: 400px;"></div>
            </div>
            <div class="col-md-4">
                <div id="barChart" style="height: 400px;"></div>
            </div>
            <div class="col-md-4">
                <div id="lineChart" style="height: 400px;"></div>
            </div>
        </div>
    </div>


    <!-- <script src="https://code.highcharts.com/highcharts.js" ></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script> -->
    <!-- jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <!-- DataTables JS -->
    <!-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="js/index.js"></script>  -->
    <!-- Graficas -->
    <script src="js/charts.js" defer></script>
          
</body>
</html>