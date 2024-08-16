<?php
include_once "../../configuracion.php";
$datos = data_submitted();
$response = ['success' => false, 'message' => 'Solicitud inválida.'];

if (isset($datos['idcompra'])) {
    $idcompra = $datos['idcompra'];

    $abmCompra = new abmCompra();
    $abmCompraEstado = new abmCompraEstado();
    $abmCompraItem = new abmCompraItem();
    $abmProducto = new abmProducto();

    // busco la compra del usuario
    $compra = $abmCompra->buscar(['idcompra' => $idcompra]);
    if (!empty($compra)) {
        $compra = $compra[0];
        $compraEstados = $abmCompraEstado->buscar(['idcompra' => $idcompra]); // Estado iniciada
        if (!empty($compraEstados)) {
            $estadoIniciada = $compraEstados[0];
            // Actualizar la fecha de finalización del estado "iniciada"
            $paramEstadoIniciada = [
                'idcompraestado' => $estadoIniciada->getId(),
                'cefechafin' => date('Y-m-d H:i:s')
            ];
            $abmCompraEstado->finalizar($paramEstadoIniciada);

            // Parametros para cambiar el estado de la compra a "cancelada"
            $paramEstado = [
                'idcompra' => $idcompra,
                'idcompraestadotipo' => 4, // Estado cancelada
                'cefechaini' => date('Y-m-d H:i:s'),
                'cefechafin' => null
            ];

            if ($abmCompraEstado->alta($paramEstado)) {
                // Obtener los items de la compra
                // lo qeu esta haciendo es sumarle un producto a la compra, no está devolviendo el stock del producto 
                $items = $abmCompraItem->buscar(['idcompra' => $idcompra]);
                if (!empty($items)) {
                    foreach ($items as $item) {
                        $producto = $abmProducto->buscar(['idproducto' => $item->getObjProducto()->getIdProducto()]);
                        if (!empty($producto)) {
                            $producto = $producto[0];
                            // Sumar el stock de los productos
                            $sumarStock = ($producto->getCantStock() + $item->getCantidad());
                            // esto está raro
                            $abmProducto->modificacionStock(['idproducto' => $item->getObjProducto()->getIdProducto(), 'procantstock' => $sumarStock]);
                        }
                    }
                    
                }
                // Logica para el envio de mail 
                $objCompra = $abmCompra->buscar(['idcompra'=>$idcompra])[0];
                $mail = new Mailer();
                $mail->mandarMail($objCompra);
                $response = ['success' => true];
            } else {
                $response['message'] = 'No se pudo cancelar la compra.';
            }
        } else {
            $response['message'] = 'La compra no está en estado iniciada.';
        }
    } else {
        $response['message'] = 'Compra no encontrada.';
    }
}

echo json_encode($response);
?>
