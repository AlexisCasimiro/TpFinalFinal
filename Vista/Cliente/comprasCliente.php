<?php
include_once "../../configuracion.php";
include_once "../Estructura/nav.php";

// Creo los ABM
$abmCompra = new abmCompra();
$abmCompraEstado = new abmCompraEstado();
$abmCompraItem = new abmCompraItem();
$abmProducto = new abmProducto();

// Obtengo las compras del usuario
$idusuario = $_SESSION['idusuario'];
$compras = $abmCompra->buscar(['idusuario' => $idusuario]);
$comprasFiltradas = [];

// Filtrar las compras por estado
if (!empty($compras)) {
    foreach ($compras as $compra) {
        $idcompra = $compra->getId();
        $compraEstados = $abmCompraEstado->buscar(['idcompra' => $idcompra]);
        $productos = [];
        if (!empty($compraEstados)) {
            foreach ($compraEstados as $estado) {
                $estadoTipo = $estado->getObjCompraEstadoTipo()->getId();
                if (in_array($estadoTipo, [1, 2, 3, 4])) { // Estados: iniciada (1), aceptada (2), cancelada (3), enviada (4)
                    // Obtener los items de la compra
                    $items = $abmCompraItem->buscar(['idcompra' => $idcompra]);
                    foreach ($items as $item) {
                        $producto = $abmProducto->buscar(['idproducto' => $item->getObjProducto()->getIdProducto()]);
                        if (!empty($producto)) {
                            $productos[] = $producto[0]->getNombre() . ' x' . $item->getCantidad();
                        }
                    }

                    $comprasFiltradas[$idcompra]['idcompra'] = $idcompra;
                    $comprasFiltradas[$idcompra]['fecha'] = $compra->getCoFecha();
                    $comprasFiltradas[$idcompra]['estado'][$estadoTipo] = $estado->getFechaInicio();
                    $comprasFiltradas[$idcompra]['productos'] = implode(", ", $productos);
                    $comprasFiltradas[$idcompra]['estadoTipo'] = $estadoTipo;
                    $comprasFiltradas[$idcompra]['estadoDescripcion'] = $estado->getObjCompraEstadoTipo()->getDescripcion();
                }
            }
        }
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center text-primary">Mis Compras</h2>
    <?php if (!empty($comprasFiltradas)): ?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Productos</th>
                        <th>Fecha</th>
                        <th>Iniciada</th>
                        <th>Aceptada</th>
                        <th>Enviada</th>
                        <th>Cancelada</th>
                        <th>Estado actual</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comprasFiltradas as $compra): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($compra['productos']); ?></td>
                            <td><?php echo htmlspecialchars($compra['fecha']); ?></td>
                            <td><?php echo htmlspecialchars(isset($compra['estado'][1]) ? $compra['estado'][1] : ''); ?></td>
                            <td><?php echo htmlspecialchars(isset($compra['estado'][2]) ? $compra['estado'][2] : ''); ?></td>
                            <td><?php echo htmlspecialchars(isset($compra['estado'][4]) ? $compra['estado'][4] : ''); ?></td>
                            <td><?php echo htmlspecialchars(isset($compra['estado'][3]) ? $compra['estado'][3] : ''); ?></td>
                            <td><?php echo htmlspecialchars($compra['estadoDescripcion']); ?></td>
                            <td>
                                <?php if ($compra['estadoTipo'] == 1): // Estado iniciada ?>
                                    <button class="btn btn-danger cancelarCompra" data-idcompra="<?php echo htmlspecialchars($compra['idcompra']); ?>">Cancelar</button>
                                <?php else: ?>
                                    <button class="btn btn-secondary" disabled>No disponible</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            No tienes compras en los estados aceptada, cancelada, iniciada o enviada.
            <br><br>
            <a href="../productos.php" class="btn btn-primary"><i class="bi bi-arrow-right-circle"></i> Ver productos</a>
        </div>
    <?php endif; ?>
</div>

<?php
include_once "../Estructura/footer.php";
?>

<script>
$(document).ready(function() {
    $('.cancelarCompra').on('click', function() {
        const idcompra = $(this).data('idcompra');
        if (confirm('¿Estás seguro de que deseas cancelar esta compra?')) {
            $.ajax({
                type: 'POST',
                url: 'cancelarCompra.php',
                data: { idcompra: idcompra },
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.success) {
                        alert('Compra cancelada exitosamente');
                        location.reload();
                    } else {
                        alert('Error al cancelar la compra: ' + result.message);
                    }
                }
            });
        }
    });
});
</script>
