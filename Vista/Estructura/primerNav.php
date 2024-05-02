<header class="bg-light d-flex align-items-center justify-content-between p-2 fixed-top">
    <div class="text-decoration-none text-light position-relative">
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" aria-haspopup="true" aria-expanded="false">
                <i class="bi bi-person-fill"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a href="<?php echo $PROYECTOROOT?>Vista/login.php" class="dropdown-item">Iniciar sesión</a>
                <a href="<?php echo $PROYECTOROOT?>Vista" class="dropdown-item">Configuración</a>
                <a href="<?php echo $PROYECTOROOT?>Vista" class="dropdown-item">Cerrar sesión</a>
            </div>
        </div>
    </div>
    <h4 class="text-primary mx-auto">Alexis Casimiro</h4>
    <nav class="navbar navbar-expand-lg navbar-light bg-light position-relative">
        <div class="container-fluid">
            <span class="navbar-text me-2">Ver como:</span>
            <form class="d-flex">
                <select class="form-select">
                    <option value="opcion1"></option>
                    <option value="opcion2">Opción 2</option>
                    <option value="opcion3">Opción 3</option>
                </select>
            </form>
        </div>
        <!-- acá falta agregar para que se vea el menu --->
        <div class="d-flex justify-content-center">
            <ul class="nav nav-pills justify-content-center align-items-center gap-2">
                <li>hola</li>
                <li>como </li>
                <li>estass</li>
            </ul>
        </div>
    </nav>
</header>

<script>
    // Inicializar el menú desplegable manualmente
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl)
    });
</script>
