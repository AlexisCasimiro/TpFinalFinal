<?php
include_once "../../configuracion.php";
include_once "../Estructura/nav.php";
// Verificar si hay un parámetro de error en la URL
$error=isset($_GET['error']) ? $_GET['error'] : null;
$correcto=isset($_GET['correcto']) ? $_GET['correcto'] : null;
if ($error) {
    echo "<div class='alert alert-danger alert-dismissible' role='alert'>
    <div>No se pudo agregar el producto al carrito</div>
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}
if($correcto){
    echo "<div class='alert alert-success alert-dismissible' role='alert'>
    <div>Se agrego correctamente el producto al carrito</div>
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}
// Crear instancias de las clases ABM
$abmCompra = new abmCompra();
$abmCompraEstado = new abmCompraEstado();
$abmCompraItem = new abmCompraItem();
$abmProducto = new abmProducto();

// Obtener las compras del usuario
$compras = $abmCompra->buscar(['idusuario' => $_SESSION['idusuario']]);
$productos = [];

if (!empty($compras)) {
    foreach ($compras as $compra) {
        $idcompra = $compra->getId();
        // Verificar el estado de la compra
        $compraEstados = $abmCompraEstado->buscar(['idcompra' => $idcompra, 'idcompraestadotipo' => 5]);
        if (!empty($compraEstados)) {
            // Obtener los items de la compra
            $items = $abmCompraItem->buscar(['idcompra' => $idcompra]);
            foreach ($items as $item) {
                $idproducto = $item->getObjProducto()->getIdProducto();
                $producto = $abmProducto->buscar(['idproducto' => $idproducto]);
                if (!empty($producto)) {
                    $productos[] = [
                        'idproducto' => $producto[0]->getIdProducto(),
                        'pronombre' => $producto[0]->getNombre(),
                        'prodetalle' => $producto[0]->getDetalle(),
                        'cicantidad' => $item->getCantidad(),
                    ];
                }
            }
        }
    }
}

?>

<div class="container mt-5">
    <h2>Carrito de Compras</h2>
    <?php if (count($productos) > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['pronombre']); ?></td>
                        <td><?php echo htmlspecialchars($producto['prodetalle']); ?></td>
                        <td><?php echo htmlspecialchars($producto['cicantidad']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">El carrito está vacío.</div>
    <?php endif; ?>
</div>



<?php
include_once "../Estructura/footer.php";
?>