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
    //posible solucion no estoy seguro todavia=
    $unaCompra=$compraCliente[count($compraCliente)-1];
    if(count($compraCliente)==0 || count($abmCompraEstado->buscar(['idcompra' => $unaCompra->getIdCompra()])) != 1){
        //creo el carrito si el cliente no tiene un objeto compra o si el cliente tiene compras pero no esta en estado carrito
        echo "crear compra en estado carrito";
    }else{
        echo "existe una compra en estado carrito";
    }
}
?>