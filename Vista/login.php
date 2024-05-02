<?php
include_once "../configuracion.php";
include_once "./Estructura/nav.php";

?>
<!-- Modal de Registro -->
<div id="registroModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registro de Usuario</h5>
                <button type="button" class="btn-close" onclick="esconderModal()" data-dismiss="modal" aria-label="Close">
            </div>
            <div class="modal-body">
                <form action="./Accion/verificarRegistro.php" method="post" id="registroForm">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        <small id="error-password" class="text-danger"></small> <!-- Mensaje de error -->
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Registrarse</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
// Verificar si hay un parámetro de error en la URL
$error=isset($_GET['error']) ? $_GET['error'] : null;
$existe=isset($_GET['existe']) ? $_GET['existe'] : null;
$registrado=isset($_GET['registrado']) ? $_GET['registrado'] : null;
// Mostrar un mensaje de error si hay un error
if ($error) {
    echo "<div class='alert alert-danger d-flex justify-content-center align-items-center' role='alert' style='height: 50px;'>
            Credenciales incorrectas. Por favor, intenta nuevamente.
          </div>";
}
if($existe){
    echo "<div class='alert alert-danger d-flex justify-content-center align-items-center' role='alert' style='height: 50px;'>
            Ya se registro un usuario con ese email. Intente nuevamente
          </div>";
}
if($registrado){
    echo "<div class='alert alert-success d-flex justify-content-center align-items-center' role='alert' style='height: 50px;'>
            ¡Registrado exitosamente!
          </div>";
}
?>

<div id="contenedor">
    <div id="contenedorcentrado">
        <div id="login">
            <form action="./Accion/verificarLogin.php" method="post" class="needs-validation" id="loginform">
                <label for="email">Email</label>
                <input id="usuario" type="text" name="email" placeholder="Email" required>
                        
                <label for="password">Contraseña</label>
                <input id="password" type="password" placeholder="Contraseña" name="password" required>
                        
                <button type="submit" title="Ingresar" name="Ingresar" class="bg-primary">Login</button>
            </form>
        </div>
        <div id="derecho">
            <div class="titulo">
                Bienvenido
            </div>
            <hr>
            <div class="pie-form">
                <a href="#" id="registroLink" class="text-success-emphasis">¿No tienes Cuenta? Registrate</a>
                <hr>
                <a href="<?php echo $PROYECTOROOT?>Vista/Cliente/indexCliente.php">« Volver</a>
            </div>
        </div>
    </div>
</div>
<script src="./Js/modalRegistroo.js"></script>
<script>
    function esconderModal() {
        $('#registroModal').modal('hide');
    }
</script>
<?php
include_once "./Estructura/footer.php";
?>