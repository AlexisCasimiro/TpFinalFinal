<?php 
include_once "../../configuracion.php";
$datos=data_submitted();

$session = new Session();
if (isset($datos['email']) && isset($datos['password'])){
    $email = $datos['email'];
    $password = md5($datos['password']);
    if ($session->iniciar($email, $password) && $session->validar()){
        header('Location: '.$PROYECTOROOT."Vista/Cliente/indexCliente.php");
    } else {
        header('Location: '.$PROYECTOROOT."Vista/Login.php?error=1");
    }
}
?>