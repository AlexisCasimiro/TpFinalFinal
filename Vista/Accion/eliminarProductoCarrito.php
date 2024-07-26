<?php
include_once "../../configuracion.php";
$datos = data_submitted();

$response = ['success' => false, 'message' => 'Solicitud inválida'];

if (isset($datos['idproducto'])) {
    $idproducto = $datos['idproducto'];
    $idusuario = $_SESSION['idusuario'];

    $abmCompra = new abmCompra();
    $abmCompraEstado = new abmCompraEstado();
    $abmCompraItem = new abmCompraItem();

    $compras = $abmCompra->buscar(['idusuario' => $idusuario]);
    $ultimaCompra = end($compras);

    if (!empty($ultimaCompra)) {
        $idcompra = $ultimaCompra->getId();
        $compraEstados = $abmCompraEstado->buscar(['idcompra' => $idcompra, 'idcompraestadotipo' => 5]);
        if (!empty($compraEstados)) {
            $items = $abmCompraItem->buscar(['idcompra' => $idcompra, 'idproducto' => $idproducto]);
            if (!empty($items)) {
                $item = $items[0];
                $paramItem['idcompraitem'] = $item->getId();
                $paramItem['idcompra'] = $item->getObjCompra()->getId();
                $paramItem['idproducto'] = $item->getObjProducto()->getIdProducto();
                $paramItem['cicantidad'] = $item->getCantidad();
                $abmCompraItem->baja($paramItem);
                
                $response = ['success' => true];
            } else {
                $response['message'] = 'Producto no encontrado en el carrito';
            }
        } else {
            $response['message'] = 'No hay compras en estado carrito';
        }
    } else {
        $response['message'] = 'No se encontró ninguna compra para el usuario';
    }
}

echo json_encode($response);
?>
