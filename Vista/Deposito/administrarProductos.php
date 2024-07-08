<?php
include_once "../../configuracion.php";
include_once "../Estructura/nav.php";
$abmProducto = new AbmProducto();
$colProductos = $abmProducto->buscar(null);
$datos = data_submitted();
// Variable PHP inicialmente vacía
$idProductoBuscar['idproducto'] = "";
$activarModal = false;
$idProducto = "";
$nomProducto = "";
$detalleProducto = "";
$precioProducto = "";
$cantProducto = "";
$imagenProducto = "";

// Verifica si se ha enviado un valor mediante POST y actualiza la variable PHP
if (isset($_POST['idproducto'])) {
    $idProductoBuscar['idproducto'] = $_POST['idproducto'];
    $activarModal = true;
    $productoAbm = new AbmProducto();
    $producto = $productoAbm->buscar($idProductoBuscar)[0];
    $idProducto = $producto->getIdProducto();
    $nomProducto = $producto->getNombre();
    $detalleProducto = $producto->getDetalle();
    $precioProducto = $producto->getPrecio();
    $cantProducto = $producto->getCantStock();
    $imagenProducto = $producto->getImagen();
}
echo $idProductoBuscar['idproducto'];
var_dump($datos);

// Verificar si hay un parámetro de error en la URL
$error=isset($_GET['error']) ? $_GET['error'] : null;
$correcto=isset($_GET['correcto']) ? $_GET['correcto'] : null;
if ($error) {
    echo "<div class='alert alert-danger alert-dismissible' role='alert'>
    <div>No se pudo eliminar el producto</div>
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}
if($correcto){
    echo "<div class='alert alert-success alert-dismissible' role='alert'>
    <div>Se elimino el producto correctamente</div>
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}
?>

<div class="d-flex justify-content-center align-items-center mt-4 mb-4">
    <div class="container-fluid bg-gris">
        <div class="row justify-content-center">
            <?php
            if (count($colProductos) > 0) {
                foreach ($colProductos as $unProducto) {
                    echo "<div class='col-12 col-md-3 col-lg-2 p-3'>
                <div class='card border-light h-100'>
                        <img src='../Imagenes/" . $unProducto->getImagen() . "' class='card-img-top' alt='imagen " . $unProducto->getNombre() . "'>
                    <div class='card-body'>
                        <h3 class='card-title fs-4'>" . $unProducto->getNombre() . "</h3>
                        <p class='card-text mb-0'>" . $unProducto->getDetalle() . "</p>
                        <p class='card-text mb-0 fs-4 text-primary fw-bold'>$" . $unProducto->getPrecio() . " US</p>
                    <div class='text-center'>
                                <form method='post' action='" . $_SERVER['PHP_SELF'] . "' class='col-6'>
                                <input type='hidden' name='idproducto' id='idproducto' value='" . $unProducto->getIdProducto() . "'>
                                <button type='submit' class='btn btn-primary mt-1'>Modificar datos</button>
                                </form>
                                <form method='post' action='../Accion/eliminarProducto.php' class='col-6'>
                                    <input type='hidden' name='idproducto' id='idproducto' value='" . $unProducto->getIdProducto() . "'>
                                    <button type='submit' class='btn btn-danger mt-1'>Eliminar producto</button>
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

<!-- Modal para administrar producto -->
<div class="modal fade" id="administrarProductoModal" tabindex="-1" role="dialog" aria-labelledby="administrarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="administrarProductoModalLabel">Administrar Producto</h5>
                <button type="button" class="btn-close" onclick="esconderModal()" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de administración de producto ../Accion/modificarProducto.php-->
                <form method="post" id="edit-producto" action="../Accion/modificarProducto.php" enctype="multipart/form-data">
                    <!-- Campos del formulario -->
                    <!--Input del nombre -->
                    <div class="form-group">
                        <label for="nombreProducto">Nombre</label>
                        <input type="text" class="form-control" id="pronombre" name="pronombre" value='<?php echo $nomProducto; ?>'>
                        <div class='invalid-feedback'>
                            Debe ingresar un nombre valido
                        </div>
                    </div>
                    <!--Input del detalle -->
                    <div class="form-group">
                        <label for="detalleProducto">Detalle</label>
                        <input type="text" class="form-control" id="prodetalle" name="prodetalle" value='<?php echo $detalleProducto; ?>' >
                        <div class='invalid-feedback'>
                            Debe ingresar un detalle valido
                        </div>
                    </div>
                    <!--Input de la cantidad -->
                    <div class="form-group">
                        <label for="cantidadProducto">Cantidad en Stock</label><!--  HAY QUE CAMBIAR LOS NAME DE LOS IMPUT   -->
                        <input type="text" class="form-control" id="procantstock" name="procantstock" value='<?php echo $cantProducto; ?>' >
                        <div class='invalid-feedback'>
                            Debe ingresar una cantidad valida
                        </div>
                    </div>
                    <!--Input del precio -->
                    <div class="form-group">
                        <label for="precioProducto">Precio</label>
                        <input type="number" class="form-control" id="proprecio" name="proprecio" value='<?php echo $precioProducto; ?>' >
                        <div class='invalid-feedback'>
                            Debe ingresar un precio valido
                        </div>
                    </div>
                    <!--Input de la imagen -->
                    <div class='input-group mb-3 align-items-center'>
                        <div class='col-3 p-0 mt-2' style='display: inline-table;'>
                            <span class='input-group-text bg-secondary-emphasis border-0 rounded rounded-bottom-0 text-center d-block' >Imagen actual</span>
                            <img src="../imagenes/<?php echo $imagenProducto; ?>" alt="imagen <?php echo $imagenProducto; ?> " class='w-100'>
                        </div>
                        <input type='file' class='form-control ms-1' name='proimagen' id='proimagen' accept='.png,.jpg' aria-describedby='basic-addon5'>
                        <div class='invalid-feedback'>
                            La imagen debe ser en formato jpg o png
                        </div>
                    </div>
                    <!-- Otros campos del formulario -->
                    <input type="hidden" name="idproducto" id="idproducto" value="<?php echo $idProducto; ?>">
                    <input type='hidden' name='nombreimagen' id='nombreimagen' value="<?php echo $imagenProducto; ?>">
                    <!-- Botón para enviar el formulario -->
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para manejar la apertura del modal con el ID del producto -->
<script>
    $(document).ready(function() {
        <?php
        if ($activarModal) {
            echo "$('#administrarProductoModal').modal('show')";
        }
        ?>
    });

    function esconderModal() {
        $('#administrarProductoModal').modal('hide');
    }
</script>
<script src="../Js/editarProductoo.js"></script>
<?php
include_once "../Estructura/footer.php";
?>