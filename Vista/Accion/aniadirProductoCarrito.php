<?php 
include_once "../../configuracion.php";
$datos=data_submitted();
var_dump($datos);
$abmCompra=new AbmCompra();
$abmCompraEstado=new AbmCompraEstado();
$abmCompraItem=new AbmCompraItem();

if (isset($datos['idproducto'])){
    $usuario=$session->getUsuario();
    $idUsuario=$usuario->getId();
    //busco si el usuario no tiene compras
    $compraCliente=$abmCompra->buscar(['idusuario' => $idUsuario]);
    //si el usuario no tiene compras se crea una compra con el estado 5 (carrito)
    if(count($compraCliente)==0){

    }
}
?>