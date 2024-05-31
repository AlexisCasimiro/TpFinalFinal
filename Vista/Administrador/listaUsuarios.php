<?php
include_once "../../configuracion.php";
include_once "../Estructura/nav.php";
$abmUsuario=new AbmUsuario();
$listaUsuarios=$abmUsuario->buscar(null);

?>
<div class="container-fluid d-flex align-items-center justify-content-center full-height">
    <div class="text-center">
    <?php
            if (count($listaUsuarios) > 0) {
                echo "<table class='table text-center'>
                            <thead class='table-dark'>
                                <tr>
                                    <th colspan='8' class='table-dark text-center fs-4'>Usuarios</th>
                                </tr>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre de usuario</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>Rol/es</th>
                                    <th>Modificar</th>
                                    <th>Modificar Roles</th>
                                    <th>Cambiar estado</th>
                                </tr>
                            </thead>";

                // Se crea una tabla que lista a todos los usuarios
                foreach ($listaUsuarios as $usuario) {
                    if ($usuario->getId() != $_SESSION['idusuario']) {
                        echo "<tr class='align-middle'>";
                        echo "<form novalidate class='needs-validation' data-id=" . $usuario->getId() . " method='post'                                       action='../Accion/modificarLogin.php'>";
                        echo "<td>" . $usuario->getId() . "<input type='hidden' name='idusuario' value='" . $usuario->getId() . "'></td>";
                        echo "<td><input  disabled name='usnombre' class='form-control cursor-text  border border-0 text-center rounded-5' maxlength='50' id='inputnombre" . $usuario->getId() . "' type='text' value='" . $usuario->getNombre() . "' placeholder='Nombre de usuario'></td>";
                        echo "<td><input  disabled name='usmail' class='form-control cursor-text  border border-0 text-center rounded-5' maxlength='50'  id='inputmail" . $usuario->getId() . "' type='email' value='" . $usuario->getMail() . "' placeholder='ejemplo@gmail.com'></td>";
                        $estaHabilitado = is_null($usuario->getHabilitado());
                        echo "<td class='col-2'>" . ($estaHabilitado ? 'Activo' : 'Deshabilitado desde: ' . $usuario->getHabilitado()) . "<input type='hidden' name='usdeshabilitado' value='" . $usuario->getHabilitado() . "'></td>";
                        echo "<td>";
                        $arrayUsuarioRol['idusuario'] = $usuario->getId();
                        $objUsuarioRol = new AbmUsuarioRol;
                        $arrayUserRol = $objUsuarioRol->buscar($arrayUsuarioRol);
                        if (count($arrayUserRol) > 0) {
                            $i = 0;
                            foreach ($arrayUserRol as $unRol) {
                                $nombreRol = $unRol->getObjRol()->getRolDesc();

                                echo $nombreRol;

                                if ($i + 1 < count($arrayUserRol)) {
                                    echo ", ";
                                }
                                $i++;
                            }
                        }
                        echo "</td>";

                        // Boton para activar modificación de los datos
                        echo "<td><div class='d-flex h-100 justify-content-around' id='columnaBotones" . $usuario->getId() . "'><button type='submit' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Cambiar datos' data-bs-custom-class='custom-tooltip' class='btn btn-primary btn-modificar' id='btn-modificar-" . $usuario->getId() . "'>Editar</button></div></td>";

                        echo "</form>";
                        echo "<td class='col-2'><button class='btn btn-primary' onclick='redirectToModRoles()'>Cambiar Roles</button></td>";
                        // Boton para deshabilitar o habilitar

                        echo "<td>
                                <form method='post' action='../Accion/" . ($estaHabilitado ? "eliminar" : "habilitar") . "Login.php'>
                                    <input type='hidden' name='idusuario' value='" . $usuario->getId() . "'> 
                                    <button type='submit' class='btn btn-" . ($estaHabilitado ? "danger" : "success") . "' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='" . ($estaHabilitado ? "Deshabilitar" : "Habilitar") . " al usuario' data-bs-custom-class='custom-tooltip-" . ($estaHabilitado ? "danger" : "success") . "' name='" . ($estaHabilitado ? "deshabilitar" : "habilitar") . "'>" . ($estaHabilitado ? "Deshabilitar" : "Habilitar") . "</button>
                                </form>
                            </td>";
                        echo "</tr>";
                    }
                }
                echo "</table>";
            } else {
                echo "<h3 class='text-center'>No hay Usuarios registrados</h3>";
            }
            ?>
    </div>
</div>

<?php
include_once "../Estructura/footer.php";
?>