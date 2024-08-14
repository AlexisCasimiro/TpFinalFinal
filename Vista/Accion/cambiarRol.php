<?php
include_once "../../configuracion.php";
$datos = data_submitted();
$response = ['success' => false, 'message' => 'Solicitud inválida'];

if (isset($datos['rolNuevo'])) {
    $_SESSION['rolelegido'] = $datos['rolNuevo'];
    $response = ['success' => true, 'message' => 'Rol elegido actualizado correctamente'];
}

echo json_encode($response);
?>
