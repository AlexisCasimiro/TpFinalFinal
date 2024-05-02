<?php
include_once "../../configuracion.php";
$datos=data_submitted();
$eliminado=false;
$abmProducto=new AbmProducto();

if (isset($datos['idproducto'])) {
    $producto= $abmProducto->buscar($datos)[0];
    var_dump($producto);
    $imagenProducto=$producto->getImagen();
    $rutaImagen="../imagenes/".$imagenProducto;
    if(unlink($rutaImagen)){
        if($abmProducto->baja($datos)){
            $eliminado=true;
        }
    }
}
if($eliminado){
    header('Location: '. $PROYECTOROOT . "Vista/Deposito/administrarProductos.php?correcto=1");
}else{
    header('Location: '. $PROYECTOROOT . "Vista/Deposito/administrarProductos.php?error=1");
}