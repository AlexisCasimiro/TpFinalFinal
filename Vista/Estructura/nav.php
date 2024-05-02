<nav class="navbar navbar-expand-lg navbar-dark bg-light sticky-top">
    <!-- Marca/logotipo -->
    <div class="text-decoration-none position-relative">
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" aria-haspopup="true" aria-expanded="false">
                <i class="bi bi-person-fill"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a href="<?php echo $PROYECTOROOT?>Vista/login.php" class="dropdown-item">Iniciar sesión</a>
                <a href="<?php echo $PROYECTOROOT?>Vista/Cliente/editarPerfil.php" class="dropdown-item">Editar perfil</a>
                <a href="<?php echo $PROYECTOROOT?>Vista/Accion/cerrarSesion.php" class="dropdown-item">Cerrar sesión</a>
            </div>
        </div>
    </div>
    <!-- Enlaces de la barra de navegación -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto">
          <li>hola</li>
          <li>como </li>
          <li>estass</li>
        </ul>
    </div>
    <div class="d-flex align-items-center">
      <span>Ver Como:</span>
      <form class="d-flex">
        <select class="form-select">
          <option value="opcion1"></option>
          <option value="opcion2">Opción 2</option>
          <option value="opcion3">Opción 3</option>
        </select>
      </form>
    </div>
</nav>
<script>
    // Inicializar el menú desplegable manualmente
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl)
    });
</script>