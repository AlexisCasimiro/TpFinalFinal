<?php
include_once "../../configuracion.php";
include_once "../Estructura/nav.php";

// Creo los ABM
$abmCompra = new abmCompra();
$abmCompraEstado = new abmCompraEstado();
$abmCompraItem = new abmCompraItem();
$abmProducto = new abmProducto();
$abmUsuario = new abmUsuario();

// Obtengo todas las compras
$compras = $abmCompra->buscar(null);

?>

<div class="container mt-5">
    <h2 class="mb-4 text-center text-primary">Administración de Compras</h2>
    <?php if (!empty($compras)): ?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Cliente</th>
                        <th>Productos</th>
                        <th>Estado Actual</th>
                        <th>Fechas de Estados</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($compras as $compra): 
                        $idcompra = $compra->getId();
                        $compraEstados = $abmCompraEstado->buscar(['idcompra' => $idcompra]);
                        $items = $abmCompraItem->buscar(['idcompra' => $idcompra]);
                        $cliente = $abmUsuario->buscar(['idusuario' => $compra->getUsuario()->getId()]);
                        $productos = [];

                        foreach ($items as $item) {
                            $producto = $abmProducto->buscar(['idproducto' => $item->getObjProducto()->getIdProducto()]);
                            if (!empty($producto)) {
                                $productos[] = $producto[0]->getNombre() . ' x' . $item->getCantidad();
                            }
                        }

                        // Validar que haya estados antes de acceder al estado actual
                        $estadoActual = !empty($compraEstados) ? end($compraEstados) : null;
                        $estadoDescripcion = $estadoActual ? $estadoActual->getObjCompraEstadoTipo()->getDescripcion() : 'Sin estado';
                        $estadoTipo = $estadoActual ? $estadoActual->getObjCompraEstadoTipo()->getId() : null;
                    ?>
                        <?php if ($estadoTipo != 5): // No mostrar la compra si está en estado Carrito ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cliente[0]->getNombre()); ?></td>
                            <td><?php echo htmlspecialchars(implode(", ", $productos)); ?></td>
                            <td><?php echo htmlspecialchars($estadoDescripcion); ?></td>
                            <td>
                                <?php if (!empty($compraEstados)): ?>
                                    <?php foreach ($compraEstados as $estado): ?>
                                        <div><?php echo htmlspecialchars($estado->getObjCompraEstadoTipo()->getDescripcion() . ": " . $estado->getFechaInicio()); ?></div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                    <?php if ($estadoTipo == 1): // Si está iniciada ?>
                                        <form action="modificarEstado.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="idcompra" value="<?php echo htmlspecialchars($idcompra); ?>">
                                            <input type="hidden" name="nuevoEstado" value="2">
                                            <button type="submit" class="btn btn-primary">Aceptar</button>
                                        </form>
                                        <form action="cancelarCompra.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="idcompra" value="<?php echo htmlspecialchars($idcompra); ?>">
                                        </form>
                                    <?php elseif ($estadoTipo == 2): // Si está aceptada ?>
                                        <form action="modificarEstado.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="idcompra" value="<?php echo htmlspecialchars($idcompra); ?>">
                                            <input type="hidden" name="nuevoEstado" value="3">
                                            <button type="submit" class="btn btn-success">Enviar</button>
                                        </form>
                                        <form action="cancelarCompra.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="idcompra" value="<?php echo htmlspecialchars($idcompra); ?>">
                                        </form>
                                    <?php endif; ?>
                                    <?php if ($estadoTipo != 3 && $estadoTipo != 4): // No permitir cancelar si ya fue enviada o cancelada ?>
                                        <button class="btn btn-danger cancelarCompra" data-idcompra="<?php echo htmlspecialchars($idcompra); ?>">Cancelar</button>
                                    <?php else: ?>
                                        <button class="btn btn-secondary" disabled>No disponible</button>
                                    <?php endif; ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            No hay compras registradas.
        </div>
    <?php endif; ?>
</div>

<!-- Modal de confirmación de cancelación -->
<div class="modal fade" id="confirmCancelModal" tabindex="-1" aria-labelledby="confirmCancelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmCancelLabel">Confirmar Cancelación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas cancelar esta compra?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="confirmCancelBtn">Sí, cancelar</button>
            </div>
        </div>
    </div>
</div>

<?php
include_once "../Estructura/footer.php";
?>
<script src="../Js/depositoCancelarCompra.js"></script>
