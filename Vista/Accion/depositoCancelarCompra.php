<?php
include_once "../../configuracion.php";
$datos = data_submitted();
$response = false;

if (isset($datos['idcompra'])) {
    $idcompra = $datos['idcompra'];

    $abmCompraEstado = new abmCompraEstado();

    $response = $abmCompraEstado->cancelarCompra($idcompra);
}

echo json_encode($response);
?>
