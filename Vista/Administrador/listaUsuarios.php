<?php
include_once "../../configuracion.php";
include_once "../Estructura/nav.php";

$abmUsuario = new AbmUsuario();
$listaUsuarios = $abmUsuario->buscar(null);

?>
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="my-2">Usuarios</h4>
                </div>
                <div class="card-body">
                    <?php
                    if (count($listaUsuarios) > 0) {
                        echo "<div class='table-responsive'>";
                        echo "<table class='table table-bordered table-striped text-center'>";
                        echo "<thead class='table-primary'>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>Roles</th>
                                    <th>Modificar roles</th>
                                    <th>Dar de baja</th>
                                </tr>
                              </thead>
                              <tbody>";
                        foreach ($listaUsuarios as $unusuario) {
                            $estaHabilitado = is_null($unusuario->getDeshabilitado());
                            echo "<tr class='align-middle'>";
                            echo "<td>{$unusuario->getId()}<input type='hidden' name='idusuario' value='{$unusuario->getId()}'></td>";
                            echo "<td>{$unusuario->getNombre()}</td>";
                            echo "<td>{$unusuario->getMail()}</td>";
                            echo "<td class='col-2 " . ($estaHabilitado ? "text-success" : "text-danger") . "'>" . 
                                    ($estaHabilitado ? 'Activo' : 'Deshabilitado desde: ' . $unusuario->getDeshabilitado()) . 
                                    "<input type='hidden' name='usdeshabilitado' value='{$unusuario->getDeshabilitado()}'></td>";
                            echo "<td>";
                            $objUsuarioRol = new AbmUsuarioRol;
                            $arrayUserRol = $objUsuarioRol->buscar(['idusuario' => $unusuario->getId()]);
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
                            echo "<td><a href='./rolesUsuarios.php'><button class='btn btn-primary'>Administrar Roles</button></a></td>";
                            if ($estaHabilitado) {
                                echo "<td><button type='button' class='btn btn-danger' onclick='confirmarBaja(" . $unusuario->getId() . ")'>Dar de baja</button></td>";
                            } else {
                                echo "<td><button type='button' class='btn btn-success' onclick='habilitarUsuario(" . $unusuario->getId() . ")'>Habilitar</button></td>";
                            }
                            echo "</tr>";
                        }
                        echo "</tbody></table></div>";
                    } else {
                        echo "<h2 class='text-center text-primary'>No se encontraron usuarios</h2>";
                    }
                    ?>
                </div>
            </div>
        </div>
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