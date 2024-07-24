<?php
include_once "../../configuracion.php";
$datos = data_submitted();

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
        echo json_encode(['success' => false, 'message' => 'Cantidad supera el stock disponible']);
        exit;
    }

    // Obtener las compras en estado "carrito" del usuario
    $compras = $abmCompra->buscar(['idusuario' => $idusuario]);
    $ultimaCompra=end($compras);

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

            echo json_encode(['success' => true]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Item no encontrado']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Compra en estado carrito no encontrada']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud inválida']);
}
?>
