<?php
include_once "../../configuracion.php";
$datos=data_submitted();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($datos['idproducto']) && isset($datos['cantidad'])) {
    $idproducto = $datos['idproducto'];
    $nuevaCantidad = $datos['cantidad'];

    $idusuario = $_SESSION['idusuario'];

    // Creo instancias Abm
    $abmCompra = new abmCompra();
    $abmCompraEstado = new abmCompraEstado();
    $abmCompraItem = new abmCompraItem();
    $abmProducto = new abmProducto();

    // obtengo el producto y luego valido la cantidad
    $producto = $abmProducto->buscar(['idproducto' => $idproducto]);
    if (empty($producto)) {
        echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
        exit;
    }
    $producto = $producto[0];
    $stockDisponible = $producto->getCantStock();

    if ($nuevaCantidad > $stockDisponible) {
        echo json_encode(['success' => false, 'message' => 'Cantidad supera el stock disponible']);
        exit;
    }

    // Obtener la compra en estado "carrito" del usuario
    $compras = $abmCompra->buscar(['idusuario' => $idusuario]);
    if (!empty($compras)) {
        foreach ($compras as $compra) {
            $idcompra = $compra->getId();
            $compraEstados = $abmCompraEstado->buscar(['idcompra' => $idcompra, 'idcompraestadotipo' => 5]);
            if (!empty($compraEstados)) {
                // Obtener el item de la compra correspondiente al producto
                $items = $abmCompraItem->buscar(['idcompra' => $idcompra, 'idproducto' => $idproducto]);
                if (!empty($items)) {
                    $paramItem=[];
                    $item = $items[0];
                    $item->setCantidad($nuevaCantidad);
                    $paramItem['idcompraitem']=$item->getId();
                    $paramItem['idcompra']=$item->getObjCompra()->getId();
                    $paramItem['idproducto']=$item->getObjProducto()->getIdProducto();
                    $paramItem['cicantidad']=$item->getCantidad();
                    //if(isset($datos['idcompraitem'],$datos['idproducto'],$datos['idcompra'],$datos['cicantidad'])){
                    $abmCompraItem->modificacion($paramItem);
                }
                break;
            }
        }
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
