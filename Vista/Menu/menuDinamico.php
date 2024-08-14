<?php 

$session = new Session;
$objAbmMenuRol = new AbmMenuRol();
var_dump($_SESSION);

// Ruta de la página actual
$currentUri = $_SERVER['REQUEST_URI'];

// Ruta de la página a la que redirige (obtenemos solo la ruta)
$redirectUri = $PROYECTOROOT . "Vista/Cliente/indexCliente.php";
$parsedRedirectUri = parse_url($redirectUri, PHP_URL_PATH);

if ($session->validar() && $session->permisos()) {
    $menu = $objAbmMenuRol->menuPrincipal($session);
    $menuRol = $objAbmMenuRol->menuRol($session);
    $UsuarioRol = $session->getRolActual()->getDescripcion();
} else {
    // Compara la página actual con la página a la que se redirige
    if ($currentUri !== $parsedRedirectUri) {
        echo $currentUri;
        if(!($currentUri == "/TpFinalFinal/Vista/login.php")){
            header('Location:'.$PROYECTOROOT."Vista/Cliente/indexCliente.php");
        }
        
    }
}

//
//
//  AQUI DEBO AGREGAR UN HEADER EN CASO QUE NO TENGA PERMISOS O QUE AL VALIDAR SEA FALSE
//
//
?>