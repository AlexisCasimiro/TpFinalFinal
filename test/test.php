<?php
include_once "../Modelo/Conector/BaseDatos.php";
include_once "../Modelo/Usuario.php";
include_once "../Modelo/Compra.php";
include_once "../Modelo/CompraEstado.php";
include_once "../Modelo/CompraEstadoTipo.php";
include_once "../Modelo/CompraItem.php";
include_once "../Modelo/Producto.php";

include_once "../Control/AbmCompra.php";
include_once "../Control/AbmCompraEstado.php";
include_once "../Control/AbmCompraItem.php";


include_once "../Control/Mailer.php";
$idcompra= 53;
$abmCompra = new AbmCompra;
$objCompra = $abmCompra->buscar(['idcompra'=>$idcompra])[0];
$mail = new Mailer();
    $mail->mandarMail($objCompra);
var_dump($objCompra);