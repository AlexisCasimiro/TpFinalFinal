<?php
include_once "../../configuracion.php";
include_once "../Estructura/nav.php";
$usuario = $session->getUsuario();

?>
<?php
// Verificar si hay un parámetro de error en la URL
$error=isset($_GET['error']) ? $_GET['error'] : null;
$correcto=isset($_GET['correcto']) ? $_GET['correcto'] : null;
if ($error) {
    echo "<div class='alert alert-danger alert-dismissible' role='alert'>
    <div>Tu cuenta no pudo ser modificada</div>
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}
if($correcto){
    echo "<div class='alert alert-success alert-dismissible' role='alert'>
    <div>Tu cuenta fue modificada correctamente</div>
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}
?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0">Modificar Perfil</h4>
        </div>
        <div class="card-body">
          <form id="edit-perfil" action="../Accion/modificarPerfil.php" method="POST">
            <div class="form-group">
              <label for="username">Usuario</label>
              <input type="text" class="form-control" id="username" name="usnombre" placeholder="Ingrese su nombre de usuario" value=<?php echo "'". $usuario->getNombre()."'" ?>>
               <div class="invalid-feedback">
                Debe ingresar un nombre de usuario válido
               </div>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="usmail" placeholder="Ingrese su correo electrónico" value=<?php echo "'". $usuario->getMail()."'" ?>>
              <div class="invalid-feedback">
                Debe ingresar un email válido
               </div>
            </div>
            <div class="form-group">
              <label for="current-password">Contraseña Actual</label>
              <input type="password" class="form-control" id="current-password" name="uspass" placeholder="Ingrese su contraseña actual" >
              <div class="invalid-feedback">
                Contraseña incorrecta
               </div>
            </div>
            <div class="form-group">
              <label for="new-password">Contraseña Nueva</label>
              <input type="password" class="form-control" id="new-password" name="uspassnew" placeholder="Ingrese su nueva contraseña (opcional)">
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.18.0/js/md5.min.js"></script>
<script>
    var proyectoroot="<?php echo $PROYECTOROOT;?>"
    var passActual="<?php echo $usuario->getPassword();?>";
</script>
<script src="../JS/editarPerfil.js"></script>
<?php
include_once "../Estructura/footer.php";
?>