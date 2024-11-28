
 $(document).ready(function() {
         
           // Mostrar el spinner y ocultar el contenido
           $("#spinner").show();
           $("#contentArea").hide()
        loadPage('menu_principal.php');



        /*------------Cargar el modulo de Almacen-------------------*/ 
        $('#loadProductos').click(function() {
                loadPage('gestion_productos.php');

                // Mostrar el spinner y ocultar el contenido
             $("#spinner").show();
             $("#contentArea").hide()
        });
    
         $('#loadInventarios').click(function() {
                loadPage('gestion_inventario.php');

                // Mostrar el spinner y ocultar el contenido
             $("#spinner").show();
             $("#contentArea").hide()
        });
    
        $('#loadValoracionProd').click(function() {
                loadPage('valoracion_prod.php');

                // Mostrar el spinner y ocultar el contenido
             $("#spinner").show();
             $("#contentArea").hide()
        });
        

        /*------------Cargar el modulo de Producción-------------------*/ 
        $('#loadConfiProd').click(function() {
                loadPage('conf_prod.php');

                // Mostrar el spinner y ocultar el contenido
             $("#spinner").show();
             $("#contentArea").hide()
        });
        
         $('#loadProcPrep').click(function() {
                loadPage('proc_preparacion.php');

                // Mostrar el spinner y ocultar el contenido
             $("#spinner").show();
             $("#contentArea").hide()
        });


          /*------------Cargar el modulo de Generacion de Documentos-------------------*/ 
          $('#loadContratos').click(function() {
            loadPage('contratos.php');

            // Mostrar el spinner y ocultar el contenido
            $("#spinner").show();
            $("#contentArea").hide()
             });
    
            $('#loadCertificados').click(function() {
            loadPage('certificados.php');

            // Mostrar el spinner y ocultar el contenido
            $("#spinner").show();
            $("#contentArea").hide()
          });
        
    

  /*------------Cargar el modulo de Accesos-------------------*/
  $("#loadUsers").click(function () {
    loadPage("mantenimiento_usuarios.php");

    // Mostrar el spinner y ocultar el contenido
    $("#spinner").show();
    $("#contentArea").hide();
  });

        $('#loadProfiles').click(function() {
            loadPage('perfiles.php');

            // Mostrar el spinner y ocultar el contenido
            $("#spinner").show();
            $("#contentArea").hide()
        });

        $('#loadSessions').click(function() {
            loadPage('control_sesiones.php');

            // Mostrar el spinner y ocultar el contenido
            $("#spinner").show();
            $("#contentArea").hide()
        });
        

        /*------------Cargar el modulo de Reportes-------------------*/ 
        $('#loadKardex').click(function() {
            loadPage('kardex.php');

            // Mostrar el spinner y ocultar el contenido
            $("#spinner").show();
            $("#contentArea").hide()
        });

        $('#loadReporteCompraVenta').click(function() {
            loadPage('reporte_compra_venta.php');

            // Mostrar el spinner y ocultar el contenido
            $("#spinner").show();
            $("#contentArea").hide()
        });

        $('#loadReporteValProd').click(function() {
            loadPage('reporte_valoracion_producto.php');

            // Mostrar el spinner y ocultar el contenido
            $("#spinner").show();
            $("#contentArea").hide()
        });

          /*------------Cargar  la Pagina Principal-------------------*/ 
          $('#loadMenuPrincipal').click(function() {
            loadPage('menu_principal.php');

            // Mostrar el spinner y ocultar el contenido
            $("#spinner").show();
            $("#contentArea").hide()
        });





        
        // Delegación de eventos para enlaces cargados dinámicamente
        $('#contentArea').on('click', '.LoadModificarUsuario', function(e) {
            e.preventDefault(); // Evitar el comportamiento predeterminado del enlace
            var href = $(this).attr('href'); // Obtener la URL del enlace
            loadPage(href); // Cargar la página usando AJAX
        });

        $('#contentArea').on('click', '.LoadModificarPerfil', function(e) {
            e.preventDefault(); // Evitar el comportamiento predeterminado del enlace
            var href = $(this).attr('href'); // Obtener la URL del enlace
            loadPage(href); // Cargar la página usando AJAX

          
        });

        $('#contentArea').on('click', '.LoadEliminarPerfil', function(e) {
            e.preventDefault(); // Evitar el comportamiento predeterminado del enlace
            var href = $(this).attr('href');
            loadPage(href); // Cargar la página usando AJAX

            
        });

        // Función para cargar contenido mediante AJAX
        function loadPage(page) {
            $.ajax({
                url: page,
                type: 'GET',
                success: function(response) {

                    // Simular un tiempo de demora
                setTimeout(function () {
                    $("#spinner").hide();
                    $('#contentArea').html(response).show(); // Cargar el contenido en el área de contenido

                }, 1000);


                   
                },
                error: function () {
                    // Manejar errores, ocultar el spinner
                    $("#spinner").hide();
                    $("#contentArea").html("<p>Error al cargar el contenido.</p>").show();
                }
            });

           

            
        }
    });

