<?php
include_once "../../configuracion.php";

$objUsuarioRol = new AbmUsuarioRol();
$datos=data_submitted();
var_dump($datos);
if (isset($datos['idusuario'])) {
    $idusuario = $datos['idusuario'];
    $rolesSeleccionados = isset($_POST['roles']) ? $_POST['roles'] : [];

    $rolesActuales = $objUsuarioRol->buscar(['idusuario' => $idusuario]);
    
    // Obtener IDs de los roles actuales
    $rolesActualesIds = [];
    foreach ($rolesActuales as $rolUsuario) {
        $rolesActualesIds[] = $rolUsuario->getObjRol()->getId();
    }

    // Quitar roles no seleccionados
    foreach ($rolesActualesIds as $rolId) {
        if (!in_array($rolId, $rolesSeleccionados)) {
            $objUsuarioRol->quitarRol($idusuario, $rolId);
        }
    }

    // Agregar nuevos roles seleccionados
    foreach ($rolesSeleccionados as $rolId) {
        if (!in_array($rolId, $rolesActualesIds)) {
            $objUsuarioRol->agregarRol($idusuario, $rolId);
        }
    }
}

?>
