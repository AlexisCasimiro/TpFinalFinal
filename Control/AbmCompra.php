<?php

class AbmCompra{

    /**
     * Espera un Array asociativo y devuelve el obj de la tabla
     * @param array $datos
     * @return object
     */
    private function cargarObjeto($datos){
        $obj=null; 
        //echo("entro cragar objeto");
        if(array_key_exists('idcompra',$datos) && array_key_exists('cofecha',$datos) && array_key_exists('idusuario',$datos)){
            
            // creo al obj usuario
            $objU=new Usuario();
            $objU->setId($datos['idusuario']); 
            $objU->cargar(); 
            // creo al obj compra 
            $obj=new Compra();
            $obj->setear($datos['idcompra'],$datos['cofecha'],$objU);
            
        }// fin if 
        return $obj; 
    }// fin function 


    /**
     * Espera como parametro un array asociativo donde las claves coinciden  con los atributos 
     * @param array $datos
     * @return Compra
     */
    private function cargarObjetoConClave($datos){
        $obj=null;
        if(isset($datos['idcompra'])){
            // creo al obj usuario
            $objU=new Usuario();
            $objU->setId($datos['idusario']);
            $objU->cargar(); 

            $obj=new Compra();
            $obj->setear($datos['idcompra'],$datos['cofecha'],$objU);

        }// fin if 
        return $obj;

    }// fin function 

    /**
     * corrobora que dentro del array asociativo estan seteados los campos
     * @param array $datos
     * @return boolean
     */
    private function setadosCamposClaves($datos){
        $resp=false;
       // var_dump($datos);
        if(isset($datos['idcompra']) && isset($datos['cofecha']) && isset($datos['idusuario'])){
            $resp=true;

        }// fin if 
        //var_dump($resp);
        return $resp;

    }// fin function 

    /**
     * METODO ALTA
     * @param array $datos
     * @return boolean
     */
    public function alta($datos){
        $resp=false;
        $datos['idcompra']=null;
        $objCompra=$this->cargarObjeto($datos);
        //echo("alta <br>");
       // var_dump($objCompra);
        if($objCompra!=null && $objCompra->insertar()){
            //echo("<br> true <br>");
            $resp=true;
        }// fin if 
        return $resp;

    }// fin function 

    /**
     * PERMITE ELIMINAR UN OBJ 
     * @param array $datos
     * @return boolean
     */
    public function baja($datos){
        $resp=false;
        if($this->setadosCamposClaves($datos)){
            $objCompra=$this->cargarObjetoConClave($datos);
            if($objCompra!=null && $objCompra->eliminar()){
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
        
        if($this->setadosCamposClaves($datos)){
            $objCompra=$this->cargarObjeto($datos);
           // var_dump($this->cargarObjeto($datos));
            if($objCompra!=null && $objCompra->modificar()){
         
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
        $objCompra=new Compra();
        $where=" true ";
        if($param<>null){
            // Va preguntando si existe los campos de la tabla 
                if(isset($param['idcompra'])){
                    $where.=" and idcompra=".$param['idcompra'];
                }// fin if 
                if(isset($param['cofecha'])){// identifica si esta la clave (atributo de la tabla)
                    $where.="and cofecha ='".$param['cofecha']."'";
                }// fin if 
                if(isset($param['idusuario'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and idusuario =".$param['idusuario'];
                }// fin if 
        }// fin if
        $arreglo=$objCompra->listar($where);
        //var_dump($where); 
        return $arreglo; 

    }// fin funcion   
    
    
}// fin clase AbmCmpra
