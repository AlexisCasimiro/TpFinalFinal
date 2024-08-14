<?php

    class AbmMenuRol{

    /**
     * Espera como parametro un arreglo asociativo donde 
     * las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    private function cargarObjeto($param){
        $obj = null;
           
        if( array_key_exists('idmenu',$param) and array_key_exists('idrol',$param)){
            $objMenu=new Menu();
            $objRol=new Rol();
            $objMenu->setId($param['idmenu']);
            $objRol->setId($param['idrol']);
            $objMenu->cargar();
            $objRol->cargar();
            $obj =new MenuRol();
            $obj->setear($objMenu,$objRol);
        }
        return $obj;
    }// fin metodo

        /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param)
    {
        $objMenuRol = null;
        //print_R ($param);
        if (isset($param['idmenu']) && isset($param['idrol'])) {
            $objMenuRol = new MenuRol();
            $objMenuRol->setear($param['idmenu'], $param['idrol']);
        }
        return $objMenuRol;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

     private function seteadosCamposClaves($param){
         $resp = false;
         if (isset($param['idmenu']) && isset($param['idrol']));
         $resp = true;
         return $resp;
     }// fin metodo

    
    /**
     *
     * @param array $param
     */
    public function alta($param){
        //  echo "entramos a alta";
        $resp = false;
        $objMenuRol = $this->cargarObjeto($param);
        // verEstructura($elObjtAuto);
        //print_r($objMenuRol);
        if ($objMenuRol != null) {
            if ($objMenuRol->insertar()) {
                $resp = true;
            }
        }
        return $resp;
    } // fin metodo    


    /**
     * permite eliminar un objeto
     * @param array $param
     * @return boolean
     */

     public function baja($param)
     {
         //verEstructura($param);
         $resp = false;
         if ($this->seteadosCamposClaves($param)) {
             $objMenuRol = $this->cargarObjetoConClave($param);
             if ($objMenuRol != null and $objMenuRol->eliminar()) {
                 $resp = true;
             }
         }
         return $resp;
    }// fin metodo 


    
     /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        //echo "Estoy en modificacion";
        //print_R($param);
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objMenuRol = $this->cargarObjeto($param);
            if ($objMenuRol != null and $objMenuRol->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }// fin metodo 


    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */

     public function buscar($param)
     {
         $where = " true ";
         if ($param <> NULL) {
             if (isset($param['idmenu'])){
             $where .= " and idmenu=" . $param['idmenu'] ;
             }
             if (isset($param['idrol'])){
             $where .= " and idrol =" . $param['idrol'] ;
             }
         }// fin if 

         $objMenuRol=new MenuRol();
         $arreglo = $objMenuRol->listar($where);
         return $arreglo;
    }// fin metodo


    public function menuPrincipal($objSession){
        $menu = "";    
        $param['idrol'] = $objSession->getRolActual()->getId();
        $listaMenuRol = $this->buscar($param);
        foreach($listaMenuRol as $objMenuRol){      
            //<li class="nav-item "><a href="../Cliente/indexCliente.php" class="nav-link active text-primary">Inicio</a></li>
            $menu .= "<li class='nav-item'><a href=".$objMenuRol->getObjMenu()->getDescripcion()." class='nav-link active text-primary'>".$objMenuRol->getObjMenu()->getNombre()."</a></li>";
        }
        return $menu;
    }  

    public function menuRol($objSession){   
        $opcionRol = "";
        $listaRol = $objSession->getRoles();
        if(count($listaRol)>1){
            foreach($listaRol as $rol){      
                $opcionRol .= "<option value='".$rol->getId()."'>".$rol->getDescripcion()."</option>"; 
              }
        }
        return $opcionRol;
    }


}// fin AbmMenuRol

?>
