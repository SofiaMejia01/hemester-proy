<?php
include '../session_check.php';

// si encuentra un id, se hara el modificar gema
$gema_id = intval($_POST['id_gema']);
$tipo = $_POST['tipo'];
$tipo_certificado = $_POST['tipo_certificado_g'];
$numero_certificado = $_POST['numero_certificado_g'];
$forma = $_POST['forma_g'];
$peso = $_POST['peso_g'];
$dimensiones = $_POST['dimensiones_g'];
// $color = $_POST['color'];
// $claridad = $_POST['claridad'];
// $corte = $_POST['corte'];
// $pulido = $_POST['pulido'];
// $simetria = $_POST['simetria'];
// $fluorescencia = $_POST['fluorescencia'];
$tratamiento = $_POST['tratamiento_g'];
$calidad = $_POST['calidad_g'];
$comentarios = $_POST['comentarios_g'];
$ubicacion = $_POST['ubicacion_g'];
$subtotal = $_POST['subtotal_g'];
$total = $_POST['total_g'];
$estado = $_POST['estado_g'];

if ($gema_id) {
   
    $update_query = "UPDATE piedras_preciosas 
                         SET Tipo_PP = ?, Tipo_Certificado = ?, `N°_Certificado` = ?, Forma = ?, Peso_CT = ?, Dimensiones_MM = ?, 
                            
                            Tratamiento = ?, Calidad = ?, Comentarios = ?, Ubicación = ?, SubTotal_USD = ?, 
                             Total_USD = ?, ID_Estado = (SELECT ID_Estado FROM estado_pp WHERE Nombre_Estado = ?)
                         WHERE ID_PP = ?";

    $stmt = $conn->prepare($update_query);

    if($stmt){
        $stmt->bind_param("sssssssssssssi", $tipo, $tipo_certificado, $numero_certificado, $forma, $peso, $dimensiones, $tratamiento, $calidad, $comentarios, $ubicacion, $subtotal, $total, $estado, $gema_id);
        $stmt->execute();
        
        if($stmt->affected_rows > 0){
            echo json_encode(['status' => 'success', 'message' => 'Gema modificado exitosamente.']);
        }else {
            echo json_encode(['error' => 'No se pudo actualizar el registro']);
        }

        $stmt->close();
    }else {
        echo json_encode(['error' => 'Error en la preparación del SQL (UPDATE)']);
    }


} else {  // sino encuentra un id, se hara el agregar gema
    $categoria = 'GDC IGI'; // Fixed category
    

    $insert_query = "INSERT INTO piedras_preciosas (Cat_PP, Tipo_PP, Tipo_Certificado, N°_Certificado, Forma, Peso_CT, Dimensiones_MM, Color, Claridad, Corte, Pulido, Simetría, Fluorescencia, Tratamiento, Calidad, Comentarios, Ubicación, SubTotal_USD, Total_USD, ID_Estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, (SELECT ID_Estado FROM estado_pp WHERE Nombre_Estado = ?))";
    $stmt = $conn->prepare($insert_query);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssssssssssssssssssss", $categoria, $tipo, $tipo_certificado, $numero_certificado, $forma, $peso, $dimensiones, $color, $claridad, $corte, $pulido, $simetria, $fluorescencia, $tratamiento, $calidad, $comentarios, $ubicacion, $subtotal, $total, $estado);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Gema agregado exitosamente.']);
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