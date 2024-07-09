<?php
include_once "../../configuracion.php";
include_once "../Estructura/nav.php";

$objUsuario = new AbmUsuario();
$objRol = new AbmRol();
$objUsuarioRol = new AbmUsuarioRol();

$listaUsuarios = $objUsuario->buscar(null);
$listaRoles = $objRol->buscar(null);
?>
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="my-2">Roles de usuarios</h4>
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
                                    <th>Roles</th>
                                    <th>Acciones</th>
                                </tr>
                              </thead>
                              <tbody>";
                        foreach ($listaUsuarios as $usuario) {
                            $rolesUsuario = $objUsuarioRol->buscar(['idusuario' => $usuario->getId()]);

                            $rolesUsuarioIds = [];
                            foreach ($rolesUsuario as $rolUsuario) {
                                $rolesUsuarioIds[] = $rolUsuario->getObjRol()->getId();
                            }

                            echo "<tr class='align-middle'>";
                            echo "<td>{$usuario->getId()}</td>";
                            echo "<td>{$usuario->getNombre()}</td>";
                            echo "<td>";
                            echo "<form method='post' action='../Accion/actualizarRoles.php' class='d-flex flex-column align-items-start'>";
                            echo "<input type='hidden' name='idusuario' value='{$usuario->getId()}'>";
                            foreach ($listaRoles as $rol) {
                                $checked = in_array($rol->getId(), $rolesUsuarioIds) ? "checked" : "";
                                $disabled = ($_SESSION['idusuario'] == $usuario->getId() && $rol->getDescripcion() == 'Administrador') ? "disabled" : "";
                                echo "<div class='form-check'>";
                                echo "<input class='form-check-input' type='checkbox' name='roles[]' value='{$rol->getId()}' $checked $disabled>";
                                echo "<label class='form-check-label ms-1'>{$rol->getDescripcion()}</label>";
                                echo "</div>";
                                // Añadir un campo oculto para mantener el rol de Administrador si el checkbox está deshabilitado
                                if ($disabled) {
                                    echo "<input type='hidden' name='roles[]' value='{$rol->getId()}'>";
                                }
                            }
                            echo "</td>";
                            echo "<td>";
                            echo "<button type='submit' class='btn btn-primary btnActualizarRoles'>Actualizar</button>";
                            echo "</form>";
                            echo "</td>";
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
<script src="../Js/editarRolesUsuarioss.js"></script>
<?php
include_once "../Estructura/footer.php";
?>
