$(document).ready(function () {
    $('#formModificarJoya').on('submit', function (e) {
        e.preventDefault(); // Evitar el envío tradicional del formulario

        // Serializar los datos del formulario
        var formData = $(this).serialize();

        $.ajax({
            url: 'gestion_productos.php', // La misma URL del archivo PHP
            type: 'POST',
            data: formData,
            dataType: 'json', // Esperar una respuesta JSON
            success: function (response) {
                if (response.status === 'success') {
                    // Mostrar un mensaje de éxito
                    alert(response.message);

                    // Cargar gestion_productos.php en el div deseado
                    $('#contentArea').load('gestion_productos.php');
                } else {
                    // Mostrar un mensaje de error
                    alert('Error: ' + response.message);
                }
            },
            error: function () {
                // Manejar errores genéricos
                alert('Ocurrió un error al procesar la solicitud.');
            }
        });
    });
});