
$(document).ready(function() {
         
    // Mostrar el spinner y ocultar el contenido
 
   // $("#contentArea2").hide()
 loadPage('gestion_inventario.php');



 $('#loadGestionInventario').click(function() {
         loadPage('gestion_inventario.php');
     
 });

 $('#loadGestionDiamante').click(function() {
    loadPage('mantenimiento_diamantes.php');

});

$('#loadGemasColor').click(function() {
    loadPage('mantenimiento_gdc.php');

});

$('#contentArea2').on('click', '.LoadModificarDiamante', function(e) {
    e.preventDefault(); // Evitar el comportamiento predeterminado del enlace

    var href = $(this).attr('href');
    $('#contentArea2').empty();
    loadPage(href); // Cargar la página usando AJAX
    
});

$('#contentArea2').on('click', '.LoadModificarGDC', function(e) {
    e.preventDefault(); // Evitar el comportamiento predeterminado del enlace
    var href = $(this).attr('href');
    $('#contentArea2').empty();
    loadPage(href); // Cargar la página usando AJAX
    
});



 




 // Función para cargar contenido mediante AJAX
 function loadPage(page) {
     $.ajax({
         url: page,
         type: 'GET',
         success: function(response) {
            // Cargar el contenido en el área de contenido
            $('#contentArea2').html(response).show();    
          },error: function () {
            // Manejar errores, ocultar el spinner
          
            $("#contentArea2").html("<p>Error al cargar el contenido.</p>").show();
         }
         });
   
     };


     });
    

    