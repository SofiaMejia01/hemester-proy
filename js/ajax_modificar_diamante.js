// $(document).ready(function () {
//     $('#formModificarDiamante').on('submit', function (e) {
//         e.preventDefault(); // Evitar el envío tradicional del formulario

//         // Serializar los datos del formulario
//         var formData = $(this).serialize();

//         $.ajax({
//             url: 'modificar_diamante.php', // La misma URL del archivo PHP
//             type: 'POST',
//             data: formData,
//             dataType: 'json', // Esperar una respuesta JSON
//             success: function (response) {
//                 if (response.status === 'success') {
//                     // Mostrar un mensaje de éxito
//                     alert(response.message);

//                     // Cargar gestion_productos.php en el div deseado
//                     $('#contentArea2').load('modificar_diamante.php');
//                 } else {
//                     // Mostrar un mensaje de error
//                     alert('Error: ' + response.message);
//                 }
//             },
//             error: function () {
//                 // Manejar errores genéricos
//                 alert('Ocurrió un error al procesar la solicitud.');
//             }
//         });
//     });
// });



// $(document).ready(function () {
//     $('#formModificarDiamante').on('submit', function (e) {
//         e.preventDefault(); // Evitar el envío tradicional del formulario

//         // Serializar los datos del formulario
//         var formData = $(this).serialize();

//         // Agregar manualmente el ID al formData
//         var id = $('#id').val(); // Leer el valor del campo oculto
//         formData += '&id=' + encodeURIComponent(id);

//         $.ajax({
//             url: 'modificar_diamante.php', // La misma URL del archivo PHP
//             type: 'POST',
//             data: formData,
//             dataType: 'json', // Esperar una respuesta JSON
//             success: function (response) {
//                 if (response.status === 'success') {
//                     // Mostrar un mensaje de éxito
//                     alert(response.message);

//                     // Recargar el contenido
//                     $('#contentArea2').load('modificar_diamante.php?id=' + id);
//                 } else {
//                     // Mostrar un mensaje de error
//                     alert('Error: ' + response.message);
//                 }
//             },
//             error: function () {
//                 // Manejar errores genéricos
//                 alert('Ocurrió un error al procesar la solicitud.');
//             }
//         });
//     });
// });



/*
$('#formModificarDiamante').on('submit', function (e) {

    console.log("holaaa")

    e.preventDefault(); // Evita el envío tradicional del formulario

    // Serializa los datos del formulario
    var formData = $(this).serialize();
   

    // Validación manual opcional
    if (!formData.includes('tipo_certificado') || !formData.includes('numero_certificado')) {
        alert('Todos los campos obligatorios deben completarse.');
        return;
    }

    console.log('Datos enviados:', formData); // Verifica qué datos se están enviando

    // Realiza la solicitud AJAX
    $.ajax({
        url: 'modificar_diamante.php', // Dirección del servidor
        type: 'POST',
        data: formData,
        dataType: 'json', // Esperamos una respuesta JSON
        success: function (response) {
            if (response.status === 'success') {
                alert(response.message);
                // Recarga el contenido actualizado si es necesario
                $('#contentArea2').load('modificar_diamante.php');
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            alert('Ocurrió un error al procesar la solicitud.');
            console.error('Detalles del error:', error);
        }
    });
});
*/
