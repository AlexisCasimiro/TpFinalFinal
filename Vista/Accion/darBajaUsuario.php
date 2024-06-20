<?php
include_once "../../configuracion.php";
$datos=data_submitted();
var_dump($datos);
$response=false;
if (isset($datos['idusuario'])) {
    $abmUsuario = new AbmUsuario;
    if ($abmUsuario->baja($datos)) {
        $response=true;
    } else {
        $response=false;
    }
}
// Devolver respuesta en formato JSON
echo json_encode($response);
exit;
?>