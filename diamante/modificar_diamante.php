<?php
include '../session_check.php';

// si encuentra un id, se hara el modificar diamante
$diamond_id = intval($_POST['id_diamante']);

$tipo_certificado = $_POST['tipo_certificado'];
$numero_certificado = $_POST['numero_certificado'];
$forma = $_POST['forma'];
$peso = $_POST['peso'];
$dimensiones = $_POST['dimensiones'];
$color = $_POST['color'];
$claridad = $_POST['claridad'];
$corte = $_POST['corte'];
$pulido = $_POST['pulido'];
$simetria = $_POST['simetria'];
$fluorescencia = $_POST['fluorescencia'];
$tratamiento = $_POST['tratamiento'];
$calidad = $_POST['calidad'];
$comentarios = $_POST['comentarios'];
$ubicacion = $_POST['ubicacion'];
$subtotal = $_POST['subtotal'];
$total = $_POST['total'];
$estado = $_POST['estado'];

if ($diamond_id) {
   
    $update_query = "UPDATE piedras_preciosas 
                         SET Tipo_Certificado = ?, `N°_Certificado` = ?, Forma = ?, Peso_CT = ?, Dimensiones_MM = ?, 
                             Color = ?, Claridad = ?, Corte = ?, Pulido = ?, `Simetría` = ?, Fluorescencia = ?, 
                            Tratamiento = ?, Calidad = ?, Comentarios = ?, Ubicación = ?, SubTotal_USD = ?, 
                             Total_USD = ?, ID_Estado = (SELECT ID_Estado FROM estado_pp WHERE Nombre_Estado = ?)
                         WHERE ID_PP = ?";

    $stmt = $conn->prepare($update_query);

    if($stmt){
        $stmt->bind_param("ssssssssssssssssssi", $tipo_certificado, $numero_certificado, $forma, $peso, $dimensiones,$color, $claridad, $corte, $pulido, $simetria, $fluorescencia, $tratamiento, $calidad, $comentarios, $ubicacion, $subtotal, $total, $estado, $diamond_id);
        $stmt->execute();
        
        if($stmt->affected_rows > 0){
            echo json_encode(['status' => 'success', 'message' => 'Diamante modificado exitosamente.']);
        }else {
            echo json_encode(['error' => 'No se pudo actualizar el registro']);
        }

        $stmt->close();
    }else {
        echo json_encode(['error' => 'Error en la preparación del SQL (UPDATE)']);
    }

// sino encuentra un id, se hara el agregar diamante
} else {

    $categoria = 'Diamante GIA'; // Fixed category
    $tipo = 'Diamante'; // Fixed type

    $insert_query = "INSERT INTO piedras_preciosas (Cat_PP, Tipo_PP, Tipo_Certificado, N°_Certificado, Forma, Peso_CT, Dimensiones_MM, Color, Claridad, Corte, Pulido, Simetría, Fluorescencia, Tratamiento, Calidad, Comentarios, Ubicación, SubTotal_USD, Total_USD, ID_Estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, (SELECT ID_Estado FROM estado_pp WHERE Nombre_Estado = ?))";
    $stmt = $conn->prepare($insert_query);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssssssssssssssssssss", $categoria, $tipo, $tipo_certificado, $numero_certificado, $forma, $peso, $dimensiones, $color, $claridad, $corte, $pulido, $simetria, $fluorescencia, $tratamiento, $calidad, $comentarios, $ubicacion, $subtotal, $total, $estado);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Diamante agregado exitosamente.']);
        } else {
            echo json_encode(['error' => 'No se pudo crear el registro']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error en la preparación del SQL (INSERT)']);
    }
   
}   

 // Close the statement
 //$stmt->close();

?>


