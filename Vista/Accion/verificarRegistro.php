<?php 
include_once "../../configuracion.php";
$datos=data_submitted();
var_dump($datos);

if (isset($datos['nombre']) && isset($datos['email']) && isset($datos['password'])) {
    $nuevoUsuario['idusuario'] = null;
    $nuevoUsuario['usnombre'] = $datos['nombre'];
    $nuevoUsuario['uspass'] = md5($datos['password']);
    $nuevoUsuario['usmail'] = $datos['email'];
    $nuevoUsuario['usdeshabilitado'] = null;

    $busqueda['usmail'] = $nuevoUsuario['usmail'];

    $usuario = new AbmUsuario();
    $abmUsuarioRol = new AbmUsuarioRol;
    $existe = $usuario->buscar($busqueda);
    if(count($existe)>0){
        header('Location: '. $PROYECTOROOT . "Vista/login.php?existe=1");
    }else{
        if($usuario->alta($nuevoUsuario)){
            $usuarioCreadoRecien= $usuario->buscar($busqueda);
            $rol['idusuario'] = $usuarioCreadoRecien[0]->getId();
            $rol['idrol'] = 3;
            $abmUsuarioRol->alta($rol);
            header('Location: '. $PROYECTOROOT . "Vista/login.php?registrado=1");
        }
    }
}

?>