<?php 
include_once "../../configuracion.php";
$datos = data_submitted();

if (isset($datos['idcompra'])) {
    $idcompra = $datos['idcompra'];
    $abmCompraEstado = new abmCompraEstado();
    $resultado = $abmCompraEstado->finalizarCompra($idcompra);

    if ($resultado === true) {
        header("Location: ../Cliente/ComprasCliente.php");
        exit;
    } elseif (is_array($resultado) && $resultado['error'] === 'stock') {
        header("Location: ../Cliente/carrito.php?productoerror=" . $resultado['producto']->getIdProducto());
    } else {
        header("Location: ../Cliente/carrito.php?error=1");
        exit;
    }
} else {
    header("Location: ../Cliente/carrito.php?error=1");
    exit;
}
