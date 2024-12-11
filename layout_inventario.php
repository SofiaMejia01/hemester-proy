<?php
include './session_check.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valoracion de Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="css/menu.css">
</head>

<body>

    <h1 class="text-center">Gestion de Inventario</h1>

    <div class="container my-4">
        <div class="row">


            <!-- Botones de filtro -->
            <div class="col text-start">
                <button id="btnTodos" class="btn btn-primary">Listado General</button>
            </div>
            <div class="col text-start">
                <button id="btnFiltroDiamante" class="btn btn-secondary">Diamantes GIA</button>
            </div>
            <div class="col text-start">
                <button id="btnFiltroGema" class="btn btn-success">Gemas de Color</button>
            </div>
        </div>
    </div>

    <br>
    <hr>

    <!-- Layout general -->
    <div class="container-fluid">
        <div class="row vh-mobil-100">
            <div class="container-fluid">
                <div class="row">

                    <!-- Formulario para agregar un diamante -->
                    <div id="divFormDiamante" class="col-12 col-xl-4 mb-5">
                        <div class="container">
                            <h3 id=formDiamanteTitulo>Agregar Nuevo Diamante</h3>
                            <form id="formAgregarModificarDiamante" class="p-3 border rounded">
                                <input type="hidden" id="id_diamante" name="id_diamante">
                                <div class="form-group mb-3">
                                    <label for="tipo_certificado" class="form-label">Tipo de Certificado:</label>
                                    <input type="text" name="tipo_certificado" id="tipo_certificado" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="numero_certificado" class="form-label">N° Certificado:</label>
                                    <input type="text" name="numero_certificado" id="numero_certificado" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="forma" class="form-label">Forma:</label>
                                    <input type="text" name="forma" id="forma" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="peso" class="form-label">Peso (CT):</label>
                                    <input type="text" name="peso" id="peso" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="dimensiones" class="form-label">Dimensiones (MM):</label>
                                    <input type="text" name="dimensiones" id="dimensiones" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="color" class="form-label">Color:</label>
                                    <input type="text" name="color" id="color" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="claridad" class="form-label">Claridad:</label>
                                    <input type="text" name="claridad" id="claridad" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="corte" class="form-label">Corte:</label>
                                    <input type="text" name="corte" id="corte" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="pulido" class="form-label">Pulido:</label>
                                    <input type="text" name="pulido" id="pulido" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="simetria" class="form-label">Simetría:</label>
                                    <input type="text" name="simetria" id="simetria" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="fluorescencia" class="form-label">Fluorescencia:</label>
                                    <input type="text" name="fluorescencia" id="fluorescencia" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="tratamiento" class="form-label">Tratamiento:</label>
                                    <input type="text" name="tratamiento" id="tratamiento" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="calidad" class="form-label">Calidad:</label>
                                    <input type="text" name="calidad" id="calidad" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="comentarios" class="form-label">Comentarios:</label>
                                    <input type="text" name="comentarios" id="comentarios" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="ubicacion" class="form-label">Ubicación:</label>
                                    <input type="text" name="ubicacion" id="ubicacion" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="subtotal" class="form-label">SubTotal_USD:</label>
                                    <input type="text" name="subtotal" id="subtotal" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="total" class="form-label">Total_USD:</label>
                                    <input type="text" name="total" id="total" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="estado" class="form-label">Estado:</label>
                                    <select name="estado" id="estado" class="form-select" required>
                                        <option value="">Seleccione un estado</option>
                                        <?php
                                        echo "holi";
                                        $states_query = "SELECT Nombre_Estado FROM estado_pp";
                                        $states_result = $conn->query($states_query);

                                        if ($states_result->num_rows > 0) {
                                            while ($row = $states_result->fetch_assoc()) {
                                                // Marca como seleccionado el estado actual
                                                $selected = ($diamante['ID_Estado'] == $row['Nombre_Estado']) ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($row['Nombre_Estado']) . "' $selected>" . htmlspecialchars($row['Nombre_Estado']) . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <button id="btn-diamante" type="submit" class="btn btn-primary">Modificar Diamante</button>
                            </form>
                        </div>
                    </div>

                    <!-- Formulario para agregar una Gema -->
                    <div id="divFormGema" class="col-12 col-xl-4 mb-5">
                        <div class="container">
                            <h3 id="formGemaTitulo">Agregar Nueva Gema de Color</h3>
                            <form id="formAgregarModificarGema" class="p-3 border rounded">
                                <input type="hidden" id="id_gema" name="id_gema">
                                <div class="form-group mb-3">
                                    <label for="tipo" class="form-label">Tipo de Gema:</label>
                                    <input type="text" name="tipo" id="tipo" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="tipo_certificado_g" class="form-label">Tipo de Certificado:</label>
                                    <input type="text" name="tipo_certificado_g" id="tipo_certificado_g" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="numero_certificado_g" class="form-label">N° Certificado:</label>
                                    <input type="text" name="numero_certificado_g" id="numero_certificado_g" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="forma_g" class="form-label">Forma:</label>
                                    <input type="text" name="forma_g" id="forma_g" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="peso_g" class="form-label">Peso (CT):</label>
                                    <input type="text" name="peso_g" id="peso_g" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="dimensiones_g" class="form-label">Dimensiones (MM):</label>
                                    <input type="text" name="dimensiones_g" id="dimensiones_g" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="tratamiento_g" class="form-label">Tratamiento:</label>
                                    <input type="text" name="tratamiento_g" id="tratamiento_g" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="calidad_g" class="form-label">Calidad:</label>
                                    <input type="text" name="calidad_g" id="calidad_g" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="comentarios_g" class="form-label">Comentarios:</label>
                                    <input type="text" name="comentarios_g" id="comentarios_g" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="ubicacion_g" class="form-label">Ubicación:</label>
                                    <input type="text" name="ubicacion_g" id="ubicacion_g" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="subtotal_g" class="form-label">SubTotal_USD:</label>
                                    <input type="text" name="subtotal_g" id="subtotal_g" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="total_g" class="form-label">Total_USD:</label>
                                    <input type="text" name="total_g" id="total_g" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="estado_g" class="form-label">Estado:</label>

                                    <select name="estado_g" id="estado_g" class="form-select" required>
                                        <option value="">Seleccione un estado</option>
                                        <?php
                                        echo "holi";
                                        $states_query = "SELECT Nombre_Estado FROM estado_pp";
                                        $states_result = $conn->query($states_query);

                                        if ($states_result->num_rows > 0) {
                                            while ($row = $states_result->fetch_assoc()) {
                                                // Marca como seleccionado el estado actual
                                                $selected = ($diamante['ID_Estado'] == $row['Nombre_Estado']) ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($row['Nombre_Estado']) . "' $selected>" . htmlspecialchars($row['Nombre_Estado']) . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <button id="btn-gema" type="submit" class="btn btn-primary">Modificar Gema</button>

                            </form>
                        </div>
                    </div>

                    <!---------------------------------- ------------DataTable para listar las joyas(diamantes y gemas) -------------------------------------------------------->

                    <div id="divppTable" class="col-12 mb-5">
                        <div class="table-section bg-white p-3 mb-5">
                            <h5>Lista de Joyas</h5>
                            <br>
                            <div class="table-responsive">
                                <table id="ppTable" class="display table table-striped w-100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Categoría Piedra Preciosa</th>
                                            <th>Tipo de Piedra Preciosa</th>
                                            <th>Tipo de Certificado</th>
                                            <th>N° Certificado</th>
                                            <th>Forma</th>
                                            <th>Peso (CT)</th>
                                            <th>Dimensiones (MM)</th>
                                            <th>Color</th>
                                            <th>Claridad</th>
                                            <th>Corte</th>
                                            <th>Pulido</th>
                                            <th>Simetría</th>
                                            <th>Fluorescencia</th>
                                            <th>Tratamiento</th>
                                            <th>Calidad</th>
                                            <th>Comentarios</th>
                                            <th>Ubicación</th>
                                            <th>Subtotal (USD)</th>
                                            <th>Total (USD)</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Los registros se llenarán aquí dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="js/index.js"></script>


    <!-------------------- ------------------------Scripts JS ------------------------------------->
    <script>
        var tablaInventario;
        var tipoTabla = '';

        //----------------------- ------ocultar formularios en la lista general -------------------------------------------                                        
        $('#divFormDiamante').hide();
        $('#divFormGema').hide();


        //--------- en listado general se llena el datable con los datos y se oculta la columna acciones---------------------

        $(document).ready(function() {

            // Inicializar DataTables
            tablaInventario = $('#ppTable').DataTable({
                ajax: {
                    url: 'get_registros.php', // El archivo que obtiene los registros
                    dataSrc: '' // Los datos provienen directamente del JSON (sin necesidad de envolver en otra propiedad)
                },
                columns: [{
                        data: 'ID_PP'
                    },
                    {
                        data: 'Cat_PP'
                    },
                    {
                        data: 'Tipo_PP'
                    },
                    {
                        data: 'Tipo_Certificado'
                    },
                    {
                        data: 'N°_Certificado'
                    },
                    {
                        data: 'Forma'
                    },
                    {
                        data: 'Peso_CT'
                    },
                    {
                        data: 'Dimensiones_MM'
                    },
                    {
                        data: 'Color'
                    },
                    {
                        data: 'Claridad'
                    },
                    {
                        data: 'Corte'
                    },
                    {
                        data: 'Pulido'
                    },
                    {
                        data: 'Simetría'
                    },
                    {
                        data: 'Fluorescencia'
                    },
                    {
                        data: 'Tratamiento'
                    },
                    {
                        data: 'Calidad'
                    },
                    {
                        data: 'Comentarios'
                    },
                    {
                        data: 'Ubicación'
                    },
                    {
                        data: 'SubTotal_USD'
                    },
                    {
                        data: 'Total_USD'
                    },
                    {
                        data: 'Estado'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <button class="tablaModificar" data-id="${row.ID_PP}">Modificar</button>
                            `;
                        }
                    }
                ]
            });

            //-----------aca se oculta la colummna de "acciones" en listado general -----------------------------------------
            // Seleccionar la última columna
            const column = tablaInventario.column(tablaInventario.columns().count() - 1);
            column.visible(false);

            //-------------------------LISTADO GENERAL:Mostrar todos los datos con un click al boton--------------------------
            $('#btnTodos').on('click', function() {
                tipoTabla = '';
                $('#divFormDiamante').hide();
                $('#divFormGema').hide();


                $('#divppTable').removeClass('col-xl-8');

                tablaInventario.search('').columns().search('').draw(); // Elimina cualquier filtro y muestra todos los datos

                //oculta la columna de acciones
                const column = tablaInventario.column(tablaInventario.columns().count() - 1);
                column.visible(false);
            });

            //-------------------------------------GESTION DE DIAMANTES ------------------------------------------------------
            // Filtrar por categoría "Diamante"
            $('#btnFiltroDiamante').on('click', function() {
                tipoTabla = 'diamante';
                $('#divFormDiamante').show();
                $('#divFormGema').hide();

                $("#formDiamanteTitulo").html("Agregar Nuevo Diamante");
                $("#btn-diamante").html("Agregar Diamante");
                limpiarFormDiamante();

                $('#divppTable').addClass('col-xl-8');
                tablaInventario.column(1).search('Diamante GIA').draw(); // Filtra la columna de categoría por "Diamante GIA"

                //asegura que la última columna de la tabla  sea visible
                const column = tablaInventario.column(tablaInventario.columns().count() - 1);
                column.visible(true);

                for (let i = 8; i <= 13; i++) { // Ocultar columnas 2, 3 y 4
                    tablaInventario.column(i).visible(true);
                }
            });

            //aca se agrega o modifica un diamante
            $('#formAgregarModificarDiamante').on('submit', function(e) {

                // console.log("entrando a submit");

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
                    url: 'diamante/modificar_diamante.php', // Dirección del servidor
                    method: 'POST',
                    data: formData,
                    dataType: 'json', // Esperamos una respuesta JSON
                    success: function(response) {
                        tablaInventario.ajax.reload();
                        if (response.status === 'success') {
                            alert(response.message);
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Ocurrió un error al procesar la solicitud (modificar_diamante.php).');
                        console.error('Detalles del error:', error);
                    }
                });
            });

            //-------------------------------------GESTION DE GEMAS ------------------------------------------------------
            // Filtrar por categoría "Gema"
            $('#btnFiltroGema').on('click', function() {
                tipoTabla = 'gema';
                $('#divFormDiamante').hide();
                $('#divFormGema').show();

                $("#formGemaTitulo").html("Agregar Nueva Gema de Color");
                $("#btn-gema").html("Agregar Gema");
                limpiarFormGema();

                $('#divppTable').addClass('col-xl-8');
                tablaInventario.column(1).search('GDC IGI').draw(); // Filtra la columna de categoría por "GDC IGI"

                //asegura que la última columna de la tabla  sea visible
                const column = tablaInventario.column(tablaInventario.columns().count() - 1);
                column.visible(true);

                for (let i = 8; i <= 13; i++) { // Ocultar columnas 2, 3 y 4
                    tablaInventario.column(i).visible(false);
                }
            });

            //aca se agrega o modifica una gema
            $('#formAgregarModificarGema').on('submit', function(e) {

                // console.log("entrando a submit");

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
                    url: 'diamante/modificar_gema.php', // Dirección del servidor
                    method: 'POST',
                    data: formData,
                    dataType: 'json', // Esperamos una respuesta JSON
                    success: function(response) {
                        tablaInventario.ajax.reload();
                        if (response.status === 'success') {
                            alert(response.message);
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Ocurrió un error al procesar la solicitud (modificar_gema.php).');
                        console.error('Detalles del error:', error);
                    }
                });
            });

            //------------------- BOTON O ENLACE MODIFICAR, AL HACERLE CLICK-------------------------------------------
            $('#ppTable tbody').on('click', '.tablaModificar', function() {

                if (tipoTabla === 'diamante') {
                    $("#formDiamanteTitulo").html("Modificar Diamante");
                    $("#btn-diamante").html("Modificar Diamante");

                    const id = $(this).data('id');
                    // console.log("id 11 =>", id)
                    $.ajax({
                        url: 'diamante/get_registro.php',
                        method: 'POST',
                        data: {
                            id
                        },
                        dataType: 'json',
                        success: function(data) {

                            // console.log("data22 =>", data)
                            $('#id_diamante').val(data.ID_PP);
                            $('#tipo_certificado').val(data.Tipo_Certificado);
                            $('#numero_certificado').val(data["N°_Certificado"]);
                            $('#forma').val(data.Forma);
                            $('#peso').val(data.Peso_CT);
                            $('#dimensiones').val(data.Dimensiones_MM);
                            $('#color').val(data.Color);
                            $('#claridad').val(data.Claridad);
                            $('#corte').val(data.Corte);
                            $('#pulido').val(data.Pulido);
                            $('#simetria').val(data.Simetría);
                            $('#fluorescencia').val(data.Fluorescencia);
                            $('#tratamiento').val(data.Tratamiento);
                            $('#calidad').val(data.Calidad);
                            $('#comentarios').val(data.Comentarios);
                            $('#ubicacion').val(data.Ubicación);
                            $('#subtotal').val(data.SubTotal_USD);
                            $('#total').val(data.Total_USD);
                            $('#estado').val(data.ID_Estado);


                        },
                        error: function(xhr, status, error) {
                            console.error('Error en AJAX:', status, error);
                            console.error('Respuesta completa:', xhr.responseText);
                        }
                    });
                } else if (tipoTabla === 'gema') {
                    $("#formGemaTitulo").html("Modificar Gema");
                    $("#btn-gema").html("Modificar Gema");

                    const id = $(this).data('id');
                    // console.log("id 11 =>", id)
                    $.ajax({
                        url: 'diamante/get_registro.php',
                        method: 'POST',
                        data: {
                            id
                        },
                        dataType: 'json',
                        success: function(data) {

                             console.log("data22 =>", data)
                            $('#id_gema').val(data.ID_PP);
                            $('#tipo').val(data.Tipo_PP);
                            $('#tipo_certificado_g').val(data.Tipo_Certificado);
                            $('#numero_certificado_g').val(data["N°_Certificado"]);
                            $('#forma_g').val(data.Forma);
                            $('#peso_g').val(data.Peso_CT);
                            $('#dimensiones_g').val(data.Dimensiones_MM);
                            // $('#color').val(data.Color);
                            // $('#claridad').val(data.Claridad);
                            // $('#corte').val(data.Corte);
                            // $('#pulido').val(data.Pulido);
                            // $('#simetria').val(data.Simetría);
                            // $('#fluorescencia').val(data.Fluorescencia);
                            $('#tratamiento_g').val(data.Tratamiento);
                            $('#calidad_g').val(data.Calidad);
                            $('#comentarios_g').val(data.Comentarios);
                            $('#ubicacion_g').val(data.Ubicación);
                            $('#subtotal_g').val(data.SubTotal_USD);
                            $('#total_g').val(data.Total_USD);
                            $('#estado_g').val(data.ID_Estado);


                        },
                        error: function(xhr, status, error) {
                            console.error('Error en AJAX:', status, error);
                            console.error('Respuesta completa:', xhr.responseText);
                        }
                    });
                }



                // console.log("#formModificarDiamante =>", $('#formModificarDiamante'));


            });





            /*
            function cargarRegistros() {
                $.ajax({
                    url: 'get_registros.php', // El archivo que obtiene los registros
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        var tbody = $('#ppTable tbody');
                        tbody.empty(); // Limpiar la tabla antes de agregar nuevos registros

                        // Recorrer los registros y agregarlos a la tabla
                        data.forEach(function (registro) {
                            tbody.append(
                                '<tr>' +
                                    '<td>' + registro.ID + '</td>' +
                                    '<td>' + registro.Nombre + '</td>' +
                                    '<td>' + registro.Edad + '</td>' +
                                    '<td>' +
                                        '<button class="editar" data-id="' + registro.ID + '">Editar</button>' +
                                        '<button class="eliminar" data-id="' + registro.ID + '">Eliminar</button>' +
                                    '</td>' +
                                '</tr>'
                            );
                        });

                        // Agregar eventos para editar y eliminar
                        $('.editar').click(function() {
                            var id = $(this).data('id');
                            // Código para editar el registro (puedes mostrar el formulario para editar)
                            editarRegistro(id);
                        });

                        $('.eliminar').click(function() {
                            var id = $(this).data('id');
                            // Código para eliminar el registro
                            eliminarRegistro(id);
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('Error al cargar los registros:', error);
                    }
                });
            }
                */
        });



        function limpiarFormDiamante() {
            $('#id').val("");
            $('#tipo_certificado').val("");
            $('#numero_certificado').val("");
            $('#forma').val("");
            $('#peso').val("");
            $('#dimensiones').val("");
            $('#color').val("");
            $('#claridad').val("");
            $('#corte').val("");
            $('#pulido').val("");
            $('#simetria').val("");
            $('#fluorescencia').val("");
            $('#tratamiento').val("");
            $('#calidad').val("");
            $('#comentarios').val("");
            $('#ubicacion').val("");
            $('#subtotal').val("");
            $('#total').val("");
            $('#estado').val("");
        }


        function limpiarFormGema() {
            $('#id').val("");
            $('#tipo').val("");
            $('#tipo_certificado_g').val("");
            $('#numero_certificado_g').val("");
            $('#forma_g').val("");
            $('#peso_g').val("");
            $('#dimensiones_g').val("");
            $('#tratamiento_g').val("");
            $('#calidad_g').val("");
            $('#comentarios_g').val("");
            $('#ubicacion_g').val("");
            $('#subtotal_g').val("");
            $('#total_g').val("");
            $('#estado_g').val("");
        }
    </script>

</body>

</html>