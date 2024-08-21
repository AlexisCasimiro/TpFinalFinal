<?php

class AbmCompraEstado{


    /**
     * Espera un Array asociativo y devuelve el obj de la tabla
     * @param array $datos
     * @return CompraEstado
     */
    private function cargarObjeto($datos){
        $obj=null; 
        //var_dump($datos);
        if(array_key_exists('idcompraestado',$datos) && array_key_exists('idcompra',$datos) 
        && array_key_exists('idcompraestadotipo',$datos) && array_key_exists('cefechaini',$datos) 
        && array_key_exists('cefechafin',$datos) ){
            //echo("entro al cargar obj");    
            // creo al obj compra
            $objC=new Compra();
            $objC->setId($datos['idcompra']); 
            $objC->cargar(); 
            
            // creo el obj compraestadotipo
            $objCET=new CompraEstadoTipo();
            $objCET->setId($datos['idcompraestadotipo']);
            $objCET->cargar();
        
            // creo al obj compra 
            $obj=new CompraEstado();
            $obj->setear($datos['idcompraestado'],$objC,$objCET,$datos['cefechaini'],$datos['cefechafin']);
               
        }// fin if 

        return $obj; 
    }// fin function 


    /**
     * Espera como parametro un array asociativo donde las claves coinciden  con los atributos 
     * @param array $datos
     * @return CompraEstado
     */
    private function cargarObjetoConClave($param){
        $objCompraEstado = null;
        if (isset($param['idcompraestado']) ){
            $objCompraEstado = new CompraEstado();
            $objCompraEstado->setear($param['idcompraestado'], null, null, null, null);
        }
        return $objCompraEstado;

    }// fin function 

    /**
     * corrobora que dentro del array asociativo estan seteados los campos
     * @param array $datos
     * @return boolean
     */
    private function setadosCamposClaves($datos){
        $resp=false;
        
        //var_dump(isset($datos['cefechafin'])); // OJO!!!! isset si la variable es null, dará falso 
        if(array_key_exists('idcompraestado',$datos)){
            $resp=true; 
        }
        
        return $resp;

    }// fin function 

    /**
     * METODO ALTA
     * @param array $datos
     * @return boolean
     */
    public function alta($datos){
        $resp=false;
        //var_dump($datos['cefechafin']);
        $datos['idcompraestado']=null;
        //var_dump(array_key_exists('cefechafin',$datos));
        $objCompraEstado=$this->cargarObjeto($datos);
        
        if($objCompraEstado!=null && $objCompraEstado->insertar()){
            $resp=true;
        }// fin if 
        //var_dump($resp);
        return $resp;

    }// fin function 

    /**
     * METODO ELIMINAR 
     * @param array $datos
     * @return boolean
     */
    public function baja($datos){
        $resp=false;
        if($this->setadosCamposClaves($datos)){
            $objCompraEstado=$this->cargarObjetoConClave($datos);
            if($objCompraEstado!=null && $objCompraEstado->eliminar()){
                $resp=true;

            }// fin if 


        }// fin if 

        return $resp; 

    }// fin function 

    /**
     * MOFICAR 
     * @param array $datos
     * @return boolean
     */
    public function modificacion($datos){
        $resp=false;
        var_dump($datos);
        if($this->setadosCamposClaves($datos)){
            $objCompraEstado=$this->cargarObjeto($datos);
            
            if($objCompraEstado!=null && $objCompraEstado->modificar()){
                $resp=true; 

            }// fin if 

        }// fin if 

        return $resp; 

    }// fin function 

 /**
     * METODO BUSCAR
     * Si el parametro es null, devolverá todos los registros de la tabla auto 
     * si se llena con los campos de la tabla devolverá el registro pedido
     * @param array $param
     * @return array
     */
    public function buscar ($param){
        $objCompraEstado=new CompraEstado();
        $where=" true ";
        if($param<>null){
            // Va preguntando si existe los campos de la tabla 
                if(isset($param['idcompraestado'])){ 
                    $where.=" and idcompraestado=".$param['idcompraestado'];
                }// fin if 
                if(isset($param['idcompra'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and idcompra =".$param['idcompra'];
                }// fin if 
                if(isset($param['idcompraestadotipo'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and idcompraestadotipo =".$param['idcompraestadotipo'];
                }// fin if 
                if(isset($param['cefechaini'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and cefechaini ='".$param['cefechaini']."'";
                }// fin if 
                if(isset($param['cefechafin'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and cefechafin ".$param['cefechafin'];
                }// fin if  
        }// fin if
        $arreglo=$objCompraEstado->listar($where);
        //var_dump($where); 
        return $arreglo; 

    }// fin funcion     

    /** Permite finalizar un objeto 
     * @param ARRAY $param
     * @return BOOLEAN 
    */
    public function finalizar($param){
        $resp = false;
        if ($this->setadosCamposClaves($param)){
            $objCompraEstado = $this->cargarObjetoConClave($param);
            if ($objCompraEstado!=null and $objCompraEstado->finalizar()){
                $resp = true;
            }
        }
        return $resp;
    }

    public function actualizarEstado($idcompra, $nuevoEstado) {
        $abmCompra = new AbmCompra();
        $compra = $abmCompra->buscar(['idcompra' => $idcompra]);
        $response = false;
    
        if (!empty($compra)) {
            $compraEstados = $this->buscar(['idcompra' => $idcompra]);
            $estadoActual = !empty($compraEstados) ? end($compraEstados) : null;
    
            if ($estadoActual) {
                // Finalizar estado actual
                $paramEstadoIniciada = [
                    'idcompraestado' => $estadoActual->getId(),
                    'cefechafin' => date('Y-m-d H:i:s')
                ];
                $this->finalizar($paramEstadoIniciada);
    
                // Crear nuevo estado
                $param = [
                    'idcompra' => $idcompra,
                    'idcompraestadotipo' => $nuevoEstado,
                    'cefechaini' => date("Y-m-d H:i:s"),
                    'cefechafin' => null,
                ];
    
                if ($this->alta($param)) {
                    // Enviar correo
                    $this->enviarCorreoCompra($compra[0]);
                    $response = true;
                }
            }
        }
    
        return $response;
    }
    
    public function cancelarCompra($idcompra) {
        $abmCompra = new abmCompra();
        $abmCompraItem = new abmCompraItem();
        $abmProducto = new abmProducto();
        $response = false;

        $compra = $abmCompra->buscar(['idcompra' => $idcompra]);
        if (!empty($compra)) {
            $compra = $compra[0];
            $compraEstados = $this->buscar(['idcompra' => $idcompra]); // Estado iniciada
            if (!empty($compraEstados)) {
                $estadoIniciada = end($compraEstados);

                // Finalizar el estado actual "iniciada"
                $paramEstadoIniciada = [
                    'idcompraestado' => $estadoIniciada->getId(),
                    'cefechafin' => date('Y-m-d H:i:s')
                ];
                $this->finalizar($paramEstadoIniciada);

                // Crear el nuevo estado "cancelada"
                $paramEstado = [
                    'idcompra' => $idcompra,
                    'idcompraestadotipo' => 4, // Estado cancelada
                    'cefechaini' => date('Y-m-d H:i:s'),
                    'cefechafin' => null
                ];

                if ($this->alta($paramEstado)) {
                    // Actualizar el stock de los productos
                    $items = $abmCompraItem->buscar(['idcompra' => $idcompra]);
                    if (!empty($items)) {
                        foreach ($items as $item) {
                            $producto = $abmProducto->buscar(['idproducto' => $item->getObjProducto()->getIdProducto()]);
                            if (!empty($producto)) {
                                $producto = $producto[0];
                                $sumarStock = $producto->getCantStock() + $item->getCantidad();
                                $abmProducto->modificacionStock(['idproducto' => $producto->getIdProducto(), 'procantstock' => $sumarStock]);
                            }
                        }
                    }

                    // Enviar correo de notificación
                    $this->enviarCorreoCompra($compra);
                    $response = true;
                }
            }
        }

        return $response;
    }

    public function manejarCarrito($idUsuario, $idProducto) {
        $abmCompra = new AbmCompra();
        $abmCompraItem = new AbmCompraItem();
        $resp = false;

        // Busco si el usuario tiene compras
        $compraCliente = $abmCompra->buscar(['idusuario' => $idUsuario]);
        $unaCompra = end($compraCliente);

        // Verifico si hay que crear una nueva compra o usar la existente
        if (count($compraCliente) == 0 || count($this->buscar(['idcompra' => $unaCompra->getId()])) != 1) {
            // Crear nueva compra en estado "carrito"
            $abmCompra->alta(['idcompra' => 0, 'cofecha' => null, 'idusuario' => $idUsuario]);
            $comprasCliente = $abmCompra->buscar(['idusuario' => $idUsuario]);
            $ultimaCompraCreada = end($comprasCliente);

            // Crear un nuevo estado "carrito"
            $this->alta([
                'idcompraestado' => 0,
                'idcompra' => $ultimaCompraCreada->getId(),
                'idcompraestadotipo' => 5, // Estado carrito
                'cefechaini' => NULL,
                'cefechafin' => NULL
            ]);

            // Agregar el producto al carrito
            $abmCompraItem->alta([
                'idcompraitem' => 0,
                'idproducto' => $idProducto,
                'idcompra' => $ultimaCompraCreada->getId(),
                'cicantidad' => 1
            ]);
            $resp = true;

        } else {
            // Usar la compra existente en estado "carrito"
            $ultimaCompra = $unaCompra;
            $itemCompra = $abmCompraItem->buscar([
                'idcompra' => $ultimaCompra->getId(),
                'idproducto' => $idProducto
            ]);

            if (count($itemCompra) == 0) {
                // Si el producto no está en el carrito, lo agrego
                $abmCompraItem->alta([
                    'idcompraitem' => 0,
                    'idproducto' => $idProducto,
                    'idcompra' => $ultimaCompra->getId(),
                    'cicantidad' => 1
                ]);
                $resp = true;
            } else {
                // Si ya existe, incremento la cantidad
                $unaCompraItem = $itemCompra[0];
                $unaCompraItem->setCantidad($unaCompraItem->getCantidad() + 1);
                $abmCompraItem->modificacion([
                    'idcompraitem' => $unaCompraItem->getId(),
                    'idproducto' => $idProducto,
                    'idcompra' => $ultimaCompra->getId(),
                    'cicantidad' => $unaCompraItem->getCantidad()
                ]);
                $resp = true;
            }
        }

        return $resp;
    }

    public function finalizarCompra($idcompra) {
        $abmCompraEstado = new abmCompraEstado();
        $abmCompraItem = new abmCompraItem();
        $abmProducto = new abmProducto();
        $resultado = false;  
    
        // Verifico si la compra existe y está en estado "carrito"
        $compraEstados = $abmCompraEstado->buscar(['idcompra' => $idcompra, 'idcompraestadotipo' => 5]);
        if (!empty($compraEstados)) {
            // Obtengo los items de la compra
            $items = $abmCompraItem->buscar(['idcompra' => $idcompra]);
            $stockSuficiente = true;
            $productoSinStock = null;
    
            $i = 0;
            // Verifico que haya stock suficiente para cada producto
            while ($i < count($items) && $stockSuficiente) {
                $item = $items[$i];
                $idproducto = $item->getObjProducto()->getIdProducto();
                $producto = $abmProducto->buscar(['idproducto' => $idproducto]);
                if (!empty($producto)) {
                    $producto = $producto[0];
                    $cantidad = $item->getCantidad();
                    if ($producto->getCantStock() < $cantidad) {
                        $stockSuficiente = false;
                        $productoSinStock = $producto;
                    }
                } else {
                    $stockSuficiente = false;
                    $productoSinStock = null;
                }
                $i++;
            }
    
            if ($stockSuficiente) {
                // Cambiar el estado de la compra a "iniciada" (1)
                $nuevoEstado = [
                    'idcompraestado' => 0,
                    'idcompra' => $idcompra,
                    'idcompraestadotipo' => 1,
                    'cefechaini' => null,
                    'cefechafin' => null
                ];
    
                if ($abmCompraEstado->finalizar(['idcompraestado' => $compraEstados[0]->getId()], ['idusuario' => $_SESSION['idusuario']])) {
                    if ($abmCompraEstado->alta($nuevoEstado)) {
                        // Resto el stock de los productos
                        foreach ($items as $item) {
                            $cantidadEnCarrito = $item->getCantidad();
                            $producto = $abmProducto->buscar(['idproducto' => $item->getObjProducto()->getIdProducto()])[0];
                            $stockActual = $producto->getCantStock();
                            $nuevoStock = $stockActual - $cantidadEnCarrito;
                            $abmProducto->modificacionStock(['idproducto' => $item->getObjProducto()->getIdProducto(), 'procantstock' => $nuevoStock]);
                        }
    
                        // Lógica para el envío de mail
                        $abmCompra = new AbmCompra();
                        $objCompra = $abmCompra->buscar(['idcompra' => $idcompra])[0];
                        $mail = new Mailer();
                        $mail->mandarMail($objCompra);
                        $resultado = true;
                    }
                }
            }
        }
    
        return $resultado;
    }
    
    

    private function enviarCorreoCompra($compra) {
        $mail = new Mailer();
        $mail->mandarMail($compra);
    }

}// fin clase 

?>