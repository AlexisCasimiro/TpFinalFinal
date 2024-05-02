<?php
class Session
{

    public function __construct()
    {
        session_start();
    }



    /** METODO INICIAR 
     * @param $nombreUsuario string
     * @param $pws string
     * @return boolean
     */
    public function iniciar($email, $pws)
    {
        $resp = false;
        $objAbmUsuario = new AbmUsuario();
        $datos['usmail'] = $email;
        $datos['uspass'] = $pws;
        $listaUsuario = $objAbmUsuario->buscar($datos);
        $usuario=$listaUsuario[0];
        if (count($listaUsuario)>0 && is_null($usuario->getDeshabilitado())){
            $_SESSION['idusuario'] = $usuario->getId();
            $resp = true;
        } else {
            $this->cerrar();
        }
        return $resp;
    } // fin metodo iniciar 



    /** METODO VALIDAR
     * valida la session actual, si tiene usuario y pws válidos
     * @return boolean
     */
    public function validar()
    {
        $salida = false;
        if (isset($_SESSION['idusuario']) && $this->activa()) { // pregunta si esta seteado el id del usuario para validarlo
            $salida = true;
        } // fin if 
        return $salida;
    } // fin metodo validar

    /** METODO ACTIVA
     * @return boolean
     */
    public function activa()
    {
        $salida = false;
        if (session_status() == PHP_SESSION_ACTIVE) {
            $salida = true; // la session esta activa 
        } // fin if 

        return $salida;
    } // fin metodo activa

    /** METODO GETUSUARIO 
     * @return Usuario
     */
    public function getUsuario()
    {
        $objAbmUsuario = new AbmUsuario();
        $consulta = ['idusuario' => $_SESSION['idusuario']]; // pregunto si el usuario con 
        // esa session esta registrado. Lo busco en la BD
        $usuarios = $objAbmUsuario->buscar($consulta);
        if (count($usuarios) >= 1) {
            $usuarioRegistrado = $usuarios[0];
        } // fin if 
        return $usuarioRegistrado;
    } // fin metodo getUsuario

    /** METODO GETROLES
     * @return array
     */
    public function getRoles()
    {
        $listaRoles = [];
        $objRolesUsuarios = null;
        if ($this->getUsuario() != null) {
            $userLog = $this->getUsuario(); // almacena el obj usuario  
            $datos['idusuario'] = $userLog->getId(); // guarda el id de usuario 
            $objRolUsuario = new AbmUsuarioRol();
            $objRolesUsuarios = $objRolUsuario->buscar($datos); // busca en la tabla usuarioRol los roles que coincide con el id del usuario

            foreach ($objRolesUsuarios as $objRolUsuario) {
                array_push($listaRoles, $objRolUsuario->getObjRol());
            }
        } // fin if 
        return $listaRoles;  // puede devolver una lista de usuarios con distintos roles o un solo usuario con un unico rol
    } // fin metodo getRol

    /** METODO CERRAR 
     * @return boolean
     */
    public function cerrar()
    {
        session_destroy();
    } // fin metodo cerrar

    /** METODO SETROL
     * @param int
     */
    public function setRol($param)
    {
        $_SESSION["idRol"] = $param;
    }
    /** METODO SETROL
     * @return Rol
     */
    public function getRolActual()
    {
        $objAbmRol = New AbmRol;
        $param['idrol'] = $_SESSION["idRol"];
        $listaObj = $objAbmRol->buscar($param);
        return $listaObj[0];
    }

    /**
     * METODO permisos de headPrivado
     * @return boolean
     */
    public function permisos(){
        $objAbmMenuRol = new AbmMenuRol();
        $resp = false;
        $url = $_SERVER['SCRIPT_NAME'];
        $url = strchr($url, "Vista");
        $url = str_replace("Vista", "..", $url);
        $param['idrol'] = $this->getRolActual()->getId();
        $listaAbmMenuRol = $objAbmMenuRol->buscar($param);
        foreach ($listaAbmMenuRol as $obj) {
            if ($obj->getObjMenu()->getDescripcion() == $url) {
                $resp = true;
            }
        }
        return $resp;
    }

// fin clase Session 
}
