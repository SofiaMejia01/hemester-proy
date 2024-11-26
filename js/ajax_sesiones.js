$(document).ready(function () {
  // Handle the delete session link click
  $(document).on("click", ".delete-session", function (e) {
    e.preventDefault(); // Prevent the default link behavior
    var sessionId = $(this).data("id"); // Get the session ID from data attribute

    if (confirm("¿Estás seguro de que deseas cerrar esta sesión?")) {
      $.ajax({
        url: "eliminar_sesion.php?id=" + sessionId, // URL to the delete script
        type: "GET",
        success: function (response) {
          // Optionally, you can handle the response if needed
          // For example, you can show a success message
          alert("Sesión eliminada exitosamente.");

          // Reload the session list
          loadSessions(); // Function to reload the session list
        },
        error: function (xhr, status, error) {
          alert("Ocurrió un error al eliminar la sesión: " + error);
        },
      });
    }
  });

  // Function to load the sessions via AJAX
  function loadSessions() {
    $.ajax({
      url: "control_sesiones.php", // URL to reload the session list
      type: "GET",
      success: function (response) {
        $("#contentArea").html(response); // Load the new content into the content area
      },
      error: function (xhr, status, error) {
        alert("Ocurrió un error al cargar las sesiones: " + error);
      },
    });
  }
});
