$(document).ready(function () {
  // Inicializar DataTable
  var usuariosTable = $("#listUser").DataTable();

  // Manejar la sumisión del formulario para agregar un nuevo usuario
  $("#addUserForm").on("submit", function (e) {
    e.preventDefault(); // Prevenir el envío estándar del formulario

    $.ajax({
      type: "POST",
      url: "mantenimiento_usuarios.php", // El archivo PHP que maneja la sumisión del formulario
      data: $(this).serialize(), // Serializa los datos del formulario
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          // Agregar el nuevo usuario a la tabla DataTable
          usuariosTable.row
            .add([
              response["newUserId"], // ID del nuevo usuario
              response["nombre_trabajador"],
              response["nombre_usuario"], // Nombre de usuario
              response["password_usuario"], // Mostrar la contraseña aquí
              $("#perfil option:selected").text(), // Perfil seleccionado
              $("#estado option:selected").text(), // Estado seleccionado
              `
            <a href='modificar_usuario.php?id=${response.newUserId}' class='LoadModificarUsuario' >Modificar</a>
            `,
            ])
            .draw(false); // Dibujar la nueva fila sin resetear la paginación

          // Opcionalmente, resetear el formulario
          $("#addUserForm")[0].reset();

          alert("Usuario agregado exitosamente.");
        } else {
          alert("Error: " + response.message); // Mostrar mensaje de error
        }
      },
      error: function (xhr, status, error) {
        alert("Ocurrió un error: " + error); // Mostrar un error si la petición falla
      },
    });
  });
});
