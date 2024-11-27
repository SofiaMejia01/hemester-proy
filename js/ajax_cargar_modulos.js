
 $(document).ready(function() {

        loadPage('menu_principal.php');



        /*------------Cargar el modulo de Almacen-------------------*/ 
        $('#loadProductos').click(function() {
                loadPage('gestion_productos.php');
        });
    
         $('#loadInventarios').click(function() {
                loadPage('gestion_inventario.php');
        });
    
        $('#loadValoracionProd').click(function() {
                loadPage('valoracion_prod.php');
        });
        

        /*------------Cargar el modulo de Producción-------------------*/ 
        $('#loadConfiProd').click(function() {
                loadPage('conf_prod.php');
        });
        
         $('#loadProcPrep').click(function() {
                loadPage('proc_preparacion.php');
        });


          /*------------Cargar el modulo de Generacion de Documentos-------------------*/ 
          $('#loadContratos').click(function() {
            loadPage('contratos.php');
             });
    
            $('#loadCertificados').click(function() {
            loadPage('certificados.php');
          });
        
    

        /*------------Cargar el modulo de Accesos-------------------*/ 
        $('#loadUsers').click(function() {
            loadPage('mantenimiento_usuarios.php');

              // Mostrar el spinner y ocultar el contenido
             $("#spinner").show();
             $("#contentArea").hide()
        });

        $('#loadProfiles').click(function() {
            loadPage('perfiles.php');
        });

        $('#loadSessions').click(function() {
            loadPage('control_sesiones.php');
        });
        

        /*------------Cargar el modulo de Reportes-------------------*/ 
        $('#loadKardex').click(function() {
            loadPage('kardex.php');
        });

        $('#loadReporteCompraVenta').click(function() {
            loadPage('reporte_compra_venta.php');
        });

        $('#loadReporteValProd').click(function() {
            loadPage('reporte_valoracion_producto.php');
        });

          /*------------Cargar  la Pagina Principal-------------------*/ 
          $('#loadMenuPrincipal').click(function() {
            loadPage('menu_principal.php');
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

                }, 5000);


                   
                },
                error: function () {
                    // Manejar errores, ocultar el spinner
                    $("#spinner").hide();
                    $("#contentArea").html("<p>Error al cargar el contenido.</p>").show();
                }
            });

           

            
        }
    });

