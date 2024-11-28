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
          // window.location.href = "admin_menu.php"; // Redirect to users page
          loadPage(response.redirectUrl);
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

function loadPage(page) {
  $.ajax({
    url: page,
    type: "GET",
    success: function (response) {
      $("#contentArea").html(response); // Load the content into the content area
    },
  });
}
