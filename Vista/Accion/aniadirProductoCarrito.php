<?php 
include_once "../../configuracion.php";
$datos=data_submitted();
var_dump($datos);
$abmCompra=new AbmCompra();
$abmCompraEstado=new AbmCompraEstado();
$abmCompraItem=new AbmCompraItem();
$resp=false;
if (isset($datos['idproducto'])){
    $usuario=$session->getUsuario();
    $idUsuario=$usuario->getId();
    //busco si el usuario no tiene compras
    $compraCliente=$abmCompra->buscar(['idusuario' => $idUsuario]);
    //si el usuario no tiene compras se crea una compra con el estado 5 (carrito)
    /**if(count($compraCliente)>0){
        $unaCompra=$compraCliente[count($compraCliente)-1];
    }*/
    //$unaCompra=$compraCliente[count($compraCliente)-1];
    $unaCompra=end($compraCliente);
    var_dump($unaCompra);
    $idProducto=$datos['idproducto'];
    if(count($compraCliente)==0 || count($abmCompraEstado->buscar(['idcompra' => $unaCompra->getId()])) != 1){
        //creo el carrito si el cliente no tiene un objeto compra o si el cliente tiene compras pero no esta en estado carrito
        echo "crear compra en estado carrito";
        $abmCompra->alta(['idcompra' => 0, 'cofecha' => null, 'idusuario' => $idUsuario]);
        //busco el id de la ultima compra del cliente agregada recientemente
        $comprasCliente=$abmCompra->buscar(['idusuario'=>$idUsuario]);
        $ultimaCompraCreada=end($comprasCliente);
        //creo un compraestado en estado "carrito"
        $abmCompraEstado->alta(['idcompraestado' => 0, 'idcompra' => $ultimaCompraCreada->getId(), 'idcompraestadotipo' => 5, 'cefechaini' => NULL, 'cefechafin' => NULL]);
        //agrego el item al carrito
        $abmCompraItem->alta(['idcompraitem' => 0, 'idproducto' => $idProducto, 'idcompra' => $ultimaCompraCreada->getId(), 'cicantidad' => 1]);
        //recordar agregar los items
    }else{
        echo "existe una compra en estado carrito";
        $ultimaCompra=$unaCompra;
        //busca si el item ya se encuentra en el carrito
        $itemCompra=$abmCompraItem->buscar(['idcompra'=>$ultimaCompra->getId(),'idproducto'=>$idProducto] );
        if(count($itemCompra)==0){//si no se encuentra en el carrito lo agrega en la tabla compraItem
            $abmCompraItem->alta(['idcompraitem' => 0, 'idproducto' => $idProducto, 'idcompra' => $ultimaCompra->getId(), 'cicantidad' => 1]);
        }else{//si ya existe el producto en el carrito modifica la cantidad sumando un mismo item 
            $unaCompraItem=$itemCompra[0];
            $unaCompraItem->setCantidad($unaCompraItem->getCantidad()+1);
            $abmCompraItem->modificacion(['idcompraitem'=>$unaCompraItem->getId(),'idproducto'=>$idProducto,'idcompra'=>$ultimaCompra->getId(),'cicantidad'=>$unaCompraItem->getCantidad()]);
        }
    }//está checkeado que esto funciona bien ahora falta hacer la logica para crear la compra en estado carrito o agregar los items a la compra
    $resp=true;
}
if($resp){
    header('Location: '. $PROYECTOROOT . "Vista/Cliente/carrito.php?correcto=1");
}else{
    header('Location: '. $PROYECTOROOT . "Vista/Cliente/carrito.php?error=1");
}
?>