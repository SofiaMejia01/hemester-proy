$(document).ready(function () {
    $('#formAgregarConfProd').on('submit', function (e) {
        e.preventDefault(); // Evitar el comportamiento predeterminado del formulario

        // Serializar los datos del formulario
        var formData = $(this).serialize();

        $.ajax({
            url: 'conf_prod.php', // La URL a la que se enviará el formulario
            type: 'POST',  // Usamos POST para enviar datos
            data: formData,
            dataType: 'json', // Esperamos una respuesta en formato JSON
            success: function(response) {
                // Verificamos el estado de la respuesta
                if (response.status === 'success') {
                    // Mostrar un mensaje de éxito con alert
                    alert(response.message);
                    
                    // Cargar la página 'configuracion_produccion.php' dentro del div 'contentArea'
                    $('#contentArea').load('conf_prod.php');
                } else {
                    // Si hubo un error, mostrarlo
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                // Si ocurre un error con la solicitud AJAX
                alert('Ocurrió un error al procesar la solicitud.');
            }
        });
    });
});