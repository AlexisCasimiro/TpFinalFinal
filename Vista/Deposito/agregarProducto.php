<?php
include_once "../../configuracion.php";
include_once "../Estructura/nav.php";
?>
<div class="conteiner mb-5 mt-5">
    <!-- Formulario de administración de producto ../Accion/modificarProducto.php-->
    <form method="post" id="agregar-producto" action="../Accion/aniadirProducto.php" enctype="multipart/form-data" class="bg-light rounded p-4 col-md-4 mx-auto my-4">
        <h2>Agregar nuevo Producto</h2>
        <!-- Campos del formulario -->
        <!--Input del nombre -->
        <div class="form-group">
            <label for="nombreProducto">Nombre</label><!--  HAY QUE CAMBIAR LOS NAME DE LOS IMPUT   -->
            <input type="text" class="form-control" id="pronombre" name="pronombre">
            <div class='invalid-feedback'>
                Debe ingresar un nombre valido
            </div>
        </div>
        <!--Input del detalle -->
        <div class="form-group mt-2">
            <label for="detalleProducto">Detalle</label>
            <input type="text" class="form-control" id="prodetalle" name="prodetalle">
            <div class='invalid-feedback'>
                Debe ingresar un detalle valido
            </div>
        </div>
        <!--Input de la cantidad -->
        <div class="form-group mt-2">
            <label for="cantidadProducto">Cantidad en Stock</label><!--  HAY QUE CAMBIAR LOS NAME DE LOS IMPUT   -->
            <input type="number" class="form-control" id="procantstock" name="procantstock">
            <div class='invalid-feedback'>
                Debe ingresar una cantidad valida
            </div>
        </div>
        <!--Input del precio -->
        <div class="form-group mt-2">
            <label for="precioProducto">Precio</label>
            <input type="number" class="form-control" id="proprecio" name="proprecio">
            <div class='invalid-feedback'>
                Debe ingresar un precio valido
            </div>
        </div>
        <!--Input de la imagen -->
        <div class="form-group mt-2 mb-4">
            <label for="imagenProducto">Agregar Imagen del producto:</label>
            <input type='file' class='form-control ms-1' name='proimagen' id='proimagen' accept='.png,.jpg' aria-describedby='basic-addon5'>
            <div class='invalid-feedback'>
                La imagen debe ser en formato jpg o png
            </div>
        </div>
        <!-- Botón para enviar el formulario -->
        <input type="hidden" name="idproducto" id="idproducto" required value="0">
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
    <br><br><br><br>
</div>
<script src="../Js/agregarProductoo.js"></script>

<?php
include_once "../Estructura/footer.php";
?>