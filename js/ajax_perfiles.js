$(document).ready(function () {
  // Obtén la instancia de DataTables
  var table = $("#listRole").DataTable();

  $("#addProfileForm").on("submit", function (event) {
    event.preventDefault(); // Evita la recarga de la página

    // Serializa los datos del formulario
    var formData = $(this).serialize();

    // Envía los datos al servidor usando AJAX
    $.ajax({
      type: "POST",
      url: $(this).attr("action"), // URL especificada en el formulario
      data: formData,
      success: function (response) {
        console.log("Respuesta del servidor:", response);

        if (response.status === "success") {
          // Agrega la nueva fila usando DataTables
          table.row
            .add([
              response.newProfileId,
              response.nombre_perfil,
              response.descripcion_perfil,
              `
            <a href='modificar_perfil.php?id=${response.newProfileId}'>Modificar</a>
            <a href='eliminar_perfil.php?id=${response.newProfileId}' onclick='return confirmDelete();'>Eliminar</a>
            `,
            ])
            .draw(false); // Dibuja la tabla sin reiniciar la página

          // Limpia el formulario
          $("#addProfileForm")[0].reset();
        } else {
          alert("Error al agregar el perfil: " + response.message);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error en el envío:", textStatus, errorThrown);
      },
    });
  });
});
