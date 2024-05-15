<?php header('Content-Type: text/html; charset=utf-8');
header ("Cache-Control: no-cache, must-revalidate ");

/////////////////////////////
// CONFIGURACION APP//
/////////////////////////////

$PROYECTOROOT = "http://".$_SERVER['HTTP_HOST']."/TpFinalFinal/";
$PROYECTO ='TpFinalFinal';

//variable que almacena el directorio del proyecto
$ROOT =$_SERVER['DOCUMENT_ROOT']."/".$PROYECTO."/";
//var_dump($ROOT);

include_once($ROOT.'util/funciones.php');
include_once($ROOT.'./Vista/Menu/menuDinamico.php');
include_once($ROOT.'Vista/Estructura/header.php');


/**
 * debo modificar esto despues ccambiando las url del $INICIO Y $PRINCIPAL
 */
// Variable que define la pagina de autenticacion del proyecto
$INICIO = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/vista/login/indexLogin.php";

// variable que define la pagina principal del proyecto (menu principal)
$PRINCIPAL = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/vista/inicio/index.php";


$GLOBALS['ROOT']=$ROOT;
?>
