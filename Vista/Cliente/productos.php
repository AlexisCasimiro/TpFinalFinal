<?php
include_once "../../configuracion.php";
include_once "../Estructura/nav.php";
$abmProducto= new AbmProducto();
$colProductos= $abmProducto->buscar(null);
?>

<div class="d-flex justify-content-center align-items-center mt-4 mb-4">
    <div class="container-fluid bg-gris">
        <div class="row justify-content-center">
            <?php
            if (count($colProductos) > 0) {
                foreach ($colProductos as $unProducto) {
                    $hayStock = $unProducto->getCantStock() !== 0;
                    echo "<div class='col-12 col-md-3 col-lg-2 p-3'>
                            <div class='card border-light h-100'>
                                <img src='../Imagenes/" . $unProducto->getImagen() . "' class='card-img-top' alt='imagen " . $unProducto->getNombre() . "'>
                                <div class='card-body'>
                                    <h3 class='card-title fs-4'>" . $unProducto->getNombre() . "</h3>
                                    <p class='card-text mb-0'>" . $unProducto->getDetalle() . "</p>
                                    <p class='card-text mb-0 fs-4 text-primary fw-bold'>$" . $unProducto->getPrecio() . " US</p>
                                    <div class='text-center'>
                                        <form method='post' action='../Accion/aniadirProductoCarrito.php'>
                                            <input type='hidden' name='idproducto' id='idproducto' value='" . $unProducto->getIdProducto() . "'>
                                            <button type='submit' " . ($hayStock ? "" : "disabled") . " class='btn btn-" . ($hayStock ? "success" : "danger") . " col-12 fs-5'>" . ($hayStock ? "<i class='fa fa-shopping-cart me-2' aria-hidden='true'></i> Añadir al carrito" : "Sin stock") . "</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>";
                }
            } else {
                echo "<h3 class='text-center text-danger'>No hay productos</h3><br><br><br><br><br>";
            }
            ?>
        </div>
    </div>
</div>
<?php
include_once "../Estructura/footer.php";
?>