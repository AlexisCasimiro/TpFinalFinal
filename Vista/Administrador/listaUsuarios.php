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
                            <thead class='table-primary'>
                                <tr>
                                    <th colspan='8' class='table-dark text-center fs-4'>Usuarios</th>
                                </tr>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>Roles</th>
                                    <th>Modificar roles</th>
                                    <th>Dar de baja</th>
                                </tr>
                            </thead>";
                foreach($listaUsuarios as $unusuario){
                    echo "<tr class='align-middle'>";
                    echo "<td>" . $unusuario->getId() . "<input type='hidden' name='idusuario' value='" . $unusuario->getId() . "'></td>";
                    echo "<td>". $unusuario->getNombre() ."";
                    echo "<td>". $unusuario->getMail(). "</td>";
                    //habilitado o deshabilitado
                    $estaHabilitado = is_null($unusuario->getDeshabilitado());
                    echo "<td class='col-2 " . ($estaHabilitado ? "text-success" : "text-danger") . "'>" . 
                            ($estaHabilitado ? 'Activo' : 'Deshabilitado desde: ' . $unusuario->getDeshabilitado()) . 
                            "<input type='hidden' name='usdeshabilitado' value='".$unusuario->getDeshabilitado()."'></td>";
                    //lista de roles
                    echo "<td>";
                    $objUsuarioRol = new AbmUsuarioRol;
                    $arrayUserRol = $objUsuarioRol->buscar(['idusuario'=>$unusuario->getId()]);
                    if (count($arrayUserRol) > 0) {
                        $i = 0;
                        foreach ($arrayUserRol as $unRol) {
                            $nombreRol = $unRol->getObjRol()->getDescripcion();
                            echo $nombreRol;
                            if ($i + 1 < count($arrayUserRol)) {
                                echo ", ";
                            }
                            $i++;
                        }
                    }
                    echo "</td>";
                    //modificar roles ->boton que lleve a modificar roles
                    echo "<td><a href='./rolesUsuarios.php'><button class='btn btn-primary'>Administrar Roles</button></td>";
                    //dar de baja->boton 
                    if ($estaHabilitado) {
                        echo "<td><button type='button' class='btn btn-danger' onclick='confirmarBaja(" . $unusuario->getId() . ")'>Dar de baja</button></td>";
                    } else {
                        echo "<td><button type='button' class='btn btn-success' onclick='habilitarUsuario(" . $unusuario->getId() . ")'>Habilitar</button></td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<h2 class='text-center text-primary'>No se encontró usuarios</h2>";
            }
            ?>
    </div>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmar acción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro que desea <span id="modalActionText"></span> este usuario?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmActionButton">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<script src="../Js/modificarUsuario.js"></script>
<?php
include_once "../Estructura/footer.php";
?>