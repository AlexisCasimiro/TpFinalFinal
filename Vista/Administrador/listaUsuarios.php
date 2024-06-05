<?php
include_once "../../configuracion.php";
include_once "../Estructura/nav.php";
$abmUsuario=new AbmUsuario();
$listaUsuarios=$abmUsuario->buscar(null);

?>
<style>
    footer{
        position: absolute; /* Fijar al fondo de la página */
        bottom: 0;
        width: 100%;
    }
</style>
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
                                    <th>Nombre de usuario</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>Modificar</th>
                                    <th>Cambiar estado</th>
                                    <th>Roles</th>
                                </tr>
                            </thead>";
                foreach($listaUsuarios as $unusuario){
                    echo "<tr class='align-middle'>";
                    echo "<form novalidate class='needs-validation' data-id=" . $unusuario->getId() . " method='post' action='../Accion/modificarLogin.php'>";
                    echo "<td>" . $unusuario->getId() . "<input type='hidden' name='idusuario' value='" . $unusuario->getId() . "'></td>";
                    echo "<td><input name='usnombre' type='text' value='". $unusuario->getNombre() ."'></td>";
                    echo "<td><input name='usmail' type='email' value='". $unusuario->getMail(). "' ></td>";
                    $estaHabilitado = is_null($unusuario->getDeshabilitado());
                    echo "<td class='col-2'>" . ($estaHabilitado ? 'Activo' : 'Deshabilitado desde: ' . $unusuario->getDeshabilitado()) . "<input type='hidden' name='usdeshabilitado' value='".$unusuario->getDeshabilitado()."'></td>";
                    
                }

                echo "</table>";
            } else {
                echo "<h2 class='text-center text-primary'>No se encontró usuarios</h2>";
            }
            ?>
    </div>
</div>

<?php
include_once "../Estructura/footer.php";
?>