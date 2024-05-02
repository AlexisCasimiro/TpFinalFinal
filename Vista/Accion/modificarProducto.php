<?php 
include_once "../../configuracion.php";
$datos=data_submitted();
$resp=false;

$abmProducto=new AbmProducto();

if (isset($datos['idproducto']) && isset($datos['pronombre']) && isset($datos['prodetalle']) && isset($datos['procantstock']) && isset($datos['proprecio'])) {
    $nombreImagen=$datos['pronombre'];
    $detalleImagen=$datos['prodetalle'];
    $cantStockImagen=$datos['procantstock'];
    $precioImagen=$datos['proprecio'];
    
    // Obtener la imagen actual y su ruta
    $imagenActual = $datos['nombreimagen'];
    $rutaImagenActual = "../imagenes/" . $imagenActual;

    // Verificar si se ha subido una nueva imagen
    if (!empty($_FILES['proimagen']['name'])) {
        // Si hay una nueva imagen, eliminar la imagen anterior si existe
        if (file_exists($rutaImagenActual)) {
            unlink($rutaImagenActual); // Eliminar la imagen anterior
        }

        // Procesar la nueva imagen 
        $nombreArchivoNuevo = $_FILES['proimagen']['name'];
        $rutaImagenNueva = "../imagenes/" . $nombreArchivoNuevo;
        move_uploaded_file($_FILES['proimagen']['tmp_name'], $rutaImagenNueva);

        // Asignar el nombre de la nueva imagen al campo correspondiente en la base de datos
        $datos['proimagen'] = $nombreArchivoNuevo;
    }else{
        $datos['proimagen']=$imagenActual;
    }

    //actualizo los datos del producto en la base de datos
    if($abmProducto->modificacion($datos)){
        $resp=true;
    }
}

echo json_encode($resp);
?>