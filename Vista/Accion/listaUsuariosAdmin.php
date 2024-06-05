<?php 
include_once "../../configuracion.php";
$data = data_submitted();
$objControl = new AbmUsuario();
$list = $objControl->buscar(null);
$arreglo_salida = array();
foreach ($list as $elem){
    $nuevoElem = array();
    $nuevoElem['idusuario'] = $elem->getId(); // Asegúrate de usar el método correcto para obtener el ID
    $nuevoElem["usnombre"] = $elem->getNombre();
    $nuevoElem["usmail"] = $elem->getMail();
    $nuevoElem["usdeshabilitado"] = $elem->getDeshabilitado() ? 'No' : 'Sí';
    array_push($arreglo_salida, $nuevoElem);
}
var_dump($arreglo_salida);
//verEstructura($arreglo_salida);
echo json_encode($c, JSON_FORCE_OBJECT);

?>