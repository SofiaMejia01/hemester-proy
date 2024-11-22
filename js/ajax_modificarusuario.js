$(document).ready(function () {
  $("#updateUserForm").on("submit", function (event) {
    event.preventDefault(); // Prevent default form submission

    // Serialize form data
    var formData = $(this).serialize();

    // Send AJAX request
    $.ajax({
      type: "POST",
      url: $(this).attr("action"), // Use the action URL from the form
      data: formData,
      dataType: "json", // Expect a JSON response
      success: function (response) {
        if (response.status === "success") {
          window.location.href = "accesos.php"; // Redirect to users page
        } else {
          alert("Error al modificar el usuario: " + response.message);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
      },
    });
  });
});
