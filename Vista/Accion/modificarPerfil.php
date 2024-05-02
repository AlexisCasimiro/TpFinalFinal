<?php 
include_once "../../configuracion.php";
$datos=data_submitted();
$resp=false;
if(isset($datos['usnombre']) && isset($datos['uspass']) && isset($datos['usmail'])){
    if($datos['uspassnew']!= null){
        $datosNuevos['uspass']=md5($datos['uspassnew']);
    }else{
        $datosNuevos['uspass']=md5($datos['uspass']);
    }
    $datosNuevos['idusuario']=12;
    $datosNuevos['usnombre'] = $datos['usnombre'];
    $datosNuevos['usmail'] = $datos['usmail'];
    $datosNuevos['usdeshabilitado'] = null;

    $usuario=new AbmUsuario();
    if($usuario->modificacion($datosNuevos)){
        $resp=true;
        echo $resp;
    }else {
        echo $resp;
    }
}

echo json_encode($resp);//no recuerdo si iba esto(en caso de que no funcione lo tengo que borrar)