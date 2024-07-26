<?php
include_once "../../configuracion.php";
include_once "../Estructura/nav.php";

// Verificar si hay un parámetro de error en la URL
$error = isset($_GET['error']) ? $_GET['error'] : null;
$correcto = isset($_GET['correcto']) ? $_GET['correcto'] : null;
$productoerror = isset($_GET['productoerror']) ? $_GET['productoerror'] : null;
if ($error) {
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Error:</strong> No se pudo agregar el producto al carrito.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}
if ($correcto) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Éxito:</strong> Se agregó correctamente el producto al carrito.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}
if(isset($productoerror)){
    $controlProducto=new AbmProducto();
    $idProductoSinStock=$_GET['productoerror'];
    $productoSinStock=$controlProducto->buscar(['idproducto'=>$idProductoSinStock]);
    var_dump($productoSinStock[0]);
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Sin stock:</strong> No hay suficiente stock para el producto: " . $productoSinStock[0]->getNombre() . ".
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
}
// Creo los ABM
$abmCompra = new abmCompra();
$abmCompraEstado = new abmCompraEstado();
$abmCompraItem = new abmCompraItem();
$abmProducto = new abmProducto();

// Obtengo la compra en estado carrito que tiene el cliente
$compras = $abmCompra->buscar(['idusuario' => $_SESSION['idusuario']]);
$productos = [];
$totalCarrito = 0;

if (!empty($compras)) {
    foreach ($compras as $compra) {
        $idcompra = $compra->getId();
        // Verificar el estado de la compra
        $compraEstados = $abmCompraEstado->buscar(['idcompra' => $idcompra]);
        if (!empty($compraEstados) && (count($compraEstados) == 1)) {
            // Obtener los items de la compra
            $items = $abmCompraItem->buscar(['idcompra' => $idcompra]);
            foreach ($items as $item) {
                $idproducto = $item->getObjProducto()->getIdProducto();
                $producto = $abmProducto->buscar(['idproducto' => $idproducto]);
                if (!empty($producto)) {
                    $producto = $producto[0];
                    $cantidad = $item->getCantidad();
                    $precioTotal = $producto->getPrecio() * $cantidad;
                    $totalCarrito += $precioTotal;
                    $productos[] = [
                        'idcompraitem' => $item->getId(),
                        'idproducto' => $producto->getIdProducto(),
                        'pronombre' => $producto->getNombre(),
                        'prodetalle' => $producto->getDetalle(),
                        'proimagen' => $producto->getImagen(),
                        'precio' => $producto->getPrecio(),
                        'cicantidad' => $cantidad,
                        'precioTotal' => $precioTotal,
                        'stock' => $producto->getCantStock(),
                    ];
                }
            }
        }
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center text-primary">Carrito de Compras</h2>
    <?php if (count($productos) > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Descripción</th>
                        <th>Imagen</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Precio Total</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo ($producto['pronombre']); ?></td>
                            <td><?php echo ($producto['prodetalle']); ?></td>
                            <td><img src="../imagenes/<?php echo ($producto['proimagen']); ?>" alt="<?php echo ($producto['pronombre']); ?>" class="img-fluid rounded" style="max-width: 100px;"></td>
                            <td><?php echo number_format($producto['precio'], 2); ?> €</td>
                            <td>
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary restarCantidad" type="button" data-idproducto="<?php echo ($producto['idproducto']); ?>">-</button>
                                    <input type="number" name="cantidad" min="1" value="<?php echo ($producto['cicantidad']); ?>" class="form-control text-center cantidad-input" data-idproducto="<?php echo ($producto['idproducto']); ?>" max="<?php echo ($producto['stock']); ?>" readonly>
                                    <button class="btn btn-outline-secondary sumarCantidad" type="button" data-idproducto="<?php echo ($producto['idproducto']); ?>">+</button>
                                </div>
                            </td>
                            <td class="precio-total"><?php echo number_format($producto['precioTotal'], 2); ?> €</td>
                            <td>
                                <button class="btn btn-danger eliminarProducto" data-idproducto="<?php echo ($producto['idproducto']); ?>"><i class="bi bi-x-lg"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="6" class="text-end"><strong>Total del Carrito:</strong></td>
                        <td><strong id="total-carrito"><?php echo number_format($totalCarrito, 2); ?> €</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Botón para finalizar la compra -->
        <div class="text-end mt-3">
            <button onclick="location.href='./productos.php'" class="btn btn-primary">Ir a tienda</button>
            <form action="../Accion/finalizarCompra.php" method="post" style="display: inline;">
                <input type="hidden" name="idcompra" value="<?php echo $idcompra; ?>">
                <button type="submit" class="btn btn-success">Finalizar Compra</button>
            </form>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            El carrito está vacío.
            <br><br>
            <a href="./productos.php" class="btn btn-primary"><i class="bi bi-arrow-right-circle"></i> Ver productos</a>
        </div>
    <?php endif; ?>
</div>

<?php
include_once "../Estructura/footer.php";
?>

<script src="../Js/cambiarStockCarrito.js"></script>
<script src="../Js/eliminarProductoCarro.js"></script>