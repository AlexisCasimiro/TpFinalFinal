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

?>