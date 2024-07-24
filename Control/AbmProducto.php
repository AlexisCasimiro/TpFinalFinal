<?php
class AbmProducto {
    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param ARRAY $param
     * @return Producto */
    private function cargarObjeto($param){
        $objProducto = null;
        if (array_key_exists('idproducto',$param) && array_key_exists('pronombre',$param) && array_key_exists('prodetalle',$param) && array_key_exists('procantstock',$param) && array_key_exists('proprecio',$param) && array_key_exists('proimagen',$param)) {
            $objProducto = new Producto();
            $objProducto->setear($param['idproducto'], $param['pronombre'], $param['prodetalle'], $param['procantstock'], $param['proprecio'], $param['proimagen']);
        }
        return $objProducto;
    }
    
    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param ARRAY $param
     * @return Producto */
    private function cargarObjetoConClave($param){
        $objProducto = null;
        if (isset($param['idproducto']) ){
            $objProducto = new Producto();
            $objProducto->setear($param['idproducto'], null, null, null, null, null);
        }
        return $objProducto;
    }
    
    /** Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param ARRAY $param
     * @return BOOLEAN */
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idproducto']) ){
            $resp = true;
        return $resp;
    }
    }
    
    /**
     * @param ARRAY $param
     */
    public function alta($param){
        $resp = false;
        $objProducto = $this->cargarObjeto($param);
        if ($objProducto!=null and $objProducto->insertar()){
            $resp = true;
        }
        return $resp;
    }
    /** Permite eliminar un objeto 
     * @param ARRAY $param
     * @return BOOLEAN */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objProducto = $this->cargarObjetoConClave($param);
            if ($objProducto!=null and $objProducto->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }

    /** Permite modificar un objeto
     * @param ARRAY $param
     * @return BOOLEAN */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objProducto = $this->cargarObjetoConClave($param);
            if($objProducto!=null and $objProducto->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }

    /** Permite cambiar stock de un objeto
     * @param ARRAY $param
     * @return BOOLEAN */
    public function modificacionStock($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objProducto = $this->cargarObjetoConClave($param);
            if (array_key_exists('procantstock',$param)) {
                $objProducto->setCantStock($param['procantstock']);
                if($objProducto!=null and $objProducto->modificarStock()){
                    $resp = true;
                }
            }
        }
        return $resp;
    }
    
    /** Permite buscar un objeto
     * @param ARRAY $param
     * @return ARRAY */
    public function buscar($param){
        $where = " true ";
        $objProducto = new Producto();
        if ($param<>NULL){
            if  (isset($param['idproducto']))
                $where.=" and idproducto ='".$param['idproducto']."'";
            if  (isset($param['pronombre']))
                $where.=" and pronombre ='".$param['pronombre']."'";
            if  (isset($param['prodetalle']))
                $where.=" and prodetalle ='".$param['prodetalle']."'";
            if  (isset($param['procantstock']))
                $where.=" and procantstock ='".$param['procantstock']."'";
            if  (isset($param['proprecio']))
                $where.=" and proprecio ='".$param['proprecio']."'";
            if  (isset($param['proimagen']))
                $where.=" and proimagen ='".$param['proimagen']['name']."'";
        }
        $arreglo = $objProducto->listar($where);
        return $arreglo;
    }
}
?>