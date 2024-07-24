<?php
include_once "../../configuracion.php";
$datos = data_submitted();

// Verifico si el ID de la compra está establecido
if (isset($datos['idcompra'])) {
    $idcompra = $datos['idcompra'];
    
    // Crear instancias de las clases ABM
    $abmCompraEstado = new abmCompraEstado();
    $abmCompraEstadoTipo = new abmCompraEstadoTipo();
    $abmCompraItem = new abmCompraItem();
    $abmProducto = new abmProducto();

    // Verifico si la compra existe y está en estado "carrito"
    $compraEstados = $abmCompraEstado->buscar(['idcompra' => $idcompra, 'idcompraestadotipo' => 5]);
    if (!empty($compraEstados)) {
        // Obtengo los items de la compra
        $items = $abmCompraItem->buscar(['idcompra' => $idcompra]);
        $stockSuficiente = true;

        // Verifico que haya stock suficiente para cada producto
        foreach ($items as $item) {
            $idproducto = $item->getObjProducto()->getIdProducto();
            $producto = $abmProducto->buscar(['idproducto' => $idproducto]);
            if (!empty($producto)) {
                $producto = $producto[0];
                $cantidad = $item->getCantidad();
                if ($producto->getCantStock() < $cantidad) {
                    $stockSuficiente = false;
                }
            } else {
                $stockSuficiente = false;
            }
        }

        if ($stockSuficiente) {
            // Cambiar el estado de la compra a "iniciada" (1)
            $nuevoEstado = [
                'idcompraestado' => 0,
                'idcompra' => $idcompra,
                'idcompraestadotipo' => 1,
                'cefechaini' => null,
                'cefechafin' => null
            ];
            //$controlCompraEstado->alta(['idcompraestado' => 0, 'idcompra' => $compra->getIdCompra(), 'idcompraestadotipo' => 1, 'cefechaini' => NULL, 'cefechafin' => NULL]);
            if ($abmCompraEstado->finalizar(['idcompraestado' => $compraEstados[0]->getId()], ['idusuario' => $_SESSION['idusuario']])) {
                if($abmCompraEstado->alta($nuevoEstado)){
                    // Resto el stock de los productos
                    foreach ($items as $item) {
                        $cantidadEnCarrito = $item->getCantidad();
                        $producto = $abmProducto->buscar(['idproducto' => $item->getObjProducto()->getIdProducto()])[0];
                        $stockActual = $producto->getCantStock();
                        $nuevoStock=$stockActual - $cantidadPedida;
                        //$producto->modificar();
                        $abmProducto->modificacionStock(['idproducto'=>$item->getObjProducto()->getIdProducto(), 'procantstock'=> $nuevoStock]);
                    }
                    // Redirigir al carrito con un mensaje de éxito
                    header("Location: ../Cliente/ComprasCliente.php");
                    exit;
                }
            }else{
                // Redirigir al carrito con un mensaje de error
                header("Location: ../Cliente/carrito.php?error=1");
                exit;
            }
        } else {
            // Redirigir al carrito con un mensaje de error por falta de stock
            header("Location: carrito.php?error=stock");
            exit;
        }
    } else {
        // Redirigir al carrito con un mensaje de error
        header("Location: carrito.php");
        exit;
    }
} else {
    // Redirigir al carrito con un mensaje de error
    header("Location: carrito.php?error=1");
    exit;
}
?>
