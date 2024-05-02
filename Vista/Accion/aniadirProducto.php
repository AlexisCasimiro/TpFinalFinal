<?php
include_once "../../configuracion.php";
$datos=data_submitted();
$resp=false;

$abmProducto=new AbmProducto();
if (isset($datos['idproducto']) && isset($datos['pronombre']) && isset($datos['prodetalle']) && isset($datos['procantstock']) && isset($datos['proprecio']) && isset($_FILES['proimagen'])) {
    // Procesar la imagen 
    $nombreArchivoNuevo = $_FILES['proimagen']['name'];
    $rutaImagenNueva = "../imagenes/" . $nombreArchivoNuevo;
    move_uploaded_file($_FILES['proimagen']['tmp_name'], $rutaImagenNueva);
    $datos['proimagen']=$_FILES['proimagen']['name'];
    var_dump($datos);
    if($abmProducto->alta($datos)){
        $resp=true;
    }
}

echo json_encode($resp);