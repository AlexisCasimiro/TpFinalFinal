<nav class="navbar navbar-expand-lg navbar-dark bg-light sticky-top">
  <!-- Marca/logotipo -->
  <div class="text-decoration-none position-relative">
    <div class="dropdown">
      <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" aria-haspopup="true" aria-expanded="false">
        <i class="bi bi-person-fill"></i>
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a href="<?php echo $PROYECTOROOT ?>Vista/login.php" class="dropdown-item">Iniciar sesión</a>
        <a href="<?php echo $PROYECTOROOT ?>Vista/Cliente/editarPerfil.php" class="dropdown-item">Editar perfil</a>
        <a href="<?php echo $PROYECTOROOT ?>Vista/Accion/cerrarSesion.php" class="dropdown-item">Cerrar sesión</a>
      </div>
    </div>
  </div>
  <!-- Enlaces de la barra de navegación -->
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto">
        <?php if (!empty($menu)) : ?>
          <?php echo $menu;?>
        <?php endif; ?>
    </ul>
  </div>
  <?php if (!empty($menuRol)) : ?>
    <div class="d-flex align-items-center">
      <form id="roleForm" class="d-flex align-items-center" action="../Accion/cambiarRol.php">
        <select name="rolNuevo" class="form-select form-select-sm me-2 select-small">
          <?php echo $menuRol; ?>
        </select>
        <button type="submit" class="btn btn-success btn-sm">Cambiar Rol</button>
      </form>
    </div>
  <?php endif; ?>
</nav>
<script>
  // Inicializar el menú desplegable manualmente
  var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
  var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
    return new bootstrap.Dropdown(dropdownToggleEl)
  });
</script>
<script src="../Js/cambiarRol.js"></script>