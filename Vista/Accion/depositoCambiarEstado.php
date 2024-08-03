<?php
include_once "../../configuracion.php";
$datos = data_submitted();
$response = ['success' => false, 'message' => 'Solicitud inválida.'];

if (isset($datos['idcompra']) && isset($datos['nuevoEstado'])) {
    $idcompra = $datos['idcompra'];
    $nuevoEstado = $datos['nuevoEstado'];
    
    // Crear instancias de los ABM necesarios
    $abmCompraEstado = new abmCompraEstado();
    $abmCompra = new abmCompra();

    // Buscar la compra y su estado actual
    $compra = $abmCompra->buscar(['idcompra' => $idcompra]);
    if (!empty($compra)) {
        $compraEstados = $abmCompraEstado->buscar(['idcompra' => $idcompra]);
        $estadoActual = !empty($compraEstados) ? end($compraEstados) : null;
        

        if ($estadoActual) {
            // Actualizar la fecha de finalización del estado actual
            $paramEstadoIniciada = [
                'idcompraestado' => $estadoActual->getId(),
                'cefechafin' => date('Y-m-d H:i:s')
            ];
            $abmCompraEstado->finalizar($paramEstadoIniciada);

            $estadoActualId = $estadoActual->getObjCompraEstadoTipo()->getId();
            // Crear el nuevo estado de la compra
            $param = [
                'idcompra' => $idcompra,
                'idcompraestadotipo' => $nuevoEstado,
                'cefechaini' => date("Y-m-d H:i:s"),
                'cefechafin' => null,
            ];
            if ($abmCompraEstado->alta($param)) {
                $response = ['success' => true, 'message' => 'Estado de la compra actualizado exitosamente.'];
            } else {
                $response['message'] = 'No se pudo actualizar el estado de la compra.';
            }
        } else {
            $response['message'] = 'No se encontró un estado válido para la compra.';
        }
    } else {
        $response['message'] = 'Compra no encontrada.';
    }
}

echo json_encode($response);
?>
