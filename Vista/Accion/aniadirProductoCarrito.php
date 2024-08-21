<?php 
include_once "../../configuracion.php";
$datos = data_submitted();
$abmCompraEstado = new AbmCompraEstado();

if (isset($datos['idproducto'])) {
    $idUsuario = $_SESSION['idusuario'];
    $idProducto = $datos['idproducto'];

    $resp = $abmCompraEstado->manejarCarrito($idUsuario, $idProducto);

    if ($resp) {
        header('Location: ' . $PROYECTOROOT . "Vista/Cliente/carrito.php?correcto=1");
    } else {
        header('Location: ' . $PROYECTOROOT . "Vista/Cliente/carrito.php?error=1");
    }
}