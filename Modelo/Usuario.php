<?php

class Usuario{
    // ATRIBUTOS 
    private $idusuario; 
    private $usnombre; 
    private $uspass;
    private $usmail;
    private $usdeshabilitado; 
    private $mensaje; 
    private $arrayObjRolUsuario; // delegacion de muchos a muchos entre usuario y rol 


    // CONSTRUSTOR 
    public function __construct(){

        $this->idusuario="";
        $this->usnombre="";
        $this->uspass="";
        $this->usmail="";
        $this->usdeshabilitado=null;
        $this->mensaje="";
    }// fin constructor
    
    // METODO SETEAR 
    public function setear($id,$nombre,$pass,$mail,$deshab){
        $this->idusuario=$id;
        $this->usnombre=$nombre;
        $this->uspass=$pass;
        $this->usmail=$mail;
        $this->usdeshabilitado=$deshab;

    }// fin metodo setear

    // METODOS GET
    public function getId(){
        return $this->idusuario; 
    }// fin metodo get

    public function getNombre(){
        return $this->usnombre; 
    }// fin metodo get

    public function getPassword(){
        return $this->uspass; 
    }// fin metodo get

    public function getMail(){
        return $this->usmail; 
    }// fin metodo get

    public function getDeshabilitado(){
        return $this->usdeshabilitado; 
    }// fin metodo get

    public function getMensaje(){
        return $this->mensaje; 
    }// fin metodo get

    public function getRolUsuarios(){
        return $this->arrayObjRolUsuario; 
    }// fin metodo get

    // METODOS SET 
    public function setId($id){
        $this->idusuario=$id;
    }// fin metodo set

    public function setNombre($name){
        $this->usnombre=$name;
    }// fin metodo set

    public function setPassword($pass){
        $this->uspass=$pass;
    }// fin metodo set

    public function setMail($mail){
        $this->usmail=$mail;
    }// fin metodo set

    public function setDeshabilitado($des){
        $this->usdeshabilitado=$des;
    }// fin metodo set

    public function setMensaje($msj){
        $this->mensaje=$msj;
    }// fin metodo set

    public function setRolUsuario($usuariosRol){
        $this->arrayObjRolUsuario=$usuariosRol;
    }// fin metodo set 

    /**
     * METODO CARGAR
     * carga a un obj usuario en caso que se encuentre en la base de datos 
     * @return boolean
     */
    public function cargar(){
        $salida=false; // inicializacion del valor de retorno
        $baseDatos=new BaseDatos();
        $sql = "SELECT * FROM usuario WHERE idusuario=".$this->getId();
        if($baseDatos->Iniciar()){// inicializa la conexion
            $salida=$baseDatos->Ejecutar($sql); 
            if($salida>-1){
                if($salida>0){
                    $salida=true; 
                    $R=$baseDatos->Registro(); // recupera los registros de la tabla  con la ID dada
                    
                    $this->setear($R['idusuario'],$R['usnombre'],$R['uspass'],$R['usmail'],$R['usdeshabilitado']);

                }// fin if 

            }// fin if


        }// fin if 
        else{
            $this->setMensaje("Error en la Tabla usuario").$baseDatos->getError();
        }// fin else

        return $salida; 

    }// fin function 

    /** METODO INSERTAR 
     * Ingresa un registro en la base de datos 
     * @return boolean
     */
    public function insertar(){
        $salida=false; // inicializacion del valor de retorno
        $baseDatos=new BaseDatos();
        $null="null";
        $sql="INSERT INTO usuario (usnombre, uspass, usmail, usdeshabilitado) VALUES ('".$this->getNombre()."','".$this->getPassword()."','".$this->getMail()."',".$null.");"; 
        //echo $sql;
        if($baseDatos->Iniciar()){
            if($elid = $baseDatos->Ejecutar($sql)){
                $this->setId($elid);
                $salida=true;
            }// fin if 
            else{
                $this->setMensaje("usuario -> Insertar").$baseDatos->getError();
            }// fin else

        }// fin if 
        else{
            $this->setMensaje("usuario -> Insertar").$baseDatos->getError();

        }// fin else

        return $salida; 


    }// fin function insertar 

    /**
     * METODO MODIFICAR
     * @return boolean
     */
    public function modificar(){
        $salida=false;       
        $baseDatos=new BaseDatos();
        $null="NULL";
        $sql="UPDATE usuario SET usnombre='".$this->getNombre().
        "', uspass='".$this->getPassword()."', usmail='".$this->getMail()."', usdeshabilitado= $null WHERE idusuario=".$this->getId();
        //echo($sql);
        if($baseDatos->Iniciar()){
            if($baseDatos->Ejecutar($sql)){
                $salida=true;
            }// fin if 
            else{
                $this->setMensaje("Tabla usuario Modificar ").$baseDatos->getError();
            }// fin else
        } // fin if
        else{
            $this->setMensaje("Tabla usuario Modificar ").$baseDatos->getError();
        } // fin else
        return $salida; 
    }// fin function modificar

    /**
     * METODO ELIMINAR (BORARDO LOGICO)
     * @return boolean
     */
    public function eliminar(){
        $salida=false;
        $baseDatos=new BaseDatos();
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date('Y-m-d H:i:s');
        $sql="UPDATE usuario SET usdeshabilitado = '$fecha' WHERE idusuario = ".$this->getId();
        if($baseDatos->Iniciar()){
            if($baseDatos->Ejecutar($sql)){
                $salida=true;

            }// fin if
            else{
                $this->setMensaje("Tabla usuario-> eliminar".$baseDatos->getError()); 
            }// fin else

        }// fin if
        else{
            $this->setMensaje("Tabla usuario-> eliminar".$baseDatos->getError());
        }// fin else

        return $salida; 
    }// fin function eliminar

    public function habilitar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE usuario SET usdeshabilitado=NULL WHERE idusuario=" . $this->getId();
        if ($base->Iniciar()){
            if ($base->Ejecutar($sql)){
                $resp = true;
            } else {
                $this->setMensaje("Usuario->habilitar: ".$base->getError());
            }
        } else {
            $this->setMensaje("Usuario->habilitar: " . $base->getError());
        }
        return $resp;
    }


    /**
     * METODO LISTAR 
     * DEVUELVE TODOS LOS USUARIOS EN LA BASE DE DATOS
     * @param $parametro
     * @return array 
     */
    public function listar($parametro=""){
        $arrayUsuarios=array();
        $baseDatos=new BaseDatos();
        $sql="SELECT * FROM usuario";
        if($parametro!=""){
            $sql.=' WHERE '.$parametro;
        }// fin if        
        if($baseDatos->Iniciar()){
           
            $respuesta=$baseDatos->Ejecutar($sql);
            if($respuesta>-1){
                if($respuesta>0){
                    
                    while($row=$baseDatos->Registro()){
                    $obj=new Usuario();
                    $obj->setear($row['idusuario'],$row['usnombre'],$row['uspass'],$row['usmail'],$row['usdeshabilitado']);
                        array_push($arrayUsuarios,$obj);   // 
                    }// fin while 


                }// fin if 
            }// fin if 
        }
        else {
            $this->setMensaje("Usuario->listar: ".$baseDatos->getError());
        }// fin if 
        return $arrayUsuarios; 
    }// fin function listar
    

}// fin clase 


?>