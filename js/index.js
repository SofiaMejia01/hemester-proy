// Inicialización de DataTables

//datatable en mantenimiento_usuario
$(document).ready(function () {
  $("#listUser").DataTable({
    pageLength: 10,
    searching: true,
    bDestroy: true,
  });
});

//datatable en modificar usuario

$(document).ready(function () {
  $("#modUser").DataTable({
    pageLength: 10,
    searching: true,
  });
});

$(document).ready(function () {
  $("#listRole").DataTable({
    pageLength: 10,
    searching: true,
    bDestroy: true,
  });
});

$(document).ready(function () {
  $("#listSessiones").DataTable({
    pageLength: 10,
    searching: true,
    bDestroy: true,
  });
});