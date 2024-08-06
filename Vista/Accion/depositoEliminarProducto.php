<?php
include_once "../../configuracion.php";
$datos = data_submitted();
$response = ['success' => false, 'message' => 'Solicitud inválida.'];

if (isset($datos['idcompra']) && isset($datos['idproducto'])) {
    $idcompra = $datos['idcompra'];
    $idproducto = $datos['idproducto'];
    
    // Crear instancia del ABM correspondiente
    $abmCompraItem = new AbmCompraItem();
    $abmCompraEstado = new AbmCompraEstado();
    $abmProducto = new AbmProducto();
    
    // Buscar el ítem de compra específico
    $compraItem = $abmCompraItem->buscar(['idcompra' => $idcompra, 'idproducto' => $idproducto]);
    
    if (!empty($compraItem)) {
        // Eliminar el producto de la compra
        if ($abmCompraItem->baja(['idcompraitem'=>$compraItem[0]->getId(), 'idproducto'=>$idproducto, 'idcompra'=>$idcompra,'cicantidad'=>$compraItem[0]->getCantidad()])) {
            //si no hay más productos se cancela la compra
            // Devolver stock
            $producto = $abmProducto->buscar(['idproducto' => $idproducto]);
            if (!empty($producto)) {
                $producto = $producto[0];
                // Sumar el stock de los productos
                $sumarStock = ($producto->getCantStock() + $compraItem[0]->getCantidad());
                $abmProducto->modificacionStock(['idproducto' => $idproducto, 'procantstock' => $sumarStock]);
            }  
                
            $hayProductos = $abmCompraItem->buscar(['idcompra' => $idcompra]);
            if(empty($hayProductos)){
                // Se finaliza el ultimo estado de la compra y se crea el nuevo que seria cancelada
                $compraEstados = $abmCompraEstado->buscar(['idcompra' => $idcompra]);
                $estadoActual = !empty($compraEstados) ? end($compraEstados) : null;
                if($estadoActual){
                    $paramEstadoActual = [
                        'idcompraestado' => $estadoActual->getId(),
                        'cefechafin' => date('Y-m-d H:i:s')
                    ];
                    $abmCompraEstado->finalizar($paramEstadoActual);
                    $estadoActualId = $estadoActual->getObjCompraEstadoTipo()->getId();
                    // Crear el nuevo estado de la compra
                    $param = [
                        'idcompra' => $idcompra,
                        'idcompraestadotipo' => 4,
                        'cefechaini' => date("Y-m-d H:i:s"),
                        'cefechafin' => null,
                    ];
                    if ($abmCompraEstado->alta($param)) {
                        $response = ['success' => true, 'message' => 'Estado de la compra actualizado exitosamente.'];
                    }
                }
            } else {
                $response['message'] = 'No se pudo eliminar el producto de la compra.';
            }
            
            $response = ['success' => true, 'message' => 'Producto eliminado exitosamente de la compra.'];
        } else {
            $response['message'] = 'Producto no encontrado en la compra.';
        }
    }
}

echo json_encode($response);
?>