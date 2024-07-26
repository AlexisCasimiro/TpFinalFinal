<?php
include_once "../../configuracion.php";
$datos = data_submitted();

$response = ['success' => false, 'message' => 'Solicitud inválida'];

if (isset($datos['idproducto']) && isset($datos['cantidad'])) {
    $idproducto = $datos['idproducto'];
    $nuevaCantidad = $datos['cantidad'];

    $idusuario = $_SESSION['idusuario'];

    // Creo instancias Abm
    $abmCompra = new abmCompra();
    $abmCompraEstado = new abmCompraEstado();
    $abmCompraItem = new abmCompraItem();
    $abmProducto = new abmProducto();

    // Obtener el producto y luego validar la cantidad
    $producto = $abmProducto->buscar(['idproducto' => $idproducto])[0];
    $stockDisponible = $producto->getCantStock();

    if ($nuevaCantidad > $stockDisponible) {
        $response['message'] = 'Cantidad supera el stock disponible';
    } else {
        // Obtener las compras en estado "carrito" del usuario
        $compras = $abmCompra->buscar(['idusuario' => $idusuario]);
        $ultimaCompra = end($compras);

        if ($ultimaCompra) {
            $idcompra = $ultimaCompra->getId();
            // Obtener el item de la compra correspondiente al producto
            $items = $abmCompraItem->buscar(['idcompra' => $idcompra, 'idproducto' => $idproducto]);
            if (!empty($items)) {
                $paramItem = [];
                $item = $items[0];
                $item->setCantidad($nuevaCantidad);
                $paramItem['idcompraitem'] = $item->getId();
                $paramItem['idcompra'] = $item->getObjCompra()->getId();
                $paramItem['idproducto'] = $item->getObjProducto()->getIdProducto();
                $paramItem['cicantidad'] = $item->getCantidad();
                $abmCompraItem->modificacion($paramItem);

                $response = ['success' => true];
            } else {
                $response['message'] = 'Item no encontrado';
            }
        } else {
            $response['message'] = 'Compra en estado carrito no encontrada';
        }
    }
}

echo json_encode($response);