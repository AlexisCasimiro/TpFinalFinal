<?php
include_once "../../configuracion.php";
include_once "../Estructura/nav.php";
$objUsuario = new AbmUsuario();
$listaUsuarios = $objUsuario->buscar(null);
?>
<div class="container-fluid d-flex align-items-center justify-content-center full-height">
    <div class="text-center">
    <?php
            if (count($listaUsuarios) > 0) {
                echo "<table class='table text-center'>
                            <thead class='table-primary'>
                                <tr>
                                    <th colspan='8' class='table-dark text-center fs-4'>Roles de usuarios</th>
                                </tr>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Roles</th>
                                </tr>
                            </thead>";
                echo "<form>";
                foreach ($listaUsuarios as $usuario) {
                    echo "<tr class='align-middle'>";
                }
                echo "</table>";
            }else {
                echo "<h2 class='text-center text-primary'>No se encontró usuarios</h2>";
            }
            ?>
    </div>
</div>

<?php
include_once "../Estructura/footer.php";
?>