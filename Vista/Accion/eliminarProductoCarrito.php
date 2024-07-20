<?php
include_once "../../configuracion.php";
$datos = data_submitted();

if (isset($datos['idproducto'])) {
    $idproducto = $datos['idproducto'];
    $idusuario = $_SESSION['idusuario'];

    $abmCompra = new abmCompra();
    $abmCompraEstado = new abmCompraEstado();
    $abmCompraItem = new abmCompraItem();

    $compras = $abmCompra->buscar(['idusuario' => $idusuario]);
    if (!empty($compras)) {
        foreach ($compras as $compra) {
            $idcompra = $compra->getId();
            $compraEstados = $abmCompraEstado->buscar(['idcompra' => $idcompra, 'idcompraestadotipo' => 5]);
            if (!empty($compraEstados)) {
                $items = $abmCompraItem->buscar(['idcompra' => $idcompra, 'idproducto' => $idproducto]);
                if (!empty($items)) {
                    $item = $items[0];
                    $paramItem['idcompraitem']=$item->getId();
                    $paramItem['idcompra']=$item->getObjCompra()->getId();
                    $paramItem['idproducto']=$item->getObjProducto()->getIdProducto();
                    $paramItem['cicantidad']=$item->getCantidad();
                    $abmCompraItem->baja($paramItem);
                    //if(isset($datos['idcompraitem'],$datos['idproducto'],$datos['idcompra'],$datos['cicantidad'])){
                    echo json_encode(['success' => true]);
                    exit;
                }
                break;
            }
        }
    }

    echo json_encode(['success' => false, 'message' => 'Producto no encontrado en el carrito']);
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud inválida']);
}
?>
