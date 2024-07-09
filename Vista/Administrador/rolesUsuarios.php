<?php
include_once "../../configuracion.php";
include_once "../Estructura/nav.php";

$objUsuario = new AbmUsuario();
$objRol = new AbmRol();
$objUsuarioRol = new AbmUsuarioRol();

$listaUsuarios = $objUsuario->buscar(null);
$listaRoles = $objRol->buscar(null);
?>
<div class="container-fluid d-flex align-items-center justify-content-center full-height">
    <div class="text-center">
    <?php
    if (count($listaUsuarios) > 0) {
        echo "<table class='table text-center'>
                    <thead class='table-primary'>
                        <tr>
                            <th colspan='4' class='table-dark text-center fs-4'>Roles de usuarios</th>
                        </tr>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Roles</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>";
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
            echo "<form method='post' action='../Accion/actualizarRoles.php'>";
            echo "<input type='hidden' name='idusuario' value='{$usuario->getId()}'>";
            foreach ($listaRoles as $rol) {
                $checked = in_array($rol->getId(), $rolesUsuarioIds) ? "checked" : "";
                $disabled = ($_SESSION['idusuario'] == $usuario->getId() && $rol->getDescripcion() == 'Administrador') ? "disabled" : "";
                echo "<div class='form-check'>";
                echo "<input class='form-check-input' type='checkbox' name='roles[]' value='{$rol->getId()}' $checked $disabled>";
                echo "<label class='form-check-label'>{$rol->getDescripcion()}</label>";
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
        echo "</table>";
    } else {
        echo "<h2 class='text-center text-primary'>No se encontraron usuarios</h2>";
    }
    ?>
    </div>
</div>
<script src="../Js/editarRolesUsuarioss.js"></script>
<?php
include_once "../Estructura/footer.php";
?>
