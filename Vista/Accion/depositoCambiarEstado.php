<?php
include_once "../../configuracion.php";
$datos = data_submitted();
$response =  false;

if (isset($datos['idcompra']) && isset($datos['nuevoEstado'])) {
    $idcompra = $datos['idcompra'];
    $nuevoEstado = $datos['nuevoEstado'];
    
    // Crear instancias de los ABM necesarios
    $abmCompraEstado = new abmCompraEstado();
    $response = $abmCompraEstado->actualizarEstado($idcompra,$nuevoEstado);
}

echo json_encode($response);
?>
