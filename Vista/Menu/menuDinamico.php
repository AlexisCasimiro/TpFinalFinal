<?php 
$datos = data_submitted();
$session = new Session;
$objAbmMenuRol = new AbmMenuRol();
var_dump($_SESSION);
if ($session->validar() && $session->permisos()) {    //&& $session->permisos()
    $menu = $objAbmMenuRol->menuPrincipal($session);
    $menuRol = $objAbmMenuRol->menuRol($session);
    $UsuarioRol = $session->getRolActual()->getDescripcion();
}else{
    header('Location: '.$PROYECTOROOT."Vista/Cliente/indexCliente.php");
}
//
//
//  AQUI DEBO AGREGAR UN HEADER EN CASO QUE NO TENGA PERMISOS O QUE AL VALIDAR SEA FALSE
//
//